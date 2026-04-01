<?php

include_once '../config/Database.php';
include_once '../models/Author.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();
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
    $author->id = $db->lastInsertId();
    echo json_encode(array(
        'id' => $author->id,
        'author' => $author->author
    ));
} else {
    echo json_encode(array('message' => 'Author Not Created'));
}
