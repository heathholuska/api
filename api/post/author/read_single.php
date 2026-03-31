<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once 'Author.php';

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
