<?php
include("../includes/connect.php");

$get_payments = "SELECT * FROM `user_payments`";
$result = mysqli_query($con, $get_payments);
$payments = [];

while ($row_data = mysqli_fetch_assoc($result)) {
    $payments[] = $row_data;
}

echo json_encode($payments);
