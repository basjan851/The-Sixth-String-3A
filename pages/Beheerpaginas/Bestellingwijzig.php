<?php
// Inclusie van benodigde bestanden
require_once 'helpers/databaseconnector.php';
require_once 'helpers/rolecheck.php';

// Haal de order_id op uit de URL
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Controleer of een geldige order_id is opgegeven
if ($order_id === 0) {
    echo "<h1>Geen geldig ID opgegeven!</h1>";
    exit;
}

// Haal bestelling gegevens op uit de database
$sql = "SELECT * FROM bestellingen WHERE id = ?";
$db = connect_db();
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    $verzendkosten = $order['verzendkosten'] ?? 0; // Controleer of verzendkosten bestaan in de tabel
} else {
    echo "Bestelling niet gevonden.";
    exit;
}

// Haal de producten op die aan deze bestelling zijn gekoppeld
$sql = "SELECT p.productnaam, p.prijs, bp.aantal, (p.prijs * bp.aantal) AS totaalprijs 
        FROM koppeltabel_bestelling_product bp
        JOIN producten p ON bp.producten_id = p.id
        WHERE bp.bestellingen_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$product_result = $stmt->get_result();

// Bereken totaalbedrag van de producten
$totaal_product_prijs = 0;
while ($product = $product_result->fetch_assoc()) {
    $totaal_product_prijs += $product['totaalprijs'];
}

// Bereken totaalbedrag inclusief verzendkosten
$totaalbedrag = $totaal_product_prijs + $verzendkosten;

// Verwerk formulier indien verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? '';
    $betaalstatus = $_POST['betaalstatus'] ?? '';
    $verzendmethode = $_POST['verzendmethode'] ?? '';
    $tracktrace = $_POST['tracktrace'] ?? '';

    // Valideer invoer
    if (empty($status) || empty($betaalstatus) || empty($verzendmethode)) {
        echo "Alle velden zijn verplicht.";
    } else {
        // Werk bestelling bij in de database
        $sql = "UPDATE bestellingen SET status = ?, betaalstatus = ?, verzendmethode = ?, track_and_trace = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssssi", $status, $betaalstatus, $verzendmethode, $tracktrace, $order_id);

        if ($stmt->execute()) {
            echo "Bestelling succesvol bijgewerkt.";
            // Optioneel: redirect terug naar overzicht
            header("Location: index.php?page=Beheerpaginas/Bestellingbeheer");
            exit;
        } else {
            echo "Er is een fout opgetreden bij het bijwerken van de bestelling.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Wijzigen</title>
</head>
<body>
<div class="container my-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Bestelling #<?= $order_id ?> Wijzigen</h4>
        </div>
        <div class="card-body">
            <form action="index.php?page=Beheerpaginas/Bestellingwijzig&id=<?= $order_id ?>" method="POST"" method="POST">
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="Verzonden" <?= $order['status'] === 'Verzonden' ? 'selected' : '' ?>>Verzonden</option>
                        <option value="In behandeling" <?= $order['status'] === 'In behandeling' ? 'selected' : '' ?>>In behandeling</option>
                        <option value="Geannuleerd" <?= $order['status'] === 'Geannuleerd' ? 'selected' : '' ?>>Geannuleerd</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="betaalstatus" class="form-label">Betaalstatus</label>
                    <select id="betaalstatus" name="betaalstatus" class="form-select">
                        <option value="Betaald" <?= $order['betaalstatus'] === 'Betaald' ? 'selected' : '' ?>>Betaald</option>
                        <option value="Niet Betaald" <?= $order['betaalstatus'] === 'Niet Betaald' ? 'selected' : '' ?>>Niet Betaald</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="verzendmethode" class="form-label">Verzendmethode</label>
                    <input type="text" id="verzendmethode" name="verzendmethode" class="form-control" value="<?= htmlspecialchars($order['verzendmethode']) ?>">
                </div>
                <div class="mb-3">
                    <label for="tracktrace" class="form-label">Track & Trace</label>
                    <input type="text" id="tracktrace" name="tracktrace" class="form-control" value="<?= htmlspecialchars($order['track_and_trace']) ?>">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
            <h4>Producten in Bestelling</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Productnaam</th>
                    <th>Aantal</th>
                    <th>Prijs</th>
                    <th>Totaalprijs</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Reset product_result pointer
                $product_result->data_seek(0);
                while ($product = $product_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['productnaam']) ?></td>
                        <td><?= $product['aantal'] ?></td>
                        <td>€<?= number_format($product['prijs'], 2, ',', '.') ?></td>
                        <td>€<?= number_format($product['totaalprijs'], 2, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <div class="card-body mt-4">
                <p><strong>Verzendkosten:</strong> €<?= number_format($verzendkosten, 2, ',', '.') ?></p>
                <p><strong>Totaalbedrag:</strong> €<?= number_format($totaalbedrag, 2, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
