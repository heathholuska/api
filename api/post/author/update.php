<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
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


// Set ID to UPDATE
$author->id = $data->id ?? null;
$author->author = $data->author ?? null;

//Update Post
if ($post->update()) {
    echo json_encode(
        array('message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Updated')
    );
}
