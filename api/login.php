<?php
include(__DIR__.'/../helpers/databaseconnector.php');
$dbcon = connect_db();
if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    $query = sprintf("SELECT * FROM gebruikers WHERE email = '%s' AND actief = 1", $_POST["email"]);
    $dbcon->real_escape_string($_POST["email"]);
    $result = $dbcon->query($query);
    if (mysqli_num_rows($result) > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($_POST["password"], $user["wachtwoord"])) {
            session_start();
            $_SESSION["id"] = $user["id"];
            $_SESSION["wachtwoord"] = $user["wachtwoord"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["rol"] = $user["rol"];
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