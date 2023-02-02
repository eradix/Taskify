<?php
include '../../config/init.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//instantiate db class and call connect function
$database = new Database();
$db = $database->connect();

//instantiate listing model class
$task = new Task($db);

//getting the value of id
$task->task_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

$task_info = [];

if (!$task->task_id) {
	$task_info['task'] = null;
	$task_info['message'] = "your task id is not an integer.";
	echo json_encode($task_info);
	exit();
}

//calling function
$task->show();

if (is_null($task->task_name)) {
	$task_info['task'] = null;
	$task_info['message'] = "No task found in the specified task id.";
	echo json_encode($task_info);
	exit();
}

//assigned to array
$task_info = [
	'task_id' 			=> $task->task_id,
	'task_name' 		=> $task->task_name,
	'task_description' 	=> $task->task_description,
	'task_slug' 		=> $task->task_slug,
	'due_date' 			=> $task->due_date,
	'status' 			=> $task->status,
	'category_id' 		=> $task->category_id,
	'user_id' 			=> $task->user_id,
	'created_date' 		=> $task->created_date,
	'updated_date' 		=> $task->updated_date,
	'user_name' 		=> $task->user_name,
];

//convert to json obj
echo json_encode($task_info);
