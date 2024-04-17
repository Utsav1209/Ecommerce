<?php
include("../includes/connect.php");

if (isset($_GET['delete_category'])) {
    $delete_category = $_GET['delete_category'];

    $delete_query = "DELETE FROM `categories` WHERE category_id=$delete_category";
    $result = mysqli_query($con, $delete_query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error deleting category']);
    }
} else {
    echo json_encode(['error' => 'Category ID not provided']);
}
