<div class="row" ng-controller="SearchController">
    <div class="col-md-10">
        <!-- Products -->
        <div class="row px-1">
            <div class="row">
                <div class="col-md-4 mb-2" ng-repeat="product in products">
                    <div class="card">
                        <img ng-src="./admin_area/product_images/{{ product.product_image1 }}" class="card-img-top" alt="{{ product.product_title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ product.product_title }}</h5>
                            <p class="card-text">{{ product.product_description }}</p>
                            <p class="card-title">Price: {{ product.product_price }}/-</p>
                            <a href="index.php?add_to_cart={{ product.product_id }}" class="btn btn-info">Add to Cart</a>
                            <a href="product_details.php?product_id={{ product.product_id }}" class="btn btn-success">View more</a>
                            <a href="index.php" class="btn btn-secondary">Go Home</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" ng-if="products.length === 0">
                <h2 class="text-center text-danger">No product found for this search!</h2>
            </div>
        </div>
    </div>
</div>