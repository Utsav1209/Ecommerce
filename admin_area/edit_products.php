<div class="container mt-5" ng-app="ecommerceApp" ng-controller="BrandController">
    <h1 class="text-center">Edit Products</h1>
    <form ng-submit="editProduct()" enctype="multipart/form-data">
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" ng-model="formData.product_title" id="product_title" class="form-control" required minlength="2" maxlength="20">
            <small class="form-text text-muted">Title must be between 2 and 20 characters long.</small>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_desc" class="form-label">Product Description</label>
            <input type="text" ng-model="formData.product_description" id="product_desc" class="form-control" required>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_keywords" class="form-label">Product Keywords</label>
            <input type="text" ng-model="formData.product_keywords" id="product_keywords" class="form-control" required>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_category" class="form-label">Product Categories</label>
            <select ng-model="formData.category_id" class="form-select">
                <option value="">Select a Category</option>
                <option ng-repeat="category in categories" value="{{ category.category_id }}">{{ category.category_title }}</option>
            </select>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_brands" class="form-label">Product Brands</label>
            <select ng-model="formData.brand_id" class="form-select">
                <option value="">Select a Brand</option>
                <option ng-repeat="brand in brands" value="{{ brand.brand_id }}">{{ brand.brand_name }}</option>
            </select>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image1" class="form-label">Product Image1</label>
            <input type="file" ng-model="formData.product_image1" id="product_image1" class="form-control w-90 m-auto" accept="image/jpeg, image/png" required>
            <img ng-src="{{ './product_images/' + formData.product_image1 }}" id="product_image1" class="product_img">
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="number" ng-model="formData.product_price" id="product_price" class="form-control" required>
        </div>
        <div class="w-50 m-auto">
            <input type="submit" value="Update Product" class="btn btn-info px-3 mb-3">
        </div>
    </form>

</div>