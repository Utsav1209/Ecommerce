<?php include("./dashboard.php"); ?>
<div ng-app="ecommerceApp" ng-controller="AdminController">
    <h3 class="text-center text-success">All Brands</h3>
    <table class="table table-boardered mt-5">
        <thead class="bg-info">
            <tr class="text-center">
                <th>Slno</th>
                <th>Brand Title</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="bg-secondary">
            <tr class="text-center" ng-repeat="brand in brands">
                <td>{{ $index + 1 }}</td>
                <td>{{ brand.brand_name }}</td>
                <!-- Add AngularJS directive to handle edit -->
                <td><a ng-href="#!/edit_brands/{{brand.brand_id}}"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <td><a href="#" ng-click="deleteBrand(brand.brand_id)" ng-confirm-click="Are you sure you want to delete this Brand?"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
        </tbody>
    </table>
</div>