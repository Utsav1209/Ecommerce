<?php

include("cart_func.php");

$data = json_decode(file_get_contents("php://input"), true);
$cart_items = $data['cart_items'];

foreach ($cart_items as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $update_cart = "UPDATE `cart_details` SET quantity='$quantity' WHERE product_id='$product_id'";
    $result_products_quantity = mysqli_query($con, $update_cart);
}

$total_price = 0;
foreach ($cart_items as $item) {
    $product_id = $item['product_id'];
    $select_product = "SELECT * FROM `products` WHERE product_id='$product_id'";
    $result_product = mysqli_query($con, $select_product);
    while ($row_product_price = mysqli_fetch_array($result_product)) {
        $product_price = $row_product_price['product_price'];
        $quantity = $item['quantity'];
        $total_price += $product_price * $quantity;
    }
}

echo json_encode(['total_price' => $total_price]);
