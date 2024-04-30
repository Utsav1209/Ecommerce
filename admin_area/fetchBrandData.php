<?php
include("../includes/connect.php");

if (isset($_GET['edit_brands'])) {
    $edit_brand = $_GET['edit_brands'];
    $get_brand = "SELECT * FROM `brands` WHERE brand_id=$edit_brand";
    $result = mysqli_query($con, $get_brand);

    if (!$result) {
        // If there's an error in the query, output the error message
        echo "Error: " . mysqli_error($con);
    } else {
        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch brand data
            $row = mysqli_fetch_assoc($result);
            $brand_name = $row['brand_name'];

            // Create an array with brand data
            $brandData = array(
                'brand_name' => $brand_name
            );

            // Encode the array as JSON and output it
            echo json_encode($brandData);
        } else {
            // If no rows are returned, output a message
            echo "No brand found with ID: $edit_brand";
        }
    }
}
