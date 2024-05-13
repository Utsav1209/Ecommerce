<?php include("./dashboard.php"); ?>
<div ng-model="ecommerceApp" ng-controller="AdminController">
    <h3 class="text-center text-success">All Products</h3>
    <table class="table table-bordered mt-5">
        <thead class="bg-info">
            <tr>
                <th>Product ID</th>
                <th>Product Title</th>
                <th>Product Image</th>
                <th>Product Price</th>
                <th>Total Sold</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="bg-secondary text-light">
            <tr ng-repeat="product in products">
                <td>{{$index + 1}}</td>
                <td>{{product.product_title}}</td>
                <td><img ng-src="./admin_area/product_images/{{product.product_image1}}" class="product_img"></td>
                <td>{{product.product_price}}/-</td>
                <td>{{product.total_sold}}</td>
                <td>{{product.status}}</td>
                <!-- <td><a ng-href="/index.php?edit_product={{product.product_id}}"><i class="fa-solid fa-pen-to-square"></i></a></td> -->
                <td><a ng-href="#!/edit_products/{{ product.product_id }}"><i class='fa-solid fa-pen-to-square'></i></a></td>
                <td><a href="#" ng-click="productDelete(product.product_id)" ng-confirm-click="Are you sure you want to delete this Product?"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
        </tbody>
    </table>
</div>