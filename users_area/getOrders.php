<?php

include("../includes/connect.php");
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $get_user_query = "SELECT user_id FROM `user_table` WHERE username=?";
    $stmt_user = mysqli_prepare($con, $get_user_query);
    mysqli_stmt_bind_param($stmt_user, "s", $username);
    mysqli_stmt_execute($stmt_user);
    $user_result = mysqli_stmt_get_result($stmt_user);

    if ($user_result) {
        $user_row = mysqli_fetch_assoc($user_result);
        $user_id = $user_row['user_id'];

        $get_orders_query = "SELECT DISTINCT * FROM `user_orders` WHERE user_id=?";
        $stmt_orders = mysqli_prepare($con, $get_orders_query);
        mysqli_stmt_bind_param($stmt_orders, "i", $user_id);
        mysqli_stmt_execute($stmt_orders);
        $orders_result = mysqli_stmt_get_result($stmt_orders);

        if ($orders_result) {
            $orders = [];
            while ($order_row = mysqli_fetch_assoc($orders_result)) {
                $orders[] = $order_row;
            }
            echo json_encode($orders);
        } else {
            echo json_encode(['error' => 'Error fetching orders']);
        }
    } else {
        echo json_encode(['error' => 'Error fetching user']);
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
}
