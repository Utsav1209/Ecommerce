<!-- Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    Are you sure you want to delete your account? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<h3 class="text-danger mb-4">Delete Account</h3>
<form action="" method="post" class="mt-5">
    <div class="form-outline mb-4">
        <input type="button" class="form-control w-50 m-auto btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" value="Delete Account">
    </div>
    <div class="form-outline mb-4">
        <input type="submit" value="Don't Delete Account" class="form-control w-50 m-auto btn btn-secondary" name="dont_delete">
    </div>
</form>

<?php
$username_session = $_SESSION['username'];
if (isset($_POST['delete'])) {
    // Add code to delete the account here
    $delete_query = "DELETE FROM `user_table` WHERE username='$username_session'";
    $result = mysqli_query($con, $delete_query);
    if ($result) {
        session_destroy();
        echo "<script>alert('Account Deleted Successfully')</script>";
        echo "<script>window.open('../index.php','_self')</script>";
    }
}

if (isset($_POST['dont_delete'])) {
    echo "<script>window.open('profile.php','_self')</script>";
}
?>