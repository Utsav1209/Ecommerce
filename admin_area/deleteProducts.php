<?php
include("../includes/connect.php");

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $delete_query = "DELETE FROM `products` WHERE product_id=$product_id";
    $result = mysqli_query($con, $delete_query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error deleting product']);
    }
} else {
    echo json_encode(['error' => 'Product ID not provided']);
}
