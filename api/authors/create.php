<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

include_once '../config/Database.php';
include_once '../models/Author.php';

$database = new Database();
$db = $database->connect(); // Fixed connection method

$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Verify data exists
if (!$data || !isset($data->author)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit;
}

$author->author = $data->author;

if ($author->create()) {
    echo json_encode(array('message' => 'Author Created'));
} else {
    echo json_encode(array('message' => 'Author Not Created'));
}
