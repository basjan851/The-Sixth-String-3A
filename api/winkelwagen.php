<?php
include(__DIR__.'/../helpers/databaseconnector.php');
include(__DIR__.'/../helpers/rolecheck.php');
include(__DIR__.'/../helpers/winkelwagen.php');

if(session_status() !== PHP_SESSION_ACTIVE) session_start();
check_role(['0','1','2','3','4','5'], true); //Check of de gebruiker wel de juiste rol heeft
$amount = $_GET["amount"] ?? 0;
$product_id = $_GET["product_id"] ?? 1;
$action = $_GET["action"] ?? "";
$dbcon = connect_db();
match ($_GET["action"]) {
    "nuke" => nuke_winkelwagen($dbcon, $_SESSION["user"]["id"]),
    "remove" => mutate_product($dbcon, $_SESSION["user"]["id"], $product_id, "remove"),
    "mutate" => mutate_product($dbcon, $_SESSION["user"]["id"], $product_id, $amount),
    default => mutate_product($dbcon, $_SESSION["user"]["id"], $product_id, "append"),
};
if (isset($_SERVER['HTTP_REFERER'])) {
    header('Location: '. $_SERVER['HTTP_REFERER'], true, 302);
} else {
    echo "200 OK";
}
// mutate_product($dbcon, $_SESSION["user"]["id"], 2, "append");
// // 
// var_dump(get_winkelwagen($dbcon, $_SESSION["user"]["id"]));
?>