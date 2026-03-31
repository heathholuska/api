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
include_once '../../config/Database.php';
include_once 'Author.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id, $data->author)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit;
}

// Set ID to UPDATE
$author->id = $data->id;
$author->author = $data->author;

// Update Author
if ($author->update()) {
    echo json_encode(
        array('message' => 'Author Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Author Not Updated')
    );
}
