<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dummydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$Id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default productId is 1
$sql = "SELECT * FROM producten WHERE Id = $Id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();

    // Controleer op korting en bereken de nieuwe prijs
    $oudePrijs = $product['Prijs'];
    $korting = isset($product['Korting']) ? $product['Korting'] : 0; // Verwacht percentage
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
    <title><?php echo htmlspecialchars($product['Naam']); ?></title>
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
    <header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <img src="../assets/images/png-clipart-guitar.png" width="40" height="40" role="img">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 text-white">Home</a></li>
                    <li><a href="#" class="nav-link px-2 text-secondary">Producten</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Over ons</a></li>
                </ul>

                <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="form-control form-control-light " placeholder="Zoek product" aria-label="Search">
                </form>

                <div class="d-flex align-items-center text-end">
                    <button type="button" class="btn btn-warning me-3">Aanmelden</button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                </div>
            </div>
        </div>
    </header>

    <main class="content">
        <div class="container standard-height">
            <h3>Productdetails</h3>
            <h6>Home > Producten > <?php echo htmlspecialchars($product['Naam']); ?></h6>
            <div class="product-container">
                <div class="product-image">
                    <p>Afbeelding hier</p>
                </div>
                <div class="product-details">
                    <h1><?php echo htmlspecialchars($product['Naam']); ?></h1>
                    <p><?php echo htmlspecialchars($product['Beschrijving']); ?></p>
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
                        if ($product['Voorraad'] > 0) {
                            echo htmlspecialchars($product['Voorraad']);
                        } else {
                            echo "<span style='color: red;'>Uitverkocht</span>";
                        }
                        ?>
                    </p>
                    <button
                            class="<?php echo $product['Voorraad'] == 0 ? 'disabled' : ''; ?>"
                        <?php echo $product['Voorraad'] == 0 ? 'disabled' : ''; ?>>
                        In mijn Winkelwagen
                    </button>
                </div>
            </div>
    </main>

    <footer class="bg-dark py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex align-items-center">
                    <form class="d-flex w-100">
                        <div class="col-12 col-lg-6 mb-2 mb-lg-0 me-lg-3">
                            <input type="email" class="form-control " placeholder="e-mail adres voor nieuwsbrief">
                        </div>
                        <button type="submit" class="btn btn-secondary">Verstuur</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <ul class="nav justify-content-end">
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Contact</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Privacy beleid</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Algemene voorwaarden</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Retourbeleid</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>