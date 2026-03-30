<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
    Access-Control-Allow_methods, Authorization, X-Requested-with');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect(); // Fixed connection method

$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Verify data exists
if (!$data || !isset($data->author)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit;
}

$author->author = $data->author;

if ($author->create()) {
    echo json_encode(array('message' => 'Author Created'));
} else {
    echo json_encode(array('message' => 'Author Not Created'));
}
