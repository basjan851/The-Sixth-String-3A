<?php
include(__DIR__.'/../helpers/databaseconnector.php');
$dbcon = connect_db();
if (!empty($_GET["email"])) {
    $email = $dbcon->real_escape_string($_GET["email"]);
    $query = sprintf("SELECT verificatie_key FROM gebruikers WHERE email = '%s' AND actief = 0", $email);
    $result = $dbcon->query(query: $query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo $_SERVER['HTTP_HOST'].'/api/verify_email.php?key='.$user["verificatie_key"];
        echo '<br><a href=/api/verify_email.php?key='.$user["verificatie_key"].'>Email verifieren</a>' ;
    }
}
?>