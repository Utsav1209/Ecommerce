<?php
session_start();
include("../includes/connect.php");

$username_session = $_SESSION['username'];
$delete_query = "DELETE FROM `user_table` WHERE username='$username_session'";
$result = mysqli_query($con, $delete_query);
if ($result) {
    session_destroy();
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to delete account']);
}
