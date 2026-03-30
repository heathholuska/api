<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// include
include_once '../../config/Database.php';
include_once 'Category.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate post object
$category = new Post($db);
$result = $category->read();
$num = $result->rowCount();

// Check if there are any posts
if ($num > 0) {

    // Posts array
    $posts_arr = array();
    $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'category' => $category
        );

        // Push to "data"
        array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & Output
    echo json_encode($posts_arr);

} else {
    // No Posts
    echo json_encode(
        array('message' => 'No Posts Found')
    );

}
