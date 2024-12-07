<?php
// Functie om statische pagina's te laden
function loadStaticPage($pageName) {
    $filePath = __DIR__ . "/pages/{$pageName}.php";
    if (file_exists($filePath)) {
        ob_start(); //ik start hier een buffer zodat de pagina's snel ingeladen worden.
        include $filePath;
        return ob_get_clean();
    } else {
        return '<div class="text-center">
                    <h1 class="display-1 fw-bold text-danger">404</h1>
                     <p class="fs-4 text-muted">Oops! De pagina die je probeert op te zoeken bestaat niet.</p>
                     <a href="index.php?page=Home" class="btn btn-primary btn-lg">Terug</a>
                </div>';
    }
}

// Inhoud bepalen
$page = $_GET['page'] ?? 'home'; // Standaardpagina instellen
$content = loadStaticPage($page); // Statische pagina laden

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Sixth String</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for layout */
        html, body {
            height: 100%;
        }
        .wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1; /* zorgt ervoor dat de header en footer boven en onder blijven staan*/
        }
        .standard-height {
            height: 600px;
            min-height: 600px; /* Astandaard hoogte */
        }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Header -->

    <header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
               <img src="assets/images/png-clipart-guitar.png" width="40" height="40" role="img">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index.php?page=Home" class="nav-link px-2 text-white">Home</a></li>
                    <li><a href="index.php?page=Producten" class="nav-link px-2 text-white">Producten</a></li>
                    <li><a href="index.php?page=Info" class="nav-link px-2 text-white">Over ons</a></li>
                </ul>
                <!--zoek veld om producten te zoeken met breakpoints voor verschillende afmetingen-->
                <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="form-control form-control-light " placeholder="Zoek product" aria-label="Search">
                </form>

                <div class="d-flex align-items-center text-end">
                    <button type="button" class="btn btn-secondary me-3">Afmelden</button>
                    <button type="button" class="btn btn-warning me-3">Aanmelden</button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="content">
        <div class="container standard-height">
            <h3 class="p-2"><?php print $page;?></h3>
            <h6 class="p-2">Bread>Crumbs>Homepage</h6>
            <?= $content ?>

        </div>
    </main>

    <!-- Footer  class="bg-dark text-white p-4"-->
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
                        <li class="nav-item"><a href="index.php?page=Productdetail" class="nav-link px-2 text-white">Contact</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Privacy beleid</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Alegemene voorwaarden</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-white">Retourbeleid</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>