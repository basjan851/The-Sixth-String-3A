<?php

require_once '../helpers/databaseconnector.php';
$conn = connect_db();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $conn->real_escape_string($_POST["id"]);
    $productnaam = ucwords($conn->real_escape_string($_POST["productnaam"]));
    $beschrijving = ucwords($conn->real_escape_string($_POST["beschrijving"]));
    $prijs = ucwords($conn->real_escape_string($_POST["prijs"]));
    $voorraad = $conn->real_escape_string($_POST["voorraad"]);
    $kortingspercentage = ucwords($conn->real_escape_string($_POST["kortingspercentage"]));
    $actief = isset($_POST["actief"]) ? 1 : 0;

    $sql = "UPDATE producten SET 
                productnaam='$productnaam', 
                beschrijving='$beschrijving', 
                prijs='$prijs', 
                voorraad='$voorraad', 
                kortingspercentage='$kortingspercentage', 
                actief=$actief
                WHERE Id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ./productbeheer.php");
        exit();
    } else {
        echo "<p class='error-message'>Fout bij bijwerken: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Sixth String</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        main {
            padding: 20px;
            flex: 1;
        }
        .wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
        .data {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }
        h1, h2 {
            color: #333;
        }
        .error-message {
            color: red;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .button {
            background-color: #5cb85c;
            padding: 10px 15px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            height: 40px;
            width: 110px;
            display: inline-block;
            text-align: center;
        }
        .button:hover {
            background-color: #4cae4c;
        }
        .cancel-button {
            padding: 10px 15px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .cancel-button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <main class="content">
        <div class="data">
            <h1>Productgegevens wijzigen</h1>
            <?php
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                echo "<p class='error-message'>Fout: Product niet gevonden. Zorg ervoor dat een geldig product-ID is opgegeven.</p>";
            } else {
                $id = $conn->real_escape_string($_GET['id']);
                $result = $conn->query("SELECT * FROM producten WHERE Id = $id");
                $product = $result->fetch_assoc();

                if (!$product) {
                    echo "<p class='error-message'>Product niet gevonden.</p>";
                }
            }
            ?>
            <?php if (isset($product)): ?>
                <form method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                    <label>Naam:</label><br>
                    <input type="text" name="productnaam" value="<?= htmlspecialchars($product['productnaam']) ?>"><br><br>

                    <label>Beschrijving:</label><br>
                    <textarea name="beschrijving" rows="4" cols="50"><?= htmlspecialchars($product['beschrijving']) ?></textarea><br><br>

                    <label>Prijs:</label><br>
                    <input type="text" name="prijs" value="<?= htmlspecialchars($product['prijs']) ?>"><br><br>

                    <label>Voorraad:</label><br>
                    <input type="text" name="voorraad" value="<?= htmlspecialchars($product['voorraad']) ?>"><br><br>

                    <label>Korting(in %):</label><br>
                    <input type="text" name="kortingspercentage" value="<?= htmlspecialchars($product['kortingspercentage']) ?>"><br><br>

                    <label>Actief:</label><br>
                    <input type="checkbox" name="actief" <?= $product['actief'] ? 'checked' : '' ?>><br><br>

                    <button type="submit" class="button">Opslaan</button>
                    <a href="./productbeheer.php" class="button cancel-button">Annuleren</a>
                </form>
            <?php else: ?>
                <a href="./productbeheer.php" class="button cancel-button">Terug</a>
            <?php endif; ?>
        </div>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>