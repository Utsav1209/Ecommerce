<?php
include("../includes/connect.php");
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $get_details = "SELECT * FROM `user_table` WHERE username='$username'";
    $result_query = mysqli_query($con, $get_details);
    $row_query = mysqli_fetch_array($result_query);
    $user_id = $row_query['user_id'];

    $get_orders = "SELECT COUNT(*) as pendingOrders FROM `user_orders` WHERE user_id=$user_id AND order_status='pending'";
    $result_order_query = mysqli_query($con, $get_orders);
    $row_count = mysqli_fetch_array($result_order_query);
    $pendingOrders = $row_count['pendingOrders'];


    echo json_encode(array('pendingOrders' => $pendingOrders));
} else {
    echo json_encode(array('error' => 'Session username not set'));
}
