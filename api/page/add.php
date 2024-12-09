<?php
include(__DIR__.'/../../helpers/rolecheck.php');
check_role(['1','5']); //Check of de gebruiker wel de juiste rol heeft
include(__DIR__ . '/../../helpers/databaseconnector.php');
$dbcon = connect_db();
// $email = $dbcon->real_escape_string($_POST["id"]);
// $query = sprintf("SELECT verificatie_key FROM gebruikers WHERE email = '%s' AND actief = 0", $email);
// $result = $dbcon->query(query: $query);
// if ($result->num_rows > 0) {
//     $user = $result->fetch_assoc();
//     echo $_SERVER['HTTP_HOST'].'/api/verify_email.php?key='.$user["verificatie_key"];
//     echo '<br><a href=/api/verify_email.php?key='.$user["verificatie_key"].'>Email verifieren</a>' ;
// }
$query = sprintf("INSERT INTO dynamische_pagina (title, actief) VALUES ('Nieuwe Pagina', false)");
if ($dbcon->query(query: $query)) {
    header('Location: /index.php?page=Paginaeditor&id=' . $dbcon->insert_id, true, 302);
} else {
    header('HTTP/1.1 500 Internal Server Error', true, 500);
}
;
?>