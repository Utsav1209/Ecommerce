<?php
include("../includes/connect.php");

$select_users = "SELECT * FROM `user_table`";
$result = mysqli_query($con, $select_users);
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
echo json_encode($users);
