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
$task = new Task($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

if ($data) {
	//assign the extracted data
	$task->task_name 		= $data->task_name;
	$task->task_description = $data->task_description;
	$task->task_slug 		= $data->task_slug;
	$task->due_date 		= $data->due_date;
	$task->status 			= $data->status;
	$task->user_id 			= $data->user_id;
	$task->category_id 		= $data->category_id;
	$task->task_id			= $data->task_id;

	//call update function
	if ($task->update()) {
		echo json_encode(['message' => "{$data->task_name} updated successfully"]);
	} else {
		echo json_encode(['message' => 'Task was not updated']);
	}
} else {
	echo json_encode(['message' => 'Invalid request']);
}
