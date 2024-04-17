<?php
include("includes/connect.php");

$brands = array();

$select_brands = "SELECT * FROM `brands`";
$result_brands = mysqli_query($con, $select_brands);

while ($row_data = mysqli_fetch_assoc($result_brands)) {
    $brands[] = $row_data;
}

echo json_encode($brands);
