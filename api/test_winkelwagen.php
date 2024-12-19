<?php
include(__DIR__.'/../helpers/databaseconnector.php');
include(__DIR__.'/../helpers/winkelwagen.php');
$dbcon = connect_db();

session_start();
mutate_product($dbcon, $_SESSION["user"]["id"], 2, "append");
// nuke_winkelwagen($dbcon, $_SESSION["user"]["id"])
var_dump(get_winkelwagen($dbcon, $_SESSION["user"]["id"]));
?>