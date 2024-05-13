<?php
include("includes/connect.php");
include("functions/common_function.php");
session_start();
function getCartDetails()
{
    global $con;
    $get_ip_add = getIPAddress();
    $total_price = 0;
    $cart_query = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip_add'";
    $result = mysqli_query($con, $cart_query);
    $result_count = mysqli_num_rows($result);
    $cart_items = [];
    if ($result_count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $product_id = $row['product_id'];
            $select_product = "SELECT * FROM `products` WHERE product_id='$product_id'";
            $result_product = mysqli_query($con, $select_product);
            while ($row_product_price = mysqli_fetch_array($result_product)) {
                $product_price = $row_product_price['product_price'];
                $product_title = $row_product_price['product_title'];
                $product_image1 = $row_product_price['product_image1'];
                $quantity = $row['quantity'];
                $product_total_price = $product_price * $quantity;
                $total_price += $product_total_price;
                // Construct each cart item
                $cart_item = [
                    'product_id' => $product_id,
                    'product_title' => $product_title,
                    'product_image' => $product_image1,
                    'quantity' => $quantity,
                    'product_price' => $product_price,
                    'total_price' => $product_total_price
                ];
                // Add cart item to the cart items array
                array_push($cart_items, $cart_item);
            }
        }
    }
    // Return cart details as JSON
    return json_encode([
        'cart_items' => $cart_items,
        'total_price' => $total_price
    ]);
}

// Return cart details
echo getCartDetails();
