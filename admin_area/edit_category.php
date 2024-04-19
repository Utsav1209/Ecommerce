<div class="container mt-3" ng-app="ecommerceApp" ng-controller="BrandController">
    <h1 class="text-center">Edit Category</h1>
    <form class="text-center" ng-submit="editCategory()">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="category_title" class="form-label">Category Title</label>
            <input type="text" ng-model="formData.category_title" id="category_title" class="form-control" required>
        </div>
        <input type="submit" class="btn btn-info px-3 mb-3" value="Update category">
    </form>
</div>