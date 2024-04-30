<?php
include("includes/connect.php");

if (isset($_GET['category'])) {
    $category_id = $_GET['category'];

    // Query to fetch products by category ID
    $select_query = "SELECT * FROM `products` WHERE category_id=$category_id";
    $result_query = mysqli_query($con, $select_query);

    // Prepare array to hold products data
    $products = array();

    // Fetch products data and store in array
    while ($row = mysqli_fetch_assoc($result_query)) {
        $product = array(
            'product_id' => $row['product_id'],
            'product_title' => $row['product_title'],
            'product_description' => $row['product_description'],
            'product_image1' => $row['product_image1'],
            'product_price' => $row['product_price'],
            'category_id' => $row['category_id'],
            'brand_id' => $row['brand_id']
        );
        $products[] = $product;
    }

    // Convert products array to JSON format
    $json_products = json_encode($products);

    // Set response header to JSON
    header('Content-Type: application/json');

    // Output JSON data
    echo $json_products;
} else {
    // If category ID is not provided, return an error message
    echo json_encode(array('error' => 'Category ID is required'));
}
