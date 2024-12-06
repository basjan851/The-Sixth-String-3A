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
$page = $_GET['page'] ?? 'home';
$content = loadStaticPage($page);
?>