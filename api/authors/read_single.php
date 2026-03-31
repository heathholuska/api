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
include_once '../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

// Get ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get author
$author->read_single();

if ($author->author != null) {
    // Create array
    $post_arr = array(
        'id' => $author->id,
        'author' => $author->author
    );

    // Make JSON
    echo json_encode($post_arr);
} else {
    echo json_encode(array('message' => 'Author Not Found'));
}
