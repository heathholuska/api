<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
include_once '../../config/Database.php';
include_once 'Category.php';

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
