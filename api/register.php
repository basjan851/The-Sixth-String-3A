<?php
include(__DIR__.'/../helpers/databaseconnector.php');
$dbcon = connect_db();
if (!empty($_POST["email"]) && !empty($_POST["password"] && !empty($_POST["passwordverify"]))) {
    //Check if password is same as verification password
    if ($_POST["password"] != $_POST["passwordverify"]) {
        header('Location: /index.php?page=Registreren&ir=1', true, 302);
        exit();
    }
    $passwordhash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    //Check if email isn't already in use
    $email = $dbcon->real_escape_string($_POST["email"]);
    $query = sprintf("SELECT email FROM gebruikers WHERE email = '%s'", $email);
    $result = $dbcon->query(query: $query);
    if (mysqli_num_rows($result) > 0) {
        header('Location: /index.php?page=Registreren&ie=1', true, 302);
        exit();
    }
    //Generate random 64 char string
    $verkey = md5(uniqid()) . md5(uniqid());
    //Add user to database while keeping it inactive and generate a random 64 length string as verification key
    $query = sprintf("INSERT INTO gebruikers (email, wachtwoord, rol, actief, verificatie_key) VALUES ('%s', '%s', 0, false, '%s')", $email, $passwordhash, $verkey);
    $dbcon->query(query: $query);
    header('Location: /index.php?page=Registreren&rs=1', true, 302);
} else {
    header('HTTP/1.1 400 Bad Request', true, 400);
}
?>