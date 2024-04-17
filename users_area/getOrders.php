<?php
session_start();
include("../includes/connect.php");

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $get_user_query = "SELECT * FROM `user_table` WHERE username='$username'";
    $user_result = mysqli_query($con, $get_user_query);
    $user_row = mysqli_fetch_assoc($user_result);
    $user_id = $user_row['user_id'];

    $get_orders_query = "SELECT * FROM `user_orders` WHERE user_id='$user_id'";
    $orders_result = mysqli_query($con, $get_orders_query);

    if ($orders_result) {
        $orders = [];
        while ($order_row = mysqli_fetch_assoc($orders_result)) {
            $order_status = $order_row['order_status'] == 'pending' ? 'Incomplete' : 'Complete';
            $order_row['order_status'] = $order_status;
            $orders[] = $order_row;
        }

        echo json_encode($orders);
    } else {
        echo json_encode(['error' => 'Error fetching orders']);
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
}
