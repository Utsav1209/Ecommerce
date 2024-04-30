<?php
// Start the session if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the session variable 'username' is set before accessing it
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Include the database connection file
include("../includes/connect.php");
?>

<ul class="navbar-nav bg-secondary text-center" style="height: 100vh;">
    <li class="nav-item bg-info">
        <a class="nav-link text-light" href="#">
            <h4>Your Profile</h4>
        </a>
    </li>
    <?php
    // Use the $username variable instead of directly accessing $_SESSION['username']
    $user_image = "SELECT * FROM `user_table` WHERE username='$username'";
    $result_image = mysqli_query($con, $user_image);
    $row_image = mysqli_fetch_array($result_image);
    $user_image = $row_image["user_image"];
    echo "  <li class='nav-item'>
            <img src='./user_images/$user_image' alt='Profile Photo' class='profile_img my-4'>
        </li>";
    ?>
    <li class="nav-item">
        <a class="nav-link text-light" href="#!/profile">
            Pending orders
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-light" href="#!/profile/edit_account">
            Edit Account
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-light" href="#!/profile/my_orders">
            My orders
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-light" href="#!/profile/delete_account">
            Delete Account
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-light" href="logout.php">
            Logout
        </a>
    </li>
</ul>