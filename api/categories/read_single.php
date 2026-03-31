<?php

include_once '../config/Database.php';
include_once '../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

// Get ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get post
$category->read_single();

// Create array

if ($category->category != null) {
    $post_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );
    echo json_encode($post_arr);
} else {
    echo json_encode(array('message' => 'category_id Not Found'));
}
