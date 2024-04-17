<?php
include("../includes/connect.php");

if (isset($_SESSION['username']) && isset($_POST['user_update'])) {
    $username = $_SESSION['username'];
    $user_id = $_POST['user_id'];
    $user_email = $_POST['user_email'];
    $user_address = $_POST['user_address'];
    $user_mobile = $_POST['user_mobile'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    move_uploaded_file($user_image_tmp, "./user_images/$user_image");

    // Update query
    $update_data = "UPDATE `user_table` SET username='$username', user_email='$user_email', 
                    user_image='$user_image', user_address='$user_address', 
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
