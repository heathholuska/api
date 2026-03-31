<?php

// Just Copied - Needs Updated 

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once 'Category.php';

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
