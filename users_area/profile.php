<!-- connect file -->
<?php
include("../includes/connect.php");
include("../functions/common_function.php");
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $_SESSION['username'] ?></title>
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awsome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS file -->
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.js"></script>
    <script src="../navbarController.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <style>
        body {
            overflow-x: hidden;
        }

        .profile_img {
            width: 80%;
            /* height: 80%; */
            margin: auto;
            display: block;
            object-fit: contain;
        }

        .edit_image {
            width: 100px;
            height: 100px;
            object-fit: contain;

        }
    </style>
</head>

<!-- Fourth child -->
<div class="row">
    <div class="col-md-2">
        <ul class="navbar-nav bg-secondary text-center" style="height: 100vh;">
            <li class="nav-item bg-info">
                <a class="nav-link text-light" href="#">
                    <h4>Your Profile</h4>
                </a>
            </li>
            <?php
            $username = $_SESSION['username'];
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
    </div>
    <div class="col-md-10 text-center">
        <?php
        get_user_order_details();
        ?>
    </div>
</div>