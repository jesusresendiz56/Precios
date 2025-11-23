<?php
$connectionString = "mongodb://mongo:ZqtHSnCNKEYizfhGJqGykcKHDFuPOlKE@crossover.proxy.rlwy.net:45779";
$dbname = "Usuarios";

try {
    $manager = new MongoDB\Driver\Manager($connectionString);
    
    $command = new MongoDB\Driver\Command(['ping' => 1]);
    $manager->executeCommand('admin', $command);
    
} catch (Exception $e) {
    die("Fallo la conexión: <br>" . $e->getMessage());
}

function getMongoDB() {
    global $manager, $dbname;
    return $dbname;
}

function getMongoManager() {
    global $manager;
    return $manager;
}
?>