<?php

// Just Copied - Needs Updated

// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

// Get ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get post
$category->read_single();

// Create array
$post_arr = array(
    'id' => $category->id,
    'category' => $category->category
);

// Make JSON
print_r(json_encode($post_arr));
