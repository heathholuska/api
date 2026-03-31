<?php

include_once '../config/Database.php';
include_once '../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quoteModel = new Quote($db);
$result = $quoteModel->read();
$num = $result->rowCount();

if ($num > 0) {
    $posts_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'quote' => html_entity_decode((string) ($row['quote'] ?? '')),
            'author' => $author_name,
            //'author_id' => $author_id,
            //'category_id' => $category_id,
            'category' => $category_name
        );

        // Push to "data"
        array_push($posts_arr, $post_item);
    }

    // Turn to JSON & Output
    echo json_encode($posts_arr);

} else {
    // No Quotes
    echo json_encode(
        array('message' => 'No Quotes Found')
    );

}