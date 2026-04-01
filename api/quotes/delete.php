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

if (!$data || !isset($data->id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit;
}

// Set ID to DELETE

$quotes->id = $data->id;

// check if quote exists
$checkQuote = new Quote($db);
$checkQuote->id = $quotes->id;
$checkQuote->read_single();
if ($checkQuote->quote == null) {
    echo json_encode(array('message' => 'No Quotes Found'));
    exit;
}

// DELETE Post
if ($quotes->delete()) {
    echo json_encode(array('id' => $quotes->id));
} else {
    echo json_encode(array('message' => 'Quote Not Deleted'));
}