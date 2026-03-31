<?php

include_once '../config/Database.php';
include_once '../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// Get ID
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get post
$quote->read_single();

if ($quote->quote != null) {
    // Create array
    $post_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id,
        'category_name' => $quote->category_name
    );

    // Make JSON
    echo json_encode($post_arr);
} else {
    echo json_encode(array('message' => 'Quote Not Found'));
}
