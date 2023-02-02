<?php
include '../../config/init.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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
	$task->task_id = $data->task_id;

	//call upadte function
	if ($task->delete()) {
		echo json_encode(['message' => 'Task deleted successfully']);
	} else {
		echo json_encode(['message' => 'Task was not deleted']);
	}
} else {
	echo json_encode(['message' => 'an error occured.']);
}
