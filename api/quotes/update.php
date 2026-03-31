<?php
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
include_once '../../models/Quote.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id, $data->quote, $data->author_id, $data->category_id)) {
    echo json_encode(array('message' => 'Invalid input'));
    exit;
}


// Set ID to UPDATE

$quote->id = $data->id;

$quote->quote = $data->quote ?? null;
$quote->author_id = $data->author_id ?? null;
$quote->category_id = $data->category_id ?? null;

// Update Post
if ($quote->update()) {
    echo json_encode(
        array('message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Updated')
    );
}
