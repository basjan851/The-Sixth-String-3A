<?php
include(__DIR__.'/../../helpers/rolecheck.php');
check_role(['1','5'], false); //Check of de gebruiker wel de juiste rol heeft
include(__DIR__ . '/../../helpers/databaseconnector.php');
$dbcon = connect_db();
$query = sprintf("INSERT INTO dynamische_pagina (title, actief) VALUES ('Nieuwe Pagina', false)");
if ($dbcon->query(query: $query)) {
    header('Location: /index.php?page=Paginaeditor&id=' . $dbcon->insert_id, true, 302);
} else {
    header('HTTP/1.1 500 Internal Server Error', true, 500);
    echo "<h1>500 Internal Server Error</h1>";
}
;
?>