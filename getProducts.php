<?php
include("includes/connect.php");

$select_query = "SELECT * FROM `products` ORDER BY rand() LIMIT 0,6";
$result_query = mysqli_query($con, $select_query);
$product_data = [];

while ($row = mysqli_fetch_assoc($result_query)) {
    $product_data[] = $row;
}

// Return product data as JSON
header('Content-Type: application/json');
echo json_encode($product_data);
