<?php include("./dashboard.php"); ?>
<div ng-app="ecommerceApp" ng-controller="AdminController">
    <h3 class="text-center text-success">All Users</h3>
    <table class="table table-bordered mt-5">
        <thead class="bg-info text-center">
            <tr>
                <th>Sl no</th>
                <th>Username</th>
                <th>User email</th>
                <th>User Image</th>
                <th>User Address</th>
                <th>User Mobile</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="bg-secondary text-center">
            <tr ng-repeat="user in users">
                <td>{{$index + 1}}</td>
                <td>{{user.username}}</td>
                <td>{{user.user_email}}</td>
                <td><img ng-src="../users_area/user_images/{{user.user_image}}" alt="{{user.username}}" class="product_img"></td>
                <td>{{user.user_address}}</td>
                <td>{{user.user_mobile}}</td>
                <td><a href="#" ng-click="userDelete(user.user_id)"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
        </tbody>
    </table>
</div>