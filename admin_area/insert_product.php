<?php
include("../includes/connect.php");

?>
<div class="container mt-3">
    <h1 class="text-center">Insert Products</h1>
    <!-- form -->
    <form ng-submit="insertProduct()" enctype="multipart/form-data" method="post">
        <!-- title -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" ng-model="product_title" name="product_title" id="product_title" class="form-control" placeholder="Enter product title" autocomplete="off" required minlength="2" maxlength="20" />
            <small class="form-text text-muted">Title must be between 2 and 20 characters long.</small>
        </div>
        <!-- description -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_description" class="form-label">Product Description</label>
            <input type="text" ng-model="product_description" name="product_description" id="product_description" class="form-control" placeholder="Enter product description" autocomplete="off" required />
        </div>
        <!-- keywords -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_keywords" class="form-label">Product Keywords</label>
            <input type="text" ng-model="product_keywords" name="product_keywords" id="product_keywords" class="form-control" placeholder="Enter product keywords" autocomplete="off" required />
        </div>
        <!-- categories -->
        <div class="form-outline mb-4 w-50 m-auto">
            <select ng-model="category_id" class="form-select" name="category_id">
                <option value="">Select a Category</option>
                <?php
                $select_query = "Select * from `categories`";
                $result_query = mysqli_query($con, $select_query);
                while ($row = mysqli_fetch_assoc($result_query)) {
                    $category_title = $row['category_title'];
                    $category_id = $row['category_id'];
                    echo "<option value='$category_id'>$category_title</option>";
                }
                ?>
            </select>
        </div>
        <!-- brands -->
        <div class="form-outline mb-4 w-50 m-auto">
            <select ng-model="brand_id" class="form-select" name="brand_id">
                <option value="">Select a Brand</option>
                <?php
                $select_query = "Select * from `brands`";
                $result_query = mysqli_query($con, $select_query);
                while ($row = mysqli_fetch_assoc($result_query)) {
                    $brand_name = $row['brand_name'];
                    $brand_id = $row['brand_id'];
                    echo "<option value='$brand_id'>$brand_name</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_image1" class="form-label">Product Image 1</label>
            <input type="file" ng-model="product_image1" name="product_image1" id="product_image1" class="form-control" accept="image/jpeg, image/png, image/jpg" />
        </div>
        <!-- Image 2 -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_image2" class="form-label">Product Image 2</label>
            <input type="file" ng-model="product_image2" name="product_image2" id="product_image2" class="form-control" accept="image/jpeg, image/png, image/jpg" />
        </div>
        <!-- Image 3 -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_image3" class="form-label">Product Image 3</label>
            <input type="file" ng-model="product_image3" name="product_image2" id="product_image3" class="form-control" accept="image/jpeg, image/png, image/jpg" />
        </div>
        <!-- Price -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="number" ng-model="product_price" name="product_price" id="product_price" class="form-control" placeholder="Enter product price" autocomplete="off" required />
        </div>
        <!-- Submit -->
        <div class="form-outline mb-4 w-50 m-auto">
            <button type="submit" class="btn btn-info mb-3 px-3">Insert Product</button>
        </div>
    </form>
</div>