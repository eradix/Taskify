<?php
include '../../config/init.php';

//header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//instantiate db class and call connect function
$database = new Database();
$db = $database->connect();

//instantiate listing model class
$user = new User($db);

$data = $user->index();
$row_count = $data->rowCount();


$result['user'] = [];
$user = [];

if ($row_count >= 1) {
    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user['user_id']           = $user_id;
        $user['name']              = $name;
        $user['email']             = $email;
        $user['role']              = $role;
        $user['password']          = $password;
        $user['created_date']      = $created_date;
        $user['updated_date']      = $updated_date;

        array_push($result['user'], $user);
    }
} else {
    $result['user'] = null;
    $result['message'] = "No User found.";
}

echo json_encode($result);
