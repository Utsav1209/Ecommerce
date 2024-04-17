<?php
include("./fetchBrandData.php");
include("editBrand.php");
?>

<div class="container mt-3" ng-app="ecommerceApp" ng-controller="BrandController">
    <h1 class="text-center">Edit Brand</h1>
    <form ng-submit="editBrand()" class="text-center">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="brand_name" class="form-label">Brand Name</label>
            <input type="text" ng-model="formData.brand_name" id="brand_name" class="form-control" required="required">
        </div>
        <input type="submit" value="Update Brand" class="btn btn-info px-3 mb-3">
    </form>
</div>