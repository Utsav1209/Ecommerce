<?php
include("../includes/connect.php");

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        echo json_encode(array('error' => 'Failed to fetch product'));
    }
} else {
    echo json_encode(array('error' => 'Product ID not provided'));
}

mysqli_close($con);
