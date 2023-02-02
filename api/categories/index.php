<?php
include '../../config/init.php';

//header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//instantiate db class and call connect function
$database = new Database();
$db = $database->connect();

//instantiate listing model class
$categories = new Category($db);

$data = $categories->index();
$row_count = $data->rowCount();


$result['categories'] = [];
$categories = [];


if ($row_count >= 1) {
    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $categories['category_id']          = $category_id;
        $categories['category_name']        = $category_name;
        $categories['category_description'] = $category_description;
        $categories['created_date']         = $created_date;
        $categories['updated_date']           = $updated_date;

        array_push($result['categories'], $categories);
    }
} else {
    $result['categories'] = null;
    $result['message'] = "No Listings found.";
}
echo json_encode($result);
