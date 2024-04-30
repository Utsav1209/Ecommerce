<?php
include("includes/connect.php");
// var_dump(isset($_GET['search_data_product']));
if (isset($_GET['search_data_product'])) {
    $search_data_value = $_GET['search_data_product'];
    // echo "Search data parameter received: " . $search_data_value;
    $search_query = "SELECT * FROM `products` WHERE product_keywords LIKE '%$search_data_value%'";
    $result_query = mysqli_query($con, $search_query);

    if (mysqli_num_rows($result_query) > 0) {
        $product_data = array();
        while ($row = mysqli_fetch_assoc($result_query)) {
            $product_data[] = $row;
        }
        echo json_encode($product_data);
    } else {
        echo json_encode(array());
    }
} else {
    echo "Search data parameter is not set.";
}
