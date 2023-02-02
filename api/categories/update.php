<?php
include '../../config/init.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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
    $category->category_name            = $data->category_name;
    $category->category_description     = $data->category_description;
    $category->category_id              = $data->category_id;

    //call update function
    if ($category->update()) {
        echo json_encode(['message' => "{$data->category_name} updated successfully"]);
    } else {
        echo json_encode(['message' => 'Category was not updated']);
    }
} else {
    echo json_encode(['message' => 'Invalid request']);
}
