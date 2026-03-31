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
$categoryObj = new Category($db);
$result = $categoryObj->read();
$num = $result->rowCount();

// Check if there are any categories
if ($num > 0) {

    // Categories array
    $posts_arr = array();
    $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $post_item = array(
            'id' => $row['id'],
            'category' => $row['category']
        );

        // Push to "data"
        array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & Output
    echo json_encode($posts_arr);

} else {
    // No Categories
    echo json_encode(
        array('message' => 'No Categories Found')
    );

}
