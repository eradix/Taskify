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
$user = new User($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

if ($data) {
    //assign the extracted data
    $user->name             = $data->name;
    $user->email            = $data->email;
    $user->password         = $data->password;
    $user->role             = $data->role;
    $user->user_id          = $data->user_id;

    //call update function
    if ($user->update()) {
        echo json_encode(['message' => "{$data->name} updated successfully"]);
    } else {
        echo json_encode(['message' => 'User was not updated']);
    }
} else {
    echo json_encode(['message' => 'Invalid request']);
}
