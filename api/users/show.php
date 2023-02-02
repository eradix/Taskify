<?php
include '../../config/init.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//instantiate db class and call connect function
$database = new Database();
$db = $database->connect();

//instantiate listing model class
$user = new User($db);

//getting the value of id
$user->user_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

$user_info = [];

if (!$user->user_id) {
    $user_info['user'] = null;
    $user_info['message'] = "your user id is not an integer.";
    echo json_encode($user_info);
    exit();
}

//calling function
$user->show();

if (is_null($user->name)) {
    $user_info['user'] = null;
    $user_info['message'] = "No user found in the specified user id.";
    echo json_encode($user_info);
    exit();
}

//assigned to array
$user_info = [
    'user_id'               => $user->user_id,
    'name'                  => $user->name,
    'email'                 => $user->email,
    'password'              => $user->password,
    'role'                  => $user->role,
    'created_date'          => $user->created_date,
    'updated_date'          => $user->updated_date,
];

//convert to json obj
echo json_encode($user_info);
