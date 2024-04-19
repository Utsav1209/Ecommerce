<!-- connect file -->
<?php
include("includes/connect.php");
include("functions/common_function.php");
session_start();
?>

<body ng-app="ecommerceApp">
    <!-- navbar -->
    <div class="container-fluid p-0" ng-controller="BrandController">
        <!-- Fourth child -->
        <div class="row">
            <div class="col-md-12">
                <!-- Products -->
                <div class="row px-1">
                    <!-- fetching products -->
                    <?php
                    get_all_products();
                    get_unique_categories();
                    get_unique_brands();
                    ?>
                    <!-- row end -->
                </div>
                <!-- column end -->
            </div>
        </div>
    </div>
    <!-- bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>