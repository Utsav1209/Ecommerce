<!-- Include AngularJS controller -->
<div ng-controller="BrandDetailsController">
    <!-- Call getProductsByBrand function with brand ID -->
    <div ng-init="getProductsByBrand(brandId)">
        <!-- Display products -->
        <div class="col-md-4 mb-2" ng-repeat="product in products">
            <div class="card">
                <img ng-src="./admin_area/product_images/{{ product.product_image1 }}" class="card-img-top" alt="{{ product.product_title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ product.product_title }}</h5>
                    <p class="card-text">{{ product.product_description }}</p>
                    <p class="card-title">Price: {{ product.product_price }}/-</p>
                    <a href="index.php?add_to_cart={{ product.product_id }}" class="btn btn-info">Add to Cart</a>
                    <a href="product_details.php?product_id={{ product.product_id }}" class="btn btn-secondary">View more</a>
                </div>
            </div>
        </div>

        <!-- Display message if no products found -->
        <div class="col-md-12">
            <h2 class="text-center text-danger" ng-if="noProductMessage">{{ noProductMessage }}</h2>
        </div>
    </div>
</div>