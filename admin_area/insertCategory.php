<?php
include("../includes/connect.php");

$data = json_decode(file_get_contents("php://input"), true);
$categoryName = $data['category_name'];

$select_query = "SELECT * FROM `category` WHERE category_title='$categoryName'";
$result_select = mysqli_query($con, $select_query);
$number = mysqli_num_rows($result_select);
if ($number > 0) {
    echo json_encode(['error' => 'This Category is already present in the database']);
} else {
    $insert_query = "INSERT INTO `categories` (category_title) VALUES ('$categoryName')";
    $result = mysqli_query($con, $insert_query);
    if ($result) {
        echo json_encode(['success' => 'Category has been inserted successfully']);
    } else {
        echo json_encode(['error' => 'Error inserting Category']);
    }
}
