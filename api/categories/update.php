<?php

include_once '../config/Database.php';
include_once '../models/Category.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$category = new Category($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id, $data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit;
}

// Set fields to UPDATE
$category->id = $data->id;
$category->category = $data->category;

// Update category
if ($category->update()) {
    echo json_encode(
        array('message' => 'Category Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Updated')
    );
}
