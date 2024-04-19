<head>
    <title>Edit Account</title>
</head>

<body ng-controller="EditAccountController">
    <h3 class="text-center text-success mb-4">Edit Account</h3>
    <form ng-submit="updateAccount()" enctype="multipart/form-data">
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" ng-model="formData.username" required minlength="5" maxlength="20">
        </div>
        <div class="form-outline mb-4">
            <input type="email" class="form-control w-50 m-auto" ng-model="formData.user_email">
        </div>
        <div class="form-outline mb-4 d-flex w-50 m-auto">
            <input type="file" class="form-control m-auto" ng-model="formData.user_image" accept="image/jpeg, image/png, image/jpg">
            <img ng-src="{{ imageSrc }}" alt="" class="edit_image">
            <small id="image_error" class="text-danger"></small>
        </div>
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" ng-model="formData.user_address">
        </div>
        <div class="form-outline mb-4">
            <input type="tel" class="form-control w-50 m-auto" ng-model="formData.user_mobile" required pattern="[0-9]{10}">
            <small id="contact_error" class="text-danger"></small>
        </div>
        <input type="submit" value="Update" name="user_update" class="bg-info py-2 px-3 border-0">
    </form>

    <div class="text-success" ng-if="updateSuccess">
        Account updated successfully!
    </div>

</body>