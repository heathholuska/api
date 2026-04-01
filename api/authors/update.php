<?php

include_once '../config/Database.php';
include_once '../models/Author.php';

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
    echo json_encode(array(
        'id' => $author->id,
        'author' => $author->$author
    ));
} else {
    echo json_encode(array('message' => 'Author Not Updated'));
}