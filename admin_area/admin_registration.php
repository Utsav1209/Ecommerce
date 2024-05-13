<div class="container-fluid">
    <h2 class="text-center mb-5">Admin Registration</h2>
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6 col-xl-5">
            <img src="./images/img1.png" alt="Admin Registration" class="img-fluid">
        </div>
        <div class="col-lg-6 col-xl-4">
            <form ng-submit="registeradmin()" class="m-auto" method="post">
                <div class="form-outline mb-4">
                    <label for="admin_name" class="form-label">Username</label>
                    <input type="text" ng-model="admin.admin_name" placeholder="Enter Username" required class="form-control" minlength="5" maxlength="20">
                    <small class="form-text text-muted">Username must be between 5 and 20 characters long.</small>
                </div>
                <div class="form-outline mb-4">
                    <label for="admin_email" class="form-label">Email</label>
                    <input type="email" ng-model="admin.admin_email" placeholder="Enter Email" required class="form-control">
                </div>
                <div class="form-outline mb-4">
                    <label for="admin_password" class="form-label">Password</label>
                    <input type="password" ng-model="admin.admin_password" placeholder="Enter Password" required class="form-control" minlength="8" maxlength="20" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,20}$">
                </div>
                <div class="form-outline mb-4">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" ng-model="admin.confirm_password" placeholder="Enter confirm password" required class="form-control" minlength="8" maxlength="20" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,20}$">
                </div>
                <div>
                    <button type="submit" class="bg-info py-2 px-3 border-0">Register</button>
                    <p class="small fw-bold mt-2 pt-1">Already have an account? <a href=".#!/admin_area/admin_login" class="link-danger">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>