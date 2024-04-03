<?php
include("../includes/connect.php");
include("../functions/common_function.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Registration</title>
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">New User Registration</h2>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- username -->
                    <div class="form-outline mb-4">
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" name="user_username" id="user_username" class="form-control" placeholder="Enter Your Username" autocomplete="off" required minlength="5" maxlength="20">
                        <small class="form-text text-muted">Username must be between 5 and 20 characters long.</small>
                    </div>
                    <!-- email -->
                    <div class="form-outline mb-4">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" name="user_email" id="user_email" class="form-control" placeholder="Enter Your Email" autocomplete="off" required>
                        <small id="email_error" class="text-danger"></small>
                    </div>
                    <!-- image -->
                    <div class="form-outline mb-4">
                        <label for="user_image" class="form-label">User Image</label>
                        <input type="file" name="user_image" id="user_image" class="form-control" required accept="image/jpeg, image/png">
                        <small id="image_error" class="text-danger"></small>
                    </div>
                    <!-- password -->
                    <div class="form-outline mb-4">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Enter Your Password" autocomplete="off" required minlength="8" maxlength="20" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,20}$">
                        <small id="password_error" class="text-danger"></small>
                        <small class="form-text text-muted">Password must be between 8 and 20 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character from [!@#$%^&*].</small>
                    </div>
                    <!-- confirm password -->
                    <div class="form-outline mb-4">
                        <label for="conf_user_password" class="form-label">Confirm Password</label>
                        <input type="password" name="conf_user_password" id="conf_user_password" class="form-control" placeholder="Confirm Password" autocomplete="off" required minlength="8" maxlength="20" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,20}$">
                        <small id="conf_password_error" class="text-danger"></small>
                    </div>
                    <!-- address -->
                    <div class="form-outline mb-4">
                        <label for="user_address" class="form-label">Address</label>
                        <input type="text" name="user_address" id="user_address" class="form-control" placeholder="Enter Your Address" autocomplete="off" required="required">
                    </div>
                    <!-- contact -->
                    <div class="form-outline mb-4">
                        <label for="user_contact" class="form-label">Contact</label>
                        <input type="tel" name="user_contact" id="user_contact" class="form-control" placeholder="Enter Your Contact Number" autocomplete="off" required pattern="[0-9]{10}">
                        <small id="contact_error" class="text-danger"></small>
                        <small class="form-text text-muted">Contact number must contain exactly 10 digits.</small>
                    </div>

                    <div class="mt-4 pt-2">
                        <input type="submit" value="Register" class="bg-info py-2 px-3 border-0" name="user_register">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="user_login.php" class="text-danger text-decoration-none">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<!-- php code -->

<?php
if (isset($_POST["user_register"])) {
    $user_username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
    $conf_user_password = $_POST['conf_user_password'];
    $user_address = $_POST['user_address'];
    $user_contact = $_POST['user_contact'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    $user_ip = getIPAddress();

    //select query

    $select_query = "SELECT * FROM `user_table` WHERE username='$user_username' OR user_email='$user_email'";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);
    if ($rows_count > 0) {
        echo "<script>alert('Username and Email Already Exists')</script>";
    } else if ($user_password != $conf_user_password) {
        echo "<script>alert('Password do not match')</script>";
    } else {
        // insert query
        move_uploaded_file($user_image_tmp, "./user_images/$user_image");
        $insert_query = "INSERT INTO `user_table` (username,user_email,user_password,user_image,user_ip,user_address,user_mobile) VALUES
        ('$user_username','$user_email','$hash_password','$user_image','$user_ip','$user_address','$user_contact')";
        $sql_execute = mysqli_query($con, $insert_query);
        echo "<script>alert('Registered Successfully')</script>";
    }


    //selecting cart items
    $select_cart_items = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
    $result_cart = mysqli_query($con, $select_cart_items);
    $rows_count = mysqli_num_rows($result_cart);
    if ($rows_count > 0) {
        $_SESSION['username'] = $user_username;
        echo "<script>alert('You have items in your cart')</script>";
        echo "<script>window.open('checkout.php','_self')</script>";
    } else {
        echo "<script>window.open('./user_login.php','_self')</script>";
    }
}
?>