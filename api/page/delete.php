<?php
include(__DIR__.'/../../helpers/rolecheck.php');
check_role(['1','5'], false); //Check of de gebruiker wel de juiste rol heeft
include(__DIR__.'/../../helpers/databaseconnector.php');
$dbcon = connect_db();
if (isset($_POST["id"])) {
    $id = $dbcon->real_escape_string($_POST["id"]);
    $query = sprintf("DELETE FROM dynamische_pagina WHERE id = %s;", $id);
    $result = $dbcon->query(query: $query);
    header('Location: /index.php?page=Beheerpaginas/Paginaeditor', true, 302);
} else {
    header('HTTP/1.1 400 Bad Request', true, 400);
    echo "<h1>400 Bad Request</h1>";
}
?>