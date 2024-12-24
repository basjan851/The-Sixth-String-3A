<?php

require_once './helpers/databaseconnector.php';

$selectAllProducten = 'SELECT * FROM producten';
$selectAllMerken = 'SELECT DISTINCT merk FROM producten ORDER BY merk ASC';
$selectAllCategorieen = 'SELECT DISTINCT naam FROM categorie';

// Database connectie
$dbcon = connect_db();

$producten = mysqli_query($dbcon, $selectAllProducten);
$merken = mysqli_query($dbcon, $selectAllMerken);
$categorieen = mysqli_query($dbcon, $selectAllCategorieen);

if (!isset($_SESSION['user']['id'])) {
    header('Location: /index.php?page=Login', true, 302);
    exit();
}
$gebruiker_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toevoegen'])) {
    $productId = $_POST['product_id'];
    $winkelwagenQuery = "INSERT INTO winkelwagen (gebruiker_id, product_id, aantal, laatst_geupdate) VALUES (?, ?, 1, NOW()) ON DUPLICATE KEY UPDATE aantal = aantal + 1, laatst_geupdate = NOW()";
    $stmt = $dbcon->prepare($winkelwagenQuery);
    if ($stmt === false) {
        die('Prepare failed: ' . $dbcon->error);
    }
    $stmt->bind_param('ii', $gebruiker_id, $productId);
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }
    $stmt->close();
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productpagina</title>
</head>
<body>
<div class="container my-5">
    <div class="row">
        <!-- Filter column -->
        <div class="col-md-3 bg-body-tertiary">
            <div class="container px-3 py-3 shadow-sm" style="background-color: #ffc107 !important;">
                <h2>Filteren</h2>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        Categorieën
                    </button>
                    <ul class="dropdown-menu">
                        <?php while ($row = mysqli_fetch_array($categorieen)) { ?>
                            <li><a class="dropdown-item" href="#"><?= $row["naam"] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>

                <h5 class="pt-3">Beschikbaarheid:</h5>
                <form method="post">
                    <div class="form-check">
                        <input class="form-check-input" name="OpVoorraad" type="checkbox" value="opvoorraad"
                               id="flexCheckChecked" <?php if (isset($_POST["OpVoorraad"]) && $_POST["OpVoorraad"] == "opvoorraad") {
                            echo "checked";
                        } ?>>
                        <label class="form-check-label" for="flexCheckChecked">Op voorraad</label>
                    </div>

                    <h5 class="pt-3">Merk:</h5>
                    <?php while ($row = mysqli_fetch_assoc($merken)) { ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                            <label class="form-check-label" for="flexCheckChecked"><?= $row['merk'] ?></label>
                        </div>
                    <?php } ?>
                    <input type="submit" class="btn btn-secondary mt-3" value="Pas filter toe">
                </form>
            </div>
        </div>

        <!-- Product column -->
        <div class="col-md-9">
            <div class="container">
                <h3>Categorie naam / Alle Producten</h3>
                <div class="dropdown my-3">
                    Sorteer op:
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        Prijs
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="post">
                                <button type="submit" name="OrderProductsASC" class="dropdown-item">Prijs laag hoog</button>
                            </form>
                        </li>
                        <li>
                            <form method="post">
                                <button type="submit" name="OrderProductsDESC" class="dropdown-item">Prijs hoog laag</button>
                            </form>
                        </li>
                    </ul>
                </div>

                <div class="row">
                    <?php
                    if (isset($_POST["OpVoorraad"]) && $_POST["OpVoorraad"] == "opvoorraad") {
                        $selectAllProducten = "SELECT * FROM producten WHERE voorraad > 0";
                        $producten = mysqli_query($dbcon, $selectAllProducten);
                    }

                    if (isset($_POST['OrderProductsASC'])) {
                        $selectAllProducten = 'SELECT * FROM producten ORDER BY prijs ASC';
                        $producten = mysqli_query($dbcon, $selectAllProducten);
                    }

                    if (isset($_POST['OrderProductsDESC'])) {
                        $selectAllProducten = 'SELECT * FROM producten ORDER BY prijs DESC';
                        $producten = mysqli_query($dbcon, $selectAllProducten);
                    }

                    if ($row = mysqli_fetch_assoc($producten) == null) {
                        echo "<h5>Geen producten</h5>";
                    }

                    while ($row = mysqli_fetch_assoc($producten)) { ?>
                        <div class="col-md-4 my-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($row['productnaam']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($row['beschrijving']) ?></p>
                                    <p class="card-text"><?= htmlspecialchars($row['voorraad']) ?> op voorraad</p>
                                    <p class="text-success">€<?= htmlspecialchars($row['prijs']) ?></p>
                                    <form method="post">
                                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['id']) ?>">
                                        <button type="submit" name="toevoegen" class="btn btn-success">Toevoegen</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
