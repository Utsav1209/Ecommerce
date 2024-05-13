<?php include("../includes/connect.php"); ?>

<body>
    <div class="row">
        <div class="col-md-2">
            <?php include("./navigation.php"); ?>
        </div>
        <div class="col-md-10 text-center">
            <h3 class="text-center text-success mb-4">Edit Account</h3>
            <form ng-submit="updateAccount()" enctype="multipart/form-data" method="post">
                <div class="form-outline mb-4">
                    <input type="text" class="form-control w-50 m-auto" ng-model="formData.username" required minlength="5" maxlength="20">
                </div>
                <div class="form-outline mb-4">
                    <input type="email" class="form-control w-50 m-auto" ng-model="formData.user_email">
                </div>
                <div class="form-outline mb-4 d-flex w-50 m-auto">
                    <input type="file" name="user_image" class="form-control m-auto" ng-model="formData.user_image" accept="image/jpeg, image/png" ngf-select>
                    <img ng-src="../users_area/user_images/{{ formData.user_image }}" alt="" class="edit_image">
                    <small id="image_error" class="text-danger"></small>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" class="form-control w-50 m-auto" ng-model="formData.user_address">
                </div>
                <div class="form-outline mb-4">
                    <input type="tel" class="form-control w-50 m-auto" ng-model="formData.user_mobile" required pattern="[0-9]{10}">
                    <small id="contact_error" class="text-danger"></small>
                </div>
                <input type="hidden" name="user_update" value="true">
                <input type="submit" value="Update" class="bg-info py-2 px-3 border-0" ng-disabled="updateSuccess">
            </form>
            <div class="text-success" ng-if="updateSuccess">
                Account updated successfully!
            </div>
        </div>
    </div>
    <script>
        <?php
        if (isset($_POST['user_update']) && $_POST['user_update'] === 'true') {
            echo "swal('Success', 'Account updated successfully!', 'success');";
        }
        ?>
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>