<?php
include("../includes/connect.php");
include("../functions/common_function.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
    $conf_user_password = $_POST['conf_user_password'];
    $user_address = $_POST['user_address'];
    $user_contact = $_POST['user_contact'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    $user_ip = getIPAddress();


    $select_query = "SELECT * FROM `user_table` WHERE username='$user_username' OR user_email='$user_email'";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);
    if ($rows_count > 0) {
        echo json_encode(array("success" => false, "message" => "Username or email already exists"));
    } else {
        // Move uploaded image
        move_uploaded_file($user_image_tmp, "./user_images/$user_image");

        // Insert user data into the database
        $insert_query = "INSERT INTO `user_table` (username,user_email,user_password,user_image,user_ip,user_address,user_mobile) VALUES
        ('$user_username','$user_email','$hash_password','$user_image','$user_ip','$user_address','$user_contact')";
        $sql_execute = mysqli_query($con, $insert_query);

        // Check if user has items in cart and handle accordingly
        $select_cart_items = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
        $result_cart = mysqli_query($con, $select_cart_items);
        $rows_count = mysqli_num_rows($result_cart);
        if ($rows_count > 0) {
            $_SESSION['username'] = $user_username;
            echo json_encode(array("success" => true, "message" => "Registered successfully with items in cart"));
        } else {
            echo json_encode(array("success" => true, "message" => "Registered successfully"));
        }
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
