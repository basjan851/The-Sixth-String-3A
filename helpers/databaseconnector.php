<?php
function connect_db() {
    include __DIR__.'/../config.php';
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
    // Controleer connectie
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    return $con;
}
?>