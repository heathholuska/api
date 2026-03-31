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
include_once '../../models/Author.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit;
}

// Set ID to DELETE
$author->id = $data->id;

// Delete Author
if ($author->delete()) {
    echo json_encode(
        array('message' => 'Author Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Author Not Deleted')
    );
}
