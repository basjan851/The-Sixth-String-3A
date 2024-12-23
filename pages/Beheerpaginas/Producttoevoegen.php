<?php
$conn = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productnaam = $_POST['productnaam'] ?? '';
    $beschrijving = $_POST['beschrijving'] ?? '';
    $prijs = $_POST['prijs'] ?? 0;
    $voorraad = $_POST['voorraad'] ?? 0;
    $kortingspercentage = $_POST['kortingspercentage'] ?? 0;
    $actief = isset($_POST['actief']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO producten (productnaam, beschrijving, prijs, voorraad, kortingspercentage, actief) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdiid', $productnaam, $beschrijving, $prijs, $voorraad, $kortingspercentage, $actief);

    if ($stmt->execute()) {
        $message = "Product succesvol toegevoegd!";
    } else {
        $message = "Fout bij het toevoegen van product: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h6 class="p-2">Beheer>Producten>Toevoegen</h6>

            <?php if (!empty($message)): ?>
                <div class="alert alert-info">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="p-4 border rounded">
                <div class="mb-3">
                    <label for="productnaam" class="form-label">Productnaam</label>
                    <input type="text" class="form-control" id="productnaam" name="productnaam" required>
                </div>
                <div class="mb-3">
                    <label for="beschrijving" class="form-label">Beschrijving</label>
                    <textarea class="form-control" id="beschrijving" name="beschrijving" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="prijs" class="form-label">Prijs</label>
                    <input type="number" class="form-control" id="prijs" name="prijs" required>
                </div>
                <div class="mb-3">
                    <label for="voorraad" class="form-label">Voorraad</label>
                    <input type="number" class="form-control" id="voorraad" name="voorraad" required>
                </div>
                <div class="mb-3">
                    <label for="kortingspercentage" class="form-label">Kortingspercentage</label>
                    <input type="number" class="form-control" id="kortingspercentage" name="kortingspercentage">
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="actief" name="actief">
                    <label class="form-check-label" for="actief">Actief</label>
                </div>
                <div class="d-flex gap-2">
                    <button href="index.php?page=beheerpaginas/Productbeheer" type="submit" class="btn btn-primary">Toevoegen</button>
                    <a href="index.php?page=beheerpaginas/Productbeheer" class="btn btn-danger">Annuleren</a>
                </div>

            </form>
    </body>
</html>
