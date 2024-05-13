<?php
include("../includes/connect.php");
include("../functions/common_function.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if ($request && isset($request->user_username) && isset($request->user_password)) {
        $user_username = mysqli_real_escape_string($con, $request->user_username);
        $user_password = mysqli_real_escape_string($con, $request->user_password);
        $select_query = "SELECT * FROM `user_table` WHERE username='$user_username'";
        $result = mysqli_query($con, $select_query);
        if ($result && mysqli_num_rows($result) == 1) {
            $row_data = mysqli_fetch_assoc($result);
            if (password_verify($user_password, $row_data['user_password'])) {
                $user_ip = getIPAddress();
                $select_cart_items = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
                $result_cart = mysqli_query($con, $select_cart_items);
                $has_items_in_cart = mysqli_num_rows($result_cart) > 0;
                $_SESSION['username'] = $user_username;
                // Only set success status in response
                echo json_encode(array("success" => true, "hasItemsInCart" => $has_items_in_cart));
                exit; // Exit script after echoing JSON
            }
        }
    }
    // If login fails, set success status to false
    echo json_encode(array("success" => false));
    exit;
}
// If request method is not POST, return invalid request status
echo json_encode(array("success" => false, "message" => "Invalid Request Method"));
