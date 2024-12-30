<?php
require_once 'helpers/databaseconnector.php';

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user']['id'])) {
    die("Gebruiker is niet ingelogd.");
}

$gebruiker_id = $_SESSION['user']['id'];
$db = connect_db();

// Begin een database-transactie
$db->begin_transaction();

try {
    // Stap 1: Bereken het totaalbedrag van de winkelwagen
    $query = "SELECT SUM(p.prijs * w.aantal) AS totaal_waarde
              FROM winkelwagen w
              JOIN producten p ON w.product_id = p.id
              WHERE w.gebruiker_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $gebruiker_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $totaal_waarde = $result->fetch_assoc()['totaal_waarde'] ?? 0;

    if ($totaal_waarde <= 0) {
        throw new Exception("Winkelwagen is leeg.");
    }

    $exclbtw = $totaal_waarde * 0.79;

    // Stap 2: Voeg een nieuwe bestelling toe aan de `bestellingen`-tabel
    $query = "INSERT INTO bestellingen (gebruiker_id, totaal_waarde, status, datum)
              VALUES (?, ?, 'in behandeling', NOW())";
    $stmt = $db->prepare($query);
    $stmt->bind_param("id", $gebruiker_id, $totaal_waarde);
    $stmt->execute();

    // Haal het ID van de nieuwe bestelling op
    $bestelling_id = $db->insert_id;

    // Stap 3: Haal producten uit de winkelwagen op
    $query = "SELECT w.product_id, w.aantal, p.prijs
              FROM winkelwagen w
              JOIN producten p ON w.product_id = p.id
              WHERE w.gebruiker_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $gebruiker_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Stap 4: Voeg producten toe aan de `koppeltabel_bestelling_product`-tabel
    $query = "INSERT INTO koppeltabel_bestelling_product (bestellingen_id, producten_id, aantal, prijs)
              VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $aantal = $row['aantal'];
        $prijs = $row['prijs'];

        // Zorg dat je $bestelling_id gebruikt, niet $bestellingen_id
        $stmt->bind_param("iiid", $bestelling_id, $product_id, $aantal, $prijs);
        $stmt->execute();
    }

    // Stap 5: Leeg de winkelwagen
    $query = "DELETE FROM winkelwagen WHERE gebruiker_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $gebruiker_id);
    $stmt->execute();

    // Commit de transactie
    $db->commit();

    echo "Bestelling succesvol geplaatst!";
} catch (Exception $e) {
    // Rol de transactie terug bij een fout
    $db->rollback();
    die("Er is een fout opgetreden: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Plaatsen</title>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-9">
            <form method="POST" action="/api/bestel/place_order.php" class="needs-validation" novalidate>
                <!-- Voeg CSRF-token toe -->
                <input type="hidden" name="csrf_token" value="PLACEHOLDER_FOR_CSRF_TOKEN">

                <!-- Factuurgegevens -->
                <div class="card mb-4">
                    <div class="card-header"><h4>Factuurgegevens</h4></div>
                    <div class="card-body">
                        <div class="row gx-3 gy-2">
                            <!-- Voornaam -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="voornaam" name="voornaam" placeholder="Voornaam" pattern="^[A-Za-z\s]+$" required aria-label="Voornaam">
                                <div class="invalid-feedback">Voer een geldige voornaam in (alleen letters).</div>
                            </div>
                            <!-- Achternaam -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="achternaam" name="achternaam" placeholder="Achternaam" pattern="^[A-Za-z\s]+$" required aria-label="Achternaam">
                                <div class="invalid-feedback">Voer een geldige achternaam in (alleen letters).</div>
                            </div>
                            <!-- Adres -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="adres" name="adres" placeholder="Adres" pattern="^[A-Za-z0-9\s,]+$" required aria-label="Adres">
                                <div class="invalid-feedback">Voer een geldig adres in.</div>
                            </div>
                            <!-- Telefoon -->
                            <div class="col-md-6">
                                <input type="tel" class="form-control" id="telefoon" name="telefoon" placeholder="Telefoonnummer" pattern="^[0-9]{10}$" required aria-label="Telefoonnummer">
                                <div class="invalid-feedback">Voer een geldig telefoonnummer in (10 cijfers).</div>
                            </div>
                            <!-- Plaatsnaam -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="plaatsnaam" name="plaatsnaam" placeholder="Plaatsnaam" pattern="^[A-Za-z\s]+$" required aria-label="Plaatsnaam">
                                <div class="invalid-feedback">Voer een geldige plaatsnaam in.</div>
                            </div>
                            <!-- Postcode -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode" pattern="^[0-9]{4}[A-Z]{2}$" required aria-label="Postcode">
                                <div class="invalid-feedback">Voer een geldige postcode in (bijv. 1234AB).</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verzendgegevens -->
                <div class="card mb-4">
                    <div class="card-header"><h4>Verzendgegevens</h4></div>
                    <div class="card-body">
                        <div class="row gx-3 gy-2">
                            <!-- Land -->
                            <div class="col-md-6">
                                <select class="form-select" id="land" name="land" required aria-label="Land">
                                    <option selected disabled value="">Selecteer een land</option>
                                    <option value="Nederland">Nederland</option>
                                    <option value="België">België</option>
                                    <option value="Duitsland">Duitsland</option>
                                </select>
                                <div class="invalid-feedback">Selecteer een land.</div>
                            </div>
                            <!-- Straatnaam -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="straatnaam" name="straatnaam" placeholder="Straatnaam" pattern="^[A-Za-z\s]+$" required aria-label="Straatnaam">
                                <div class="invalid-feedback">Voer een geldige straatnaam in.</div>
                            </div>
                            <!-- Plaatsnaam verzending -->
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="plaatsnaam_verzending" name="plaatsnaam_verzending" placeholder="Plaatsnaam" pattern="^[A-Za-z\s]+$" required aria-label="Plaatsnaam verzending">
                                <div class="invalid-feedback">Voer een geldige plaatsnaam in.</div>
                            </div>
                            <!-- Postcode verzending -->
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="postcode_verzending" name="postcode_verzending" placeholder="Postcode" pattern="^[0-9]{4}[A-Z]{2}$" required aria-label="Postcode verzending">
                                <div class="invalid-feedback">Voer een geldige postcode in.</div>
                            </div>
                            <!-- Huisnummer -->
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="huisnummer_verzending" name="huisnummer_verzending" placeholder="Huisnummer" pattern="^[0-9]+[A-Za-z]?$" required aria-label="Huisnummer verzending">
                                <div class="invalid-feedback">Voer een geldig huisnummer in.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Betaalopties -->
                <div class="card mb-4">
                    <div class="card-header"><h5>Betaalmethode Selecteren</h5></div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="betaalmethode" id="paypal" value="PayPal" required>
                            <label class="form-check-label" for="paypal">PayPal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="betaalmethode" id="ideal" value="iDeal" required>
                            <label class="form-check-label" for="ideal">iDeal</label>
                        </div>
                        <div class="invalid-feedback">Selecteer een betaalmethode.</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Bestelling Plaatsen</button>
            </form>
        </div>

        <div class="col-md-3">
            <!-- Samenvatting Bestelling -->
            <div class="card mb-4">

                <div class="card-header"><h5>Samenvatting Bestelling</h5></div>
                <div class="card-body">
                    <?php echo "<h5>Waarde excl btw €" . number_format($exclbtw, 2, ',', '.') . "</h5>"; ?>
                    <hr class="border-3">
                    <?php echo "<h3>Totaal €" . number_format($totaal_waarde, 2, ',', '.') . "</h3>"; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Bootstrap validation script
    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
</body>
</html>
