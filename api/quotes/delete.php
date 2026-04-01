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
    echo json_encode(array('message' => 'Invalid input'));
    exit;
}

// Set ID to DELETE

$quotes->id = $data->id;

// DELETE Post
if ($quotes->delete()) {
    echo json_encode(array('id' => $quotes->id));
} else {
    echo json_encode(array('message' => 'Quote Not Deleted'));
}