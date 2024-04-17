<?php
include("../includes/connect.php");

$get_orders = "SELECT * FROM `user_orders`";
$result = mysqli_query($con, $get_orders);
$orders = [];

while ($row_data = mysqli_fetch_assoc($result)) {
    $orders[] = $row_data;
}

echo json_encode($orders);
