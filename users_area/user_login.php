<body ng-app="ecommerceApp" ng-controller="BrandController">
    <div class="container-fluid my-3">
        <h2 class="text-center">User Login</h2>
        <div class="row d-flex align-items-center justify-content-center mt-5">
            <div class="col-lg-12 col-xl-6">
                <form ng-submit="login()" method="post">
                    <!-- username -->
                    <div class="form-outline mb-4">
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" ng-model="userData.user_username" name="user_username" class="form-control" placeholder="Enter Your Username" autocomplete="off" required>
                    </div>
                    <!-- password -->
                    <div class="form-outline mb-4">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" ng-model="userData.user_password" name="user_password" class="form-control" placeholder="Enter Your Password" autocomplete="off" required>
                    </div>
                    <div class="mt-4 pt-2">
                        <input type="submit" value="Login" class="bg-info py-2 px-3 border-0">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="#!/users_area/user_registration" class="text-danger text-decoration-none">Signup</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>