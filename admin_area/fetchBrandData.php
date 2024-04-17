<?php
include("../includes/connect.php");

if (isset($_GET['edit_brands'])) {
    $edit_brand = $_GET['edit_brands'];
    $get_brand = "SELECT * FROM `brands` WHERE brand_id=$edit_brand";
    $result = mysqli_query($con, $get_brand);
    $row = mysqli_fetch_assoc($result);
    $brand_name = $row['brand_name'];

    $brandData = array(
        'brand_name' => $brand_name
    );

    // header('Content-Type: application/json');
    echo json_encode($brandData);
}
