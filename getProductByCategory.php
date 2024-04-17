<?php
include("includes/connect.php");
if (isset($_GET['category'])) {
    $category_id = $_GET['category'];
    $select_query = "SELECT * FROM `products` WHERE category_id = $category_id";
    $result_query = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result_query) > 0) {
        $product_data = array();
        while ($row = mysqli_fetch_assoc($result_query)) {
            $product_data[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($product_data);
    } else {
        echo json_encode(array());
    }
} else {
    echo "Category parameter is not set.";
}
