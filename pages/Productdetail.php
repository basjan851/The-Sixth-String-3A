<?php

require_once '../helpers/databaseconnector.php';

$Id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default productId is 1
$sql = "SELECT * FROM producten WHERE Id = $Id";
$result = connect_db()->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();

    // Controleer op korting en bereken de nieuwe prijs
    $oudePrijs = $product['prijs'];
    $korting = isset($product['kortingspercentage']) ? $product['kortingspercentage'] : 0; // Verwacht percentage
    $nieuwePrijs = $korting > 0 ? $oudePrijs * ((100 - $korting) / 100) : $oudePrijs;
} else {
    die("Product niet gevonden.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?php echo htmlspecialchars($product['productnaam']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F9F9F9;
            margin: 0;
            padding: 0;
            color: #0F0F0F;
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
        .standard-height {
            min-height: 600px;
        }
        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product-image {
            flex: 1;
            background-color: #E5E5E5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 300px;
        }
        .product-details {
            flex: 2;
            background-color: #FFF;
            padding: 20px;
            border: 1px solid #E5E5E5;
        }
        .product-details h1 {
            color: #007BFF;
        }
        .product-details .prijs {
            color: #FF0033;
            font-size: 24px;
            margin: 10px 0;
        }
        .product-details button {
            background-color: #007BFF;
            color: #FFF;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .product-details button.disabled {
            background-color: #CCCCCC;
            color: #666666;
            cursor: not-allowed;
        }
        .product-details button:hover:not(.disabled) {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <main class="content">
        <div class="container standard-height">
            <h3>Productdetails</h3>
            <h6>Home > Producten > <?php echo htmlspecialchars($product['productnaam']); ?></h6>
            <div class="product-container">
                <div class="product-image">
                    <p>Afbeelding hier</p>
                </div>
                <div class="product-details">
                    <h1><?php echo htmlspecialchars($product['productnaam']); ?></h1>
                    <p><?php echo htmlspecialchars($product['beschrijving']); ?></p>
                    <p class="prijs">
                        <?php if ($korting > 0): ?>
                            <span style="text-decoration: line-through; color: gray;">€<?php echo number_format($oudePrijs, 2, ',', '.'); ?></span>
                            <span>€<?php echo number_format($nieuwePrijs, 2, ',', '.'); ?></span>
                        <?php else: ?>
                            €<?php echo number_format($oudePrijs, 2, ',', '.'); ?>
                        <?php endif; ?>
                    </p>

                    <p>
                        Voorraad:
                        <?php
                        if ($product['voorraad'] > 0) {
                            echo htmlspecialchars($product['voorraad']);
                        } else {
                            echo "<span style='color: red;'>Uitverkocht</span>";
                        }
                        ?>
                    </p>
                    <button
                            class="<?php echo $product['voorraad'] == 0 ? 'disabled' : ''; ?>"
                        <?php echo $product['voorraad'] == 0 ? 'disabled' : ''; ?>>
                        In mijn Winkelwagen
                    </button>
                </div>
            </div>
    </main>
    <div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
