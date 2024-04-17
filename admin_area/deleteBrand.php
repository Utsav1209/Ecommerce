<?php
include("../includes/connect.php");

if (isset($_GET['delete_brand'])) {
    $delete_brand = $_GET['delete_brand'];

    $delete_query = "DELETE FROM `brands` WHERE brand_id=$delete_brand";
    $result = mysqli_query($con, $delete_query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error deleting brand']);
    }
} else {
    echo json_encode(['error' => 'Brand ID not provided']);
}
