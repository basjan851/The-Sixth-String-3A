<?php
session_start();
if (!empty($_SESSION["user"])) {
    var_dump($_SESSION["user"]);
} else {
    print("Not logged in");
}
?>