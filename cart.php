<!DOCTYPE html>
<html lang="en" ng-app="ecommerceApp" ng-controller="CartController">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce website - Cart details</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="BrandController.js"></script>
    <style>
        .cart_img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .empty-cart-message {
            text-align: center;
            margin-top: 80px;
        }

        .empty-cart-message h3 {
            font-size: 52px;
            color: red;
            margin-bottom: 30px;
        }

        .continue-shopping-btn {
            background-color: #17a2b8;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .continue-shopping-btn:hover {
            background-color: #138496;
        }
    </style>
</head>

<body>
    <!-- Navbar and other page content goes here -->
    <div class="container-fluid p-0">
        <div class="container">
            <div ng-if="cart.cart_items.length === 0" class="empty-cart-message">
                <h3>Cart is empty</h3>
                <button class="continue-shopping-btn" ng-click="continueShopping()">Continue Shopping</button>
            </div>

            <div class="row" ng-hide="cart.cart_items.length === 0">
                <table class="table table-bordered text-center mb-5">
                    <thead>
                        <tr>
                            <th>Product Title</th>
                            <th>Product Image</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in cart.cart_items">
                            <td>{{ item.product_title }}</td>
                            <td><img ng-src="./admin_area/product_images/{{ item.product_image }}" alt="" class="cart_img"></td>
                            <td><input type="text" ng-model="item.quantity" min="0" max="10" pattern="[0-9]{1,2}" ng-change="checkItemUpdated()" title="Please enter a number between 0 and 10"></td>
                            <td>{{ item.product_price }}/-</td>
                            <td><input type="checkbox" ng-model="item.remove" ng-true-value="true"></td>
                        </tr>
                    </tbody>

                </table>
                <div class="d-flex mb-5">
                    <h4 class="px-3">Subtotal: <strong class="text-info">{{ cart.total_price }}/-</strong></h4>
                    <input type="submit" value="Update Cart" class="bg-info px-3 border-0 mx-3" ng-click="updateCart()" style="font-weight:bold;">
                    <input type="button" value="Remove Cart" class="bg-danger px-3 border-0 mx-3 remove-cart-btn" ng-click="removeItem()" style="font-weight:bold;" ng-disabled="!isAnyItemChecked()">
                    <input type="button" value="Continue Shopping" class="bg-info px-3 border-0 mx-3" ng-click="continueShopping()">
                    <button class="bg-secondary p-3 py-2 border-0"><a href="#!/users_area/checkout" class="text-light text-decoration-none">Checkout</a></button>;
                </div>
            </div>

        </div>
    </div>
</body>

</html>