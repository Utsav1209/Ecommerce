<?php
include("includes/connect.php");

$categories = array();

$select_categories = "SELECT * FROM `categories`";
$result_categories = mysqli_query($con, $select_categories);

while ($row_data = mysqli_fetch_assoc($result_categories)) {
    $categories[] = $row_data;
}

echo json_encode($categories);
