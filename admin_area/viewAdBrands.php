<?php
include("../includes/connect.php");

$select_cat = "SELECT * FROM `brands`";
$result = mysqli_query($con, $select_cat);
$brands = [];

while ($row = mysqli_fetch_assoc($result)) {
    $brand = [
        'brand_id' => $row['brand_id'],
        'brand_name' => $row['brand_name']
    ];
    $brands[] = $brand;
}

header('Content-Type: application/json');
echo json_encode($brands);
