<?php
include_once '../config/Database.php';
include_once '../models/Quote.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$quotes = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->quote, $data->author_id, $data->category_id)) {
    echo json_encode(array('message' => 'Invalid input'));
    exit;
}

$quotes->quote = $data->quote ?? null;
$quotes->author_id = $data->author_id ?? null;
$quotes->category_id = $data->category_id ?? null;

//Create post
if ($quotes->create()) {
    echo json_encode(
        array('message' => 'Quote Created')
    );
} else {
    echo json_encode(
        array('message' => 'Quote Not Created')
    );
}
