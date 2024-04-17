<?php
include("../includes/connect.php");
include("../functions/common_function.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    if ($request && isset($request->admin_name) && isset($request->admin_password)) {
        $admin_name = mysqli_real_escape_string($con, $request->admin_name);
        $admin_password = mysqli_real_escape_string($con, $request->admin_password);

        $select_query = "SELECT * FROM `admin_table` WHERE admin_name='$admin_name'";
        $result = mysqli_query($con, $select_query);

        if (!$result) {
            echo json_encode(array("success" => false, "message" => "Database query error: " . mysqli_error($con)));
            exit;
        }

        if (mysqli_num_rows($result) == 1) {
            $row_data = mysqli_fetch_assoc($result);
            if (password_verify($admin_password, $row_data['admin_password'])) {
                $_SESSION['admin_id'] = $row_data['admin_id'];
                $_SESSION['admin_name'] = $admin_name;
                echo json_encode(array("success" => true, "message" => "Login Successful"));
            } else {
                echo json_encode(array("success" => false, "message" => "Incorrect password"));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Admin username not found"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Invalid request data"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
