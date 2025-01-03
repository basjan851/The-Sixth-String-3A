<?php
function set_header($redirect_to_login) {
    if ($redirect_to_login) {
        header('Location: /index.php?page=Login', true, 302);
    } else {
        header('HTTP/1.1 401 Unauthorized', true, response_code: 401);
        echo "<h1>401 Unauthorized</h1>";
    }
}
function check_role($roles, $redirect_to_login) {
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (isset($_SESSION["user"]["role"])) {
        $role = $_SESSION["user"]["role"];
        if (!in_array($role, $roles)) {
            set_header($redirect_to_login);
            exit();
        }
    } else {
        set_header($redirect_to_login);
        exit();
    }
}

function getPages() {
    return [
        0 => ['Winkelwagen','Bestelpagina'], //Klant
        1 => ['Winkelwagen','Bestelpagina','Beheerpaginas/Paginaeditor','Beheerpaginas/Productbeheer'],                     // webredacteur
        2 => ['Winkelwagen', 'Bestelpagina','Beheerpaginas/Bestellingbeheer'],                                      // Logistiek medewerker
        3 => ['Winkelwagen', 'Bestelpagina','Beheerpaginas/Productbeheer'],                                      // Klanten service medewerker
        4 => ['Winkelwagen', 'Bestelpagina'],                       // CTO (Technische dericteur)
        5 => ['Winkelwagen', 'Bestelpagina','Beheerpaginas/Productbeheer', 'Beheerpaginas/Producttoevoegen', 'Beheerpaginas/Paginaeditor', 'Beheerpaginas/Bestellingbeheer','Beheerpaginas/Bestellingwijzig'],                 // algemeen beheerder
    ];
}

function getAllowedRoles() {
    $i = 0;
    $pages = array();
    foreach (getPages() as $role) {
        foreach ($role as $p) {
            $pages[$p][] = (string) $i;
        }
        $i++;
    }
    return $pages;
}
function getAllowedPages($role) {
    $rolePages = getPages();
    return $rolePages[$role] ?? []; // Retourneer lege array als de rol onbekend is
}
function getAllowedBeheerPages($role) {
    $rolePages = getPages();
    $cpages = array();
    if (isset($rolePages[$role]))
    foreach ($rolePages[$role] as $page) {
        if (str_contains($page,"Beheerpaginas/")) {
            $cpages[] = str_replace("Beheerpaginas/","",$page);
        }
    }
    return $cpages;
}
?>
