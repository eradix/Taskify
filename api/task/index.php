<?php
include '../../config/init.php';

//header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//instantiate db class and call connect function
$database = new Database();
$db = $database->connect();

//instantiate listing model class
$task = new Task($db);

$data = $task->index();
$row_count = $data->rowCount();


$result['task'] = [];
$tasks = [];


if ($row_count >= 1) {
	while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
		extract($row);
		$tasks['task_id'] = $task_id;
		$tasks['task_name'] = $task_name;
		$tasks['task_description'] = $task_description;
		$tasks['task_slug'] = $task_slug;
		$tasks['due_date'] = $due_date;
		$tasks['status'] = $status;
		$tasks['category_id'] = $category_id;
		$tasks['user_id'] = $user_id;
		$tasks['created_date'] = $created_date;
		$tasks['updated_date'] = $updated_date;
		$tasks['category_name'] = $category_name;
		$tasks['user_name'] = $name;
		array_push($result['task'], $tasks);
	}
} else {
	$result['task'] = null;
	$result['message'] = "No tasks found.";
}
echo json_encode($result);
