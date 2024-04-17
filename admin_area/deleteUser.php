<?php
include("../includes/connect.php");

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $delete_query = "DELETE FROM `user_table` WHERE user_id=$user_id";
    $result = mysqli_query($con, $delete_query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error deleting user']);
    }
} else {
    echo json_encode(['error' => 'User ID not provided']);
}
