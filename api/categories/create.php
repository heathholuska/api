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

if (!$data || !isset($data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit;
}

$category->category = $data->category;

// Create category
if ($category->create()) {
    $category->id = $db->lastInsertId();
    echo json_encode(array(
        'id' => $category->id,
        'category' => $category->category
    ));
} else {
    echo json_encode(array('message' => 'Category Not Created'));
}
