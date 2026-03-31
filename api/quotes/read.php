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

$database = new Database();
$db = $database->connect();

$quoteModel = new Quote($db);
$result = $quoteModel->read();
$num = $result->rowCount();

if ($num > 0) {
    $posts_arr = array();
    $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'quote' => html_entity_decode((string) ($row['quote'] ?? '')),
            'author' => $author,
            'author_id' => $author_id,
            'category' => $category,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        // Push to "data"
        array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & Output
    echo json_encode($posts_arr);

} else {
    // No Quotes
    echo json_encode(
        array('message' => 'No Quotes Found')
    );

}