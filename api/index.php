<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode(array('message' => 'Welcome to the Quotes API'));
