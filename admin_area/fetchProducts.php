<?php
include("../includes/connect.php");

$get_products = "SELECT * FROM `products`";
$result = mysqli_query($con, $get_products);
$products = [];

while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

echo json_encode($products);
