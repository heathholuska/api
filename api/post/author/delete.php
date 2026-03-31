<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
include_once '../../config/Database.php';
include_once 'Author.php';

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
