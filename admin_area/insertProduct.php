<?php
include("../includes/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if all required fields are set
    if (
        empty($_POST['product_title']) ||
        empty($_POST['product_description']) ||
        empty($_POST['product_keywords']) ||
        empty($_POST['category_id']) ||
        empty($_POST['brand_id']) ||
        empty($_POST['product_price']) ||
        empty($_FILES['product_image1']['name']) ||
        empty($_FILES['product_image2']['name']) ||
        empty($_FILES['product_image3']['name'])
    ) {
        echo json_encode(array("success" => false, "message" => "Please fill all the available fields"));
        exit();
    } else {
        // Sanitize and retrieve form data
        $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
        $product_description = mysqli_real_escape_string($con, $_POST['product_description']);
        $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
        $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
        $brand_id = mysqli_real_escape_string($con, $_POST['brand_id']);
        $product_price = mysqli_real_escape_string($con, $_POST['product_price']);
        $product_status = 'true';

        // Accessing images
        $product_image1 = $_FILES['product_image1']['name'];
        $product_image2 = $_FILES['product_image2']['name'];
        $product_image3 = $_FILES['product_image3']['name'];

        // Accessing images temp names
        $temp_image1 = $_FILES['product_image1']['tmp_name'];
        $temp_image2 = $_FILES['product_image2']['tmp_name'];
        $temp_image3 = $_FILES['product_image3']['tmp_name'];

        // Move uploaded files to appropriate directory
        move_uploaded_file($temp_image1, "./product_images/$product_image1");
        move_uploaded_file($temp_image2, "./product_images/$product_image2");
        move_uploaded_file($temp_image3, "./product_images/$product_image3");

        // Insert query
        $insert_products = "INSERT INTO `products` (product_title, product_description, product_keywords, category_id, brand_id,
        product_image1, product_image2, product_image3, product_price, date, status) VALUES ('$product_title', '$product_description', '$product_keywords', '$category_id', '$brand_id', '$product_image1', '$product_image2', '$product_image3', '$product_price', NOW(), '$product_status')";

        // Execute the query
        $result_query = mysqli_query($con, $insert_products);

        // Check if the query was successful
        if ($result_query) {
            echo json_encode(array("success" => true, "message" => "Successfully inserted the product"));
        } else {
            $error_message = mysqli_error($con);
            echo json_encode(array("success" => false, "message" => "Error inserting product: $error_message"));
        }
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
