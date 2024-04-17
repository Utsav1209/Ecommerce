<?php
include("../includes/connect.php");

$select_cat = "SELECT * FROM `categories`";
$result = mysqli_query($con, $select_cat);
$categories = [];

while ($row = mysqli_fetch_assoc($result)) {
    $category = [
        'category_id' => $row['category_id'],
        'category_title' => $row['category_title']
    ];
    $categories[] = $category;
}

header('Content-Type: application/json');
echo json_encode($categories);
