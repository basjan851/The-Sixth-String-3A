<?php
require_once 'helpers/databaseconnector.php';
require_once 'helpers/rolecheck.php';
// Controleer eerst of de pagina een bestand in de pages-folder is
function router($page) {
    //Controleer permissie
    $perms = getAllowedRoles();
    if (isset($perms[$page])) {
        check_role($perms[$page], true);
    }
    // Check of er een statische pagina is
    $staticPage = __DIR__ . '/pages/' . $page . '.php';
    if (file_exists($staticPage)) {
        require $staticPage; // Laad de statische pagina
        return;
    }

    // Als er geen bestand in de pages-folder is, controleer de database
    if ($dynamicPage = getDynamicPage($page)) {
        echo $dynamicPage['inhoud']; // Render de inhoud van de dynamische pagina
        return;
    }
    http_response_code(404);
    echo "<h1>404 - Pagina niet gevonden</h1>";
}

function getDynamicPage($page) {
    $db = connect_db(); // Maak verbinding met de database

    // SQL-query aangepast voor dynamische_pagina-tabel
    $stmt = $db->prepare("SELECT inhoud FROM dynamische_pagina WHERE title = ? AND actief = 1");
    if (!$stmt) {
        die("Query voorbereiding mislukt: " . $db->error);
    }

    // Bind de parameter
    $stmt->bind_param("s", $page);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row ? $row : null;
}
?>