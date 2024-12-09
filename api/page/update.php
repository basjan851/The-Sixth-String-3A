<?php
include(__DIR__.'/../../helpers/rolecheck.php');
check_role(['1','5'], false); //Check of de gebruiker wel de juiste rol heeft
include(__DIR__.'/../../helpers/databaseconnector.php');
$dbcon = connect_db();
if (isset($_POST["id"], $_POST["title"])) {
    $id = $dbcon->real_escape_string($_POST["id"]);
    $title = $dbcon->real_escape_string($_POST["title"]);
    if (isset($_POST["inhoud"])) {
        $inhoud = "'" . $dbcon->real_escape_string($_POST["inhoud"]) . "'";
    } else {
        $inhoud = "NULL";
    }
    if (!empty($_POST["actief"])) {
        $actief = "1";
    } else {
        $actief = "0";
    }
    $query = sprintf("UPDATE dynamische_pagina SET title = '%s', inhoud = %s, actief = %s WHERE id = %s;", $title, $inhoud ,$actief, $id);
    echo $query;
    header('Location: /index.php?page=Paginaeditor', true, 302);
} else {
    header('HTTP/1.1 400 Bad Request', true, 400);
    echo "<h1>400 Bad Request</h1>";
}
?>