<?php
// var_dump($_SESSION['username']);
// if (!isset($_SESSION['username'])) {
//     header("Location: admin_login.php");
//     exit;
// }
// session_start();
include("../includes/connect.php");

if (isset($_POST['insert_product'])) {
    $product_title = $_POST['product_title'];
    $description = $_POST['description'];
    $product_keywords = $_POST['product_keywords'];
    $product_category = $_POST['product_category'];
    $product_brands = $_POST['product_brands'];
    $product_price = $_POST['product_price'];
    $product_status = 'true';

    // Accessing images
    $product_image1 = $_FILES['filename']['name'][0];
    $product_image2 = $_FILES['filename2']['name'][1];
    $product_image3 = $_FILES['filename3']['name'][2];

    // Accessing images temp names
    $temp_image1 = $_FILES['filename']['tmp_name'][0];
    $temp_image2 = $_FILES['filename2']['tmp_name'][1];
    $temp_image3 = $_FILES['filename3']['tmp_name'][2];

    // Checking empty condition
    if (
        $product_title == '' or $description == '' or $product_keywords == '' or $product_category == '' or $product_brands == '' or $product_price == ''
        or $product_image1 == '' or $product_image2 == '' or $product_image3 == ''
    ) {
        echo "<script>alert('Please fill all the available fields')</script>";
        exit();
    } else {
        // Move uploaded files to appropriate directory
        move_uploaded_file($temp_image1, "./product_images/$product_image1");
        move_uploaded_file($temp_image2, "./product_images/$product_image2");
        move_uploaded_file($temp_image3, "./product_images/$product_image3");

        // Insert query
        $insert_products = "INSERT INTO `products` (product_title,product_description,product_keywords,category_id,brand_id,
        product_image1,product_image2,product_image3,product_price,date,status) VALUES ('$product_title','$description','$product_keywords','$product_category',
        '$product_brands','$product_image1','$product_image2','$product_image3','$product_price',NOW(),'$product_status')";
        $result_query = mysqli_query($con, $insert_products);
        if ($result_query) {
            echo "<script>alert('successfully inserted the product')</script>";
            echo "<script>window.open('./index.php?view_products','_self')</script>";
        } else {
            $error_message = mysqli_error($con);
            echo "<script>alert('Error inserting product: $error_message')</script>";
        }
    }
}
