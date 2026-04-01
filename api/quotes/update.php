<?php

include_once '../config/Database.php';
include_once '../models/Quote.php';
include_once '../models/Author.php';
include_once '../models/Category.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();
// Instantiate Blog Post Object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit;
}

// Set ID to UPDATE

$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

$quoteExist = new Quote($db);
$quoteExist->id = $quote->id;
$quoteExist->read_single();
if ($quoteExist->quote == null) {
    echo json_encode(array('message' => 'No Quotes Found'));
    exit;
}

$author = new Author($db);
$author->id = $quote->author_id;
$author->read_single();
if ($author->author == null) {
    echo json_encode(array('message' => 'author_id Not Found'));
    exit;
}

$category = new Category($db);
$category->id = $quote->category_id;
$category->read_single();
if ($category->category == null) {
    echo json_encode(array('message' => 'category_id Not Found'));
    exit;
}

// Update Post
if ($quote->update()) {
    echo json_encode(array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id
    ));
} else {
    echo json_encode(
        array('message' => 'Quote Not Updated')
    );
}
