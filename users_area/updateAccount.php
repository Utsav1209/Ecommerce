<?php

include("../includes/connect.php");
session_Start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];
    $user_address = $_POST['user_address'];
    $user_mobile = $_POST['user_mobile'];
    $user_image1 = $_FILES['user_image1']['name'];
    $user_image_tmp = $_FILES['user_image1']['tmp_name'];
    move_uploaded_file($user_image_tmp, "../user_images/$user_image");

    // Update query
    $update_data = "UPDATE `user_table` SET username='$username', user_email='$user_email', 
                    user_image='$user_image1', user_address='$user_address', 
                    user_mobile='$user_mobile' WHERE user_id='$user_id'";
    $result_query_update = mysqli_query($con, $update_data);
    if ($result_query_update) {

        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'error' => 'Failed to update data'));
    }
} else {
    echo json_encode(array('error' => 'Session username not set or form data not received'));
}
