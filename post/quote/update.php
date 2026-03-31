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
include_once '../../models/Post.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog Post Object
$post = new Post($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id, $data->quote, $data->author_id, $data->category_id)) {
    echo json_encode(array('message' => 'Invalid input'));
    exit;
}


// Set ID to UPDATE

$post->id = $data->id;

$post->quote = $data->quote ?? null;
$post->author_id = $data->author_id ?? null;
$post->category_id = $data->category_id ?? null;

// Update Post
if ($post->update()) {
    echo json_encode(
        array('message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Updated')
    );
}
