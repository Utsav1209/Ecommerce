<?php

include("../includes/connect.php");
$data = json_decode(file_get_contents("php://input"), true);

if (isset($_GET['edit_brand'])) {
    $edit_brand = $_GET['edit_brand'];
    $query = "SELECT * FROM `brands` WHERE brand_id=$edit_brand";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $brand = mysqli_fetch_assoc($result);
        echo json_encode($brand);
    } else {
        echo json_encode(array('error' => 'Brand not found'));
    }
} elseif (isset($data['brand_id'])) {
    $edit_brand = $data['brand_id'];
    $brand_name = $data['brand_name'];

    $update_query = "UPDATE `brands` SET brand_name='$brand_name' WHERE brand_id=$edit_brand";
    $result_brand = mysqli_query($con, $update_query);

    if ($result_brand) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error updating brand'));
    }
}
