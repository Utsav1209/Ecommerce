<?php
include("../includes/connect.php");

if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    $delete_query = "DELETE FROM `user_payments` WHERE payment_id=$payment_id";
    $result = mysqli_query($con, $delete_query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error deleting payment']);
    }
} else {
    echo json_encode(['error' => 'Payment ID not provided']);
}
