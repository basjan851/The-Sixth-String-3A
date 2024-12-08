<?php
include(__DIR__.'/../helpers/databaseconnector.php');
$dbcon = connect_db();
if (!empty($_GET["key"])) {
    $key = $dbcon->real_escape_string($_GET["key"]);
    $query = sprintf("UPDATE gebruikers SET actief = 1, verificatie_key = NULL WHERE verificatie_key = '%s'", $key);
    $result = $dbcon->query(query: $query);
    if ($dbcon->affected_rows > 0) {
        header('Location: /index.php?page=Login&ag=1', true, 302);
    } else {
        header(header: 'HTTP/1.1 400 Bad Request', replace: true, response_code: 400);
    }
} else {
    header(header: 'HTTP/1.1 400 Bad Request', replace: true, response_code: 400);
}
?>