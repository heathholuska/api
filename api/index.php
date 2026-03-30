<?php
include_once 'database.php';
header('Access-Control-Allow-Origin: *');

  header('Content-Type: application/json');

  $method = $_SERVER['REQUEST_METHOD'];



  if ($method === 'OPTIONS') {

    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');

    exit();

  }
$database = new Database();
$db = $database->getConnection();

// Check if an ID was provided in the URL (e.g., api/index.php?id=5)
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Logic to fetch ONE item from PostgreSQL
    $query = "SELECT * FROM quotes WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
} else {
    // Logic to fetch ALL items
    $query = "SELECT * FROM quotes";
    $stmt = $db->prepare($query);
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
