<?php
include(__DIR__.'/../helpers/databaseconnector.php');
$dbcon = connect_db();
if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    $email = $dbcon->real_escape_string($_POST["email"]);
    $query = sprintf("SELECT * FROM gebruikers WHERE email = '%s' AND actief = 1", $email);
    $result = $dbcon->query($query);
    if (mysqli_num_rows($result) > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($_POST["password"], $user["wachtwoord"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user"] = $user;
            header('Location: /index.php?page=Home', true, 302);
            exit();
        }
        // if ($_POST["email"] == "test") { //Login successful, redirect to homepage

        // }
    };
}
header('Location: /index.php?page=Login&iw=1', true, 302);
exit();
?>