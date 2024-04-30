<?php
include("../includes/connect.php");

if (isset($_GET['edit_category'])) {
    $edit_category = $_GET['edit_category'];
    $get_categories = "SELECT * FROM `categories` WHERE category_id=$edit_category";
    $result = mysqli_query($con, $get_categories);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_title = $row['category_title'];

        $categoryData = array(
            'category_title' => $category_title
        );

        // header('Content-Type: application/json');
        echo json_encode($categoryData);
    } else {
        $errorResponse = array(
            'error' => 'Category not found'
        );
        echo json_encode($errorResponse);
    }
}
