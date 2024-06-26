<!-- connect file -->
<?php
include("includes/connect.php");
include("functions/common_function.php");


session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce website using PHP and MySQL.</title>
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awsome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS file -->
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="navbarController.js"></script>

    <style>
        body {
            overflow-x: hidden;
        }

        .styled-div a {
            display: block;
            padding: 7px;
            text-decoration: none;
            transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease;
            color: white;
            border-radius: 5px;
        }

        .styled-div a:hover {
            background-color: transparent;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            color: black;
        }
    </style>
</head>

<body ng-app="ecommerceApp">
    <!-- navbar -->
    <div class="container-fluid p-0" ng-controller="BrandController">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg bg-info navbar-light" ng-if="!shouldHideFunctions()">
            <div class=" container-fluid">
                <img src="./Images/img1.png" alt="" class="logo">
                <button class="navbar-toggler" type="button" ng-click="toggleNavbar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" ng-class="{ 'show': isNavbarOpen }">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#!/home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#!/display_all">Products</a>
                        </li>
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo "<li class='nav-item'>
                            <a class='nav-link' href='#!/profile'>My Account</a>
                        </li>";
                        } else {
                            echo "<li class='nav-item'>
                            <a class='nav-link' href='#!/users_area/user_registration'>Register</a>
                        </li>";
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#!/cart"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" style="pointer-events: none;">Total Price:<?php total_cart_price(); ?>/-</a>
                        </li>
                    </ul>
                    <!-- <form class="d-flex" ng-submit="searchProduct()" ng-controller="SearchController">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                        <input type="submit" value="search" class="btn btn-outline-light" name="search_data_product">
                    </form> -->
                    <form class="d-flex" ng-submit="searchProduct()" ng-controller="SearchController">
                        <input type="search" class="form-control" ng-model="searchData" placeholder="Search for products..." name="search_data">
                        <button type="submit" class="btn btn-outline-light" name="search_data_product">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- calling cart function -->
        <?php
        cart();
        ?>
        <!-- Second child -->
        <nav class="navbar navbar-expand-lg bg-secondary navbar-dark" ng-hide="isLoginPage()" ng-if="!shouldHideFunctions()">
            <ul class=" navbar-nav me-auto">

                <?php
                if (!isset($_SESSION['username'])) {
                    echo "  <li class='nav-item'>
                    <a class='nav-link' href='#' style='pointer-events: none;'>Welcome Guest</a>
                </li>";
                } else {
                    echo "<li class='nav-item'>
                    <a class='nav-link' href='#' style='pointer-events: none;'>Welcome " . $_SESSION['username'] . "</a>
                </li>";
                }
                if (!isset($_SESSION['username'])) {
                    echo " <li class='nav-item'>
                    <a class='nav-link' href='#!/users_area/user_login'>Login</a>
                </li>
                <li class='nav-item'><a class='nav-link' href='#!/users_area/user_registration'>Sign Up</a></li>";
                } else {
                    echo "<li class='nav-item'>
                    <a class='nav-link' href='./users_area/logout.php'>Logout</a>
                </li>";
                }

                ?>
            </ul>
        </nav>
        <!-- Third child -->
        <div class="bg-light" ng-if="!shouldHideFunctions()">
            <h3 class=" text-center">e-commerce Store</h3>
            <p class="text-center">Empowering Your Shopping Experience, One Click at a Time</p>
        </div>
        <!-- Fourth child -->
        <div class="row">
            <div class="col-md-{{ !shouldHideFunctions() ? '10' : '12' }}">
                <!-- Products -->
                <div class="row px-1">
                    <div ng-view></div>
                </div>
            </div>
            <div class="col-md-{{ !shouldHideFunctions() ? '2' : '0' }} bg-secondary p-0" ng-if="!shouldHideFunctions() && !isLoginPage()">
                <div ng-if="!shouldHideFunctions()">
                    <div ng-init="fetchBrands()">
                        <ul class="navbar-nav me-auto text-center">
                            <li class="nav-item bg-info">
                                <a href="#" class="nav-link text-light">
                                    <h4>Delivery Brands</h4>
                                </a>
                            </li>
                            <div ng-repeat="brand in Bnames" class="styled-div">
                                <a href="#!/brands/{{brand.brand_id}}">{{ brand.brand_name }}</a>
                            </div>
                        </ul>
                    </div>
                </div>
                <div ng-if="!shouldHideFunctions()">
                    <div ng-init="fetchCategories()">
                        <ul class="navbar-nav me-auto text-center">
                            <li class="nav-item bg-info">
                                <a href="#" class="nav-link text-light">
                                    <h4>Categories</h4>
                                </a>
                            </li>
                            <div ng-repeat="category in Cnames" class="styled-div">
                                <a href="#!/category/{{category.category_id}}">{{ category.category_title }}</a>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Last child -->
        <div class="bg-info p-3 text-center">
            <p>All rights reserved ©- Designed by Utsav-2024</p>
        </div>
    </div>
    <!-- bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>