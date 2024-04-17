<?php
include("../includes/connect.php");

$data = json_decode(file_get_contents("php://input"), true);
$brandName = $data['brand_name'];

$select_query = "SELECT * FROM `brands` WHERE brand_name='$brandName'";
$result_select = mysqli_query($con, $select_query);
$number = mysqli_num_rows($result_select);
if ($number > 0) {
    echo json_encode(['error' => 'This Brand is already present in the database']);
} else {
    $insert_query = "INSERT INTO `brands` (brand_name) VALUES ('$brandName')";
    $result = mysqli_query($con, $insert_query);
    if ($result) {
        echo json_encode(['success' => 'Brand has been inserted successfully']);
    } else {
        echo json_encode(['error' => 'Error inserting brand']);
    }
}
