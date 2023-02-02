<?php
include '../../config/init.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//instantiate db class and call connect function
$database = new Database();
$db = $database->connect();

//instantiate listing model class
$category = new Category($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

if ($data) {
    //assign the extracted data
    $category->category_name         = $data->category_name;
    $category->category_description  = $data->category_description;

    //call create function
    if ($category->create()) {
        echo json_encode(['message' => "{$data->category_name} created successfully"]);
    } else {
        echo json_encode(['message' => 'Category was not created']);
    }
} else {
    echo json_encode(['message' => 'Invalid request']);
}
