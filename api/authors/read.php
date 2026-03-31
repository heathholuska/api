<?php

// include
include_once '../config/Database.php';
include_once '../models/Author.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate post object
$author = new Author($db);
$result = $author->read();
$num = $result->rowCount();

// Check if there are any posts
if ($num > 0) {

    // Posts array
    $posts_arr = array();


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'author' => $author,
        );

        // Push to "data"
        array_push($posts_arr, $post_item);
    }

    // Turn to JSON & Output
    echo json_encode($posts_arr);

} else {
    // No Posts
    echo json_encode(
        array('message' => 'No Posts Found')
    );

}
