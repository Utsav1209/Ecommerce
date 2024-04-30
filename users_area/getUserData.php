<?php
include("../includes/connect.php");
session_start();

if (isset($_SESSION['username'])) {
    $user_session_name = $_SESSION['username'];
    $get_details = "SELECT * FROM `user_table` WHERE username='$user_session_name'";
    $result_query = mysqli_query($con, $get_details);
    $row_query = mysqli_fetch_assoc($result_query);
    unset($row_query['user_password']);

    echo json_encode($row_query);
} else {
    echo json_encode(array('error' => 'Session username not set'));
}
