<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

try {
    $drivers = PDO::getAvailableDrivers();
    if (empty($drivers)) {
        echo "No PDO drivers are enabled at all!";
    } else {
        echo "Enabled drivers: " . implode(", ", $drivers);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>