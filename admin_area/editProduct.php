<?php
include("../includes/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_title = $_POST['product_title'];
    $product_desc = $_POST['product_description'];
    $product_keywords = $_POST['product_keywords'];
    $product_category = $_POST['category_id'];
    $product_brands = $_POST['brand_id'];
    $product_price = $_POST['product_price'];
    $product_image1 = isset($_FILES['product_image1']) ? $_FILES['product_image1']['name'] : '';
    $temp_image1 = isset($_FILES['product_image1']) ? $_FILES['product_image1']['tmp_name'] : '';

    // Check if any required fields are empty
    if (empty($product_title) || empty($product_desc) || empty($product_keywords) || empty($product_category) || empty($product_brands) || empty($product_price)) {
        echo "Please fill all the available fields";
        exit();
    } else {
        // Move the uploaded file only if it exists
        if (!empty($product_image1)) {
            move_uploaded_file($temp_image1, "./product_images/$product_image1");
        }

        $update_product = "UPDATE `products` SET product_title=?, product_description=?, product_keywords=?, category_id=?, brand_id=?, product_image1=?, product_price=?, date=NOW() WHERE product_id=?";
        $stmt = $con->prepare($update_product);

        // Bind parameters and execute the update query
        $stmt->bind_param("sssiisii", $product_title, $product_desc, $product_keywords, $product_category, $product_brands, $product_image1, $product_price, $_POST['product_id']);

        if ($stmt->execute()) {
            echo "Product updated successfully";
        } else {
            echo "Error updating product: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
    }
} else {
    echo "Invalid request method";
}
