<?php
// Include database connection or any other necessary files
include("includes/connect.php");

// Check if brand ID is provided in the request
if (isset($_GET['brand'])) { // Corrected parameter name
    $brand_id = $_GET['brand']; // Corrected parameter name

    // Query to fetch products by brand ID
    $select_query = "SELECT * FROM `products` WHERE brand_id=$brand_id";
    $result_query = mysqli_query($con, $select_query);

    // Prepare array to hold products data
    $products = array();

    // Fetch products data and store in array
    while ($row = mysqli_fetch_assoc($result_query)) {
        $products[] = $row;
    }

    // Convert products array to JSON format
    $json_products = json_encode($products);

    // Set response header to JSON
    header('Content-Type: application/json');

    // Output JSON data
    echo $json_products;
} else {
    // If brand ID is not provided, return an error message
    echo json_encode(array('error' => 'Brand ID is required'));
}
