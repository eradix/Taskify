<?php
include '../../config/init.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//instantiate db class and call connect function
$database = new Database();
$db = $database->connect();

//instantiate listing model class
$category = new Category($db);

//getting the value of id
$category->category_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

$category_info = [];

if (!$category->category_id) {
    $category_info['category'] = null;
    $category_info['message'] = "your category id is not an integer.";
    echo json_encode($category_info);
    exit();
}

//calling function
$category->show();

if (is_null($category->category_name)) {
    $category_info['category'] = null;
    $category_info['message'] = "No category found in the specified task id.";
    echo json_encode($category_info);
    exit();
}

//assigned to array
$category_info = [
    'category_id'           => $category->category_id,
    'category_name'         => $category->category_name,
    'category_description'  => $category->category_description,
    'created_date'          => $category->created_date,
    'updated_date'          => $category->updated_date,

];

//convert to json obj
echo json_encode($category_info);
