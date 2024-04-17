<?php
include("../includes/connect.php");

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $delete_query = "DELETE FROM `user_orders` WHERE order_id=$order_id";
    $result = mysqli_query($con, $delete_query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error deleting order']);
    }
} else {
    echo json_encode(['error' => 'Order ID not provided']);
}
