<?php
include_once '../config/Database.php';
include_once '../models/Quote.php';
include_once '../models/Category.php';
include_once '../models/Author.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$quotes = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->quote, $data->author_id, $data->category_id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit;
}

$quotes->quote = $data->quote;// ?? null;
$quotes->author_id = $data->author_id;// ?? null;
$quotes->category_id = $data->category_id;// ?? null;

$category = new Category($db);
$category->id = $quotes->category_id;
$category->read_single();
if ($category->category == null) {
    echo json_encode(array('message' => 'category_id Not Found'));
    exit;
}

//Create post
if ($quotes->create()) {
    $quotes->id = $db->LastInsertId();
    echo json_encode(array(
        'id' => $quotes->id,
        'quote' => $quotes->quote,
        'author_id' => $quotes->author_id,
        'category_id' => $quotes->category_id
    ));
} else {
    array('message' => 'Quote Created');

}
