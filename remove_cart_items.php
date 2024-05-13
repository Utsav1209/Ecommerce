// remove_cart_items.php
<?php

include("cart_func.php");

$data = json_decode(file_get_contents("php://input"), true);
$removed_items = $data['removed_items'];

foreach ($removed_items as $item) {
    $product_id = $item['product_id'];
    $delete_cart_item = "DELETE FROM `cart_details` WHERE product_id='$product_id'";
    $result_delete = mysqli_query($con, $delete_cart_item);
}

$total_price = 0;
$result = mysqli_query($con, $cart_query);
while ($row = mysqli_fetch_array($result)) {
    $product_id = $row['product_id'];
    $select_product = "SELECT * FROM `products` WHERE product_id='$product_id'";
    $result_product = mysqli_query($con, $select_product);
    while ($row_product_price = mysqli_fetch_array($result_product)) {
        $product_price = $row_product_price['product_price'];
        $quantity = $row['quantity'];
        $total_price += $product_price * $quantity;
    }
}

echo json_encode(['total_price' => $total_price]);
