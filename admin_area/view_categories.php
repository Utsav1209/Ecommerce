<!-- HTML View -->
<?php include("./dashboard.php"); ?>
<div ng-model="ecommerceApp" ng-controller="AdminController">
    <h3 class="text-center text-success">All Categories</h3>
    <table class="table table-boardered mt-5">
        <thead class="bg-info">
            <tr class="text-center">
                <th>Slno</th>
                <th>Category Title</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="bg-secondary">
            <tr class="text-center" ng-repeat="category in categories">
                <td>{{$index + 1}}</td>
                <td>{{category.category_title}}</td>
                <td><a ng-href="#!/edit_category/{{category.category_id}}"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <td><a href="#" ng-click="deleteCategory(category.category_id)" ng-confirm-click="Are you sure you want to delete this Category?"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
        </tbody>
    </table>
</div>