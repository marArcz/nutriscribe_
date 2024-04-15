<?php require_once '../includes/authenticated.php' ?>
<?php require_once '../app/edit-profile.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php
    $current_page = 'profile';
    require_once '../includes/sidebar.php'
    ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid">
                <div class="">
                    <h5 class="text-dark">Profile</h5>
                    <p>Update your photo and personal details</p>
                    <hr>
                    <div class="edit-profile-photo-group">
                        <div class="wrapper">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#photo-modal" class="camera-btn">
                                <i class="bx bxs-camera"></i>
                            </button>
                            <?php $profile_pic_size = 'lg';
                            require '../includes/user-profile-pic.php' ?>
                        </div>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                        <div class="row mb-3">
                            <label for="firstname" class="col-sm-2 fw-normal col-form-label">Firstname</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?= isset($_POST['submit']) ? $firstname : $admin['firstname'] ?>" class="form-control" name="firstname" id="firstname">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lastname" class="col-sm-2 fw-normal col-form-label">Lastname</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?= isset($_POST['submit']) ? $lastname : $admin['lastname'] ?>" class="form-control" name="lastname" id="lastname">
                            </div>
                        </div>
                        <div class="row mb-5">
                            <label for="email" class="col-sm-2 fw-normal col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" value="<?= isset($_POST['submit']) ? $email : $admin['email'] ?>" class="form-control" name="email" id="email">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button class="btn btn-dark-brown text-light" type="submit" name="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
                <div class=" mt-3 mb-5">
                    <h5 class="text-dark">Password</h5>
                    <p>Change your account's password</p>
                    <hr>
                    <form action="" method="post" autocomplete="off">
                        <input type="hidden" name="id" value="<?= $admin['id'] ?>">
                        <div class="row mb-3">
                            <label for="current-password" class="col-sm-2 fw-normal col-form-label">Current Password</label>
                            <div class="col-sm-10">
                                <input type="password" value="<?= isset($_POST['change_pass']) ? $current_pass : '' ?>" class="form-control" name="current_pass" id="current-password">
                                <?php if (isset($error['current_pass'])) : ?>
                                    <p class="my-1 form-text text-danger"><?= $error['current_pass'] ?></p>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="new-password" class="col-sm-2 fw-normal col-form-label">New Password</label>
                            <div class="col-sm-10">
                                <input type="password" value="" class="form-control" name="new_pass" id="new-password">
                                <?php if (isset($error['confirm_pass'])) : ?>
                                    <p class="my-1 form-text text-danger"><?= $error['confirm_pass'] ?></p>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <label for="confirm-password" class="col-sm-2 fw-normal col form-label">Confirm new password</label>
                            <div class="col-sm-10">
                                <input type="password" value="" class="form-control" name="confirm_pass" id="confirm-password">
                                <?php if (isset($error['confirm_pass'])) : ?>
                                    <p class="my-1 form-text text-danger"><?= $error['confirm_pass'] ?></p>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button class="btn btn-dark-brown text-light" type="submit" name="change_pass">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/profile-modals.php' ?>
    <?php require_once '../includes/scripts.php' ?>
    <script>
        $(function() {
            $("#profile-pic-input").change(function(e) {
                if (e.target.files.length > 0) {
                    let photo = e.target.files[0];
                    console.log(photo)
                    $('#text-profile-pic').addClass('d-none');
                    $('#modal-profile-pic-div').removeClass('d-none')
                    $('#modal-profile-pic-div').css("background-image", `url('${URL.createObjectURL(photo)}')`).data('image', URL.createObjectURL(photo))
                }
            })
        })
    </script>
</body>

</html>