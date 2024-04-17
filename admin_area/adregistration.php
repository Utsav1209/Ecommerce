<?php
include("../includes/connect.php");
include("../functions/common_function.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    // Check if all required fields are set
    if ($request && isset($request->admin_name) && isset($request->admin_email) && isset($request->admin_password) && isset($request->confirm_password)) {
        $admin_name = mysqli_real_escape_string($con, $request->admin_name);
        $admin_email = mysqli_real_escape_string($con, $request->admin_email);
        $admin_password = mysqli_real_escape_string($con, $request->admin_password);
        $confirm_password = mysqli_real_escape_string($con, $request->confirm_password);

        // Select query to check if the admin_name or admin_email already exists
        $select_query = "SELECT * FROM `admin_table` WHERE admin_name='$admin_name' OR admin_email='$admin_email'";
        $result = mysqli_query($con, $select_query);
        $rows_count = mysqli_num_rows($result);

        if ($rows_count > 0) {
            echo json_encode(array("success" => false, "message" => "admin_name or admin_email Already Exists"));
        } elseif ($admin_password != $confirm_password) {
            echo json_encode(array("success" => false, "message" => "Password do not match"));
        } else {
            // Hash the password
            $hash_password = password_hash($admin_password, PASSWORD_DEFAULT);

            // Insert query to register the user
            $insert_query = "INSERT INTO `admin_table` (admin_name, admin_email, admin_password) VALUES ('$admin_name', '$admin_email', '$hash_password')";
            $sql_execute = mysqli_query($con, $insert_query);

            if ($sql_execute) {
                echo json_encode(array("success" => true, "message" => "Registration Successful"));
            } else {
                echo json_encode(array("success" => false, "message" => "Registration Failed: " . mysqli_error($con)));
            }
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Invalid request data"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
