<!-- connect file -->
<?php
include("includes/connect.php");
include("functions/common_function.php");
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce website - Cart details</title>
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awsome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS file -->
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.js"></script>

    <script src="navbarController.js"></script>
    <style>
        .cart_img {
            width: 80px;
            height: 80px;
            object-fit: contain;

        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const removeCartBtns = document.querySelectorAll('.remove-cart-btn');
            removeCartBtns.forEach(btn => {
                btn.addEventListener('click', function(event) {
                    // Check if at least one checkbox is checked
                    const checkboxes = document.querySelectorAll('input[name="removeitem[]"]');
                    let atLeastOneChecked = false;
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            atLeastOneChecked = true;
                        }
                    });

                    if (!atLeastOneChecked) {
                        alert('Please select at least one item to remove from the cart.');
                        event.preventDefault();
                    } else {
                        const confirmed = confirm('Are you sure you want to remove the selected item(s) from the cart?');
                        if (!confirmed) {
                            event.preventDefault();
                        }
                    }
                });
            });
        });
    </script>


</head>

<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <!-- fourth child - table -->
        <div class="container">
            <div class="row">
                <form action="" method="post">
                    <table class="table table-bordered text-center mb-5">

                        <!-- php code to display dynamic data -->
                        <?php
                        $get_ip_add = getIPAddress();
                        $total_price = 0;
                        $cart_query = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip_add'";
                        $result = mysqli_query($con, $cart_query);
                        $result_count = mysqli_num_rows($result);
                        if ($result_count > 0) {
                            echo "<thead>
        <tr>
            <th>Product Title</th>
            <th>Product Image</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Remove</th>
        </tr>
    </thead>
    <tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                $product_id = $row['product_id'];
                                $select_product = "SELECT * FROM `products` WHERE product_id='$product_id'";
                                $result_product = mysqli_query($con, $select_product);
                                while ($row_product_price = mysqli_fetch_array($result_product)) {
                                    $product_price = $row_product_price['product_price'];
                                    $price_table = $row_product_price['product_price'];
                                    $product_title = $row_product_price['product_title'];
                                    $product_image1 = $row_product_price['product_image1'];
                                    $quantity = $row['quantity'];
                                    $product_total_price = $product_price * $quantity;
                                    $total_price += $product_total_price;
                        ?>
                                    <tr>
                                        <td><?php echo $product_title ?></td>
                                        <td><img src="./admin_area/product_images/<?php echo $product_image1 ?>" alt="" class="cart_img"></td>
                                        <td><input type="number" name="qty[<?php echo $product_id; ?>]" class="form-input w-50" min="0" max="10" pattern="[0-9]{1,2}" title="Please enter a number between 0 and 10" value="<?php echo $quantity ?>"></td>
                                        <td><?php echo $product_price ?>/-</td>
                                        <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id ?>"></td>
                                    </tr>

                        <?php
                                }
                            }
                            echo "</tbody>
                            <tfoot>
                                <tr>
                                    <td colspan='5'>
                                        <input type='submit' value='Update Cart' class='bg-info px-3 border-0 mx-3' name='update_cart' style='font-weight:bold;'>
                                        <input type='submit' value='Remove Cart' class='bg-danger px-3 border-0 mx-3 remove-cart-btn' name='remove_cart' style='font-weight:bold;'>
                                    </td>
                                </tr>
                            </tfoot>";
                        } else {
                            echo "<h2 class='text-center text-danger'>Cart is empty</h2>";
                        }

                        // Update quantities and total price
                        if (isset($_POST['update_cart'])) {
                            foreach ($_POST['qty'] as $product_id => $quantity) {
                                $update_cart = "UPDATE `cart_details` SET quantity='$quantity' WHERE product_id='$product_id'";
                                $result_products_quantity = mysqli_query($con, $update_cart);
                            }
                            // Recalculate the total price based on the updated quantities
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
                        }
                        ?>
                        </tbody>
                    </table>

                    <!-- subtotal -->
                    <div class="d-flex mb-5">
                        <?php
                        $get_ip_add = getIPAddress();
                        $cart_query = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip_add'";
                        $result = mysqli_query($con, $cart_query);
                        $result_count = mysqli_num_rows($result);
                        if ($result_count > 0) {
                            echo "<h4 class='px-3'>Subtotal:<strong class='text-info'>$total_price/-</strong></h4>
                                <input type='submit' value='Continue Shopping' class='bg-info px-3 border-0 mx-3' name='continue_shopping'>
                                    <button class='bg-secondary p-3 py-2 border-0'><a href='./users_area/checkout.php' class='text-light text-decoration-none'>Checkout</a></button>";
                        } else {
                            echo " <input type='submit' value='Continue Shopping' class='bg-info px-3 border-0 mx-3' name='continue_shopping'>";
                        }

                        if (isset($_POST["continue_shopping"])) {
                            header("Location: index.php");
                            exit();
                        }

                        ?>

                    </div>
                </form>
            </div>
        </div>

        <?php
        function remove_cart_item()
        {
            global $con;
            if (isset($_POST["remove_cart"])) {
                foreach ($_POST["removeitem"] as $remove_id) {
                    echo $remove_id;
                    $delete_query = "DELETE FROM `cart_details` WHERE product_id='$remove_id'";
                    $run_delete = mysqli_query($con, $delete_query);
                    if ($run_delete) {
                        echo "<script>window.open('cart.php', '_self')</script>";
                    }
                }
            }
        }
        echo $remove_item = remove_cart_item();

        ?>
        <!-- Last child -->
    </div>
    <!-- bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>