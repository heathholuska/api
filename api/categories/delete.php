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


// Set ID to UPDATE

$category->id = $data->id;


//DELETE Post
if ($category->delete()) {
    echo json_encode(
        array('message' => 'Category Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Deleted')
    );
}
