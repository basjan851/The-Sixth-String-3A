<?php
function set_header($redirect_to_login) {
    if ($redirect_to_login) {
        header('Location: /index.php?page=Login', true, 302);
    } else {
        header('HTTP/1.1 401 Unauthorized', true, response_code: 401);
        echo "<h1>401 Unauthorized</h1>";
    }
}
function check_role($roles, $redirect_to_login)
{
    if (isset($_SESSION["user"]["rol"])) {
        $role = $_SESSION["user"]["rol"];
        if (!in_array($role, $roles)) {
            set_header($redirect_to_login);
            exit();
        }
    } else {
        set_header($redirect_to_login);
        exit();
    }
}
function getAllowedPages($role) {
    $rolePages = [
        1 => ['Paginaeditor','Productbeheer'],                     // webredacteur
        2 => ['Bestelpagina', 'Bestellingbeheer'],                                      // Logistiek medewerker
        3 => ['Productbeheer'],                                      // Klanten service medewerker
        4 => ['Winkelwagen', 'Bestelpagina'],                       // CTO (Technische dericteur)
        5 => ['Productbeheer', 'Producttoevoegen', 'Paginaeditor', 'Bestellingbeheer'],                 // algemeen beheerder
    ];
    return $rolePages[$role] ?? []; // Retourneer lege array als de rol onbekend is
}
?>
