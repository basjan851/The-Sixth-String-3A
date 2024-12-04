<?php
include(__DIR__.'/../helpers/databaseconnector.php');
$dbcon = connect_db();
$dir = new DirectoryIterator(__DIR__);
$migrations = array();
//Parse folder and put sql files in $migrations
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        if (pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION) == "sql" ) {
            $migrations[] = $fileinfo->getFilename();
        }
    }
}
sort($migrations); //Sort migrations based on date of creation (very convenient naming scheme)
$loglocation = __DIR__."/migrations.log";
$loghandle = fopen($loglocation, "a+");
if (file_exists($loglocation) && filesize($loglocation) > 0) {
    $logcontent = fread($loghandle,filesize($loglocation));
} else {
    $logcontent = "";
}
foreach ($migrations as $migration) {
    //Check if the migration is already present in the log file, if so we skip it
    if (str_contains($logcontent,$migration)) {
        print($migration." already applied, skipping.\n");
    } else {
        print("Applying ".$migration." to database");
        $sql = file_get_contents(__DIR__.'/'.$migration);
        $dbcon->multi_query($sql); //Apply the migration to the database
        fwrite($loghandle, $migration."\n"); //Write the migration to the logfile since it has been applied without any errors
    }
}
fclose($loghandle);
?>