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
$user = new User($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

if ($data) {
    //assign the extracted data
    $user->name         = $data->name;
    $user->email        = $data->email;
    $user->role         = $data->role;
    $user->password     = $data->password;

    //call create function
    if ($user->create()) {
        echo json_encode(['message' => "{$data->name} created successfully"]);
    } else {
        echo json_encode(['message' => 'User was not created']);
    }
} else {
    echo json_encode(['message' => 'Invalid request']);
}
