<?php
include("../includes/connect.php");
$data = json_decode(file_get_contents("php://input"), true);

if (isset($_GET['edit_category'])) {
    $edit_category = $_GET['edit_category'];
    $query = "SELECT * FROM `categories` WHERE category_id=$edit_category";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $category = mysqli_fetch_assoc($result);
        echo json_encode($category);
    } else {
        echo json_encode(array('error' => 'Category not found'));
    }
} elseif (isset($data['category_id'])) {
    $edit_category = $data['category_id'];
    $category_title = $data['category_title'];

    $update_query = "UPDATE `categories` SET category_title='$category_title' WHERE category_id=$edit_category";
    $result_category = mysqli_query($con, $update_query);

    if ($result_category) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error updating Category'));
    }
}
