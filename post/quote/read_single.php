<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect();

$post = new Post($db);

// Get ID
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get post
$post->read_single();

if ($post->quote != null) {
    // Create array
    $post_arr = array(
        'id' => $post->id,
        'quote' => $post->quote,
        'author' => $post->author,
        'author_id' => $post->author_id,
        'category' => $post->category,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    // Make JSON
    echo json_encode($post_arr);
} else {
    echo json_encode(array('message' => 'Quote Not Found'));
}
