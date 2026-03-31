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
$quotes = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->quote, $data->author_id, $data->category_id)) {
    echo json_encode(array('message' => 'Invalid input'));
    exit;
}

$quotes->quote = $data->quote ?? null;
$quotes->author_id = $data->author_id ?? null;
$quotes->category_id = $data->category_id ?? null;

//Create post
if ($quotes->create()) {
    echo json_encode(
        array('message' => 'Post Created')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Created')
    );
}
