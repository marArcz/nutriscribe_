<?php require_once '../includes/auth.php' ?>
<?php
require '../app/add_attendance.php';
require '../app/edit-profile.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance | BN Scholar</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php
    $current_page = 'profile';
    require_once '../includes/sidebar.php'
    ?>
    <?php require_once '../includes/navbar.php' ?>
    <main id="main" class="expanded bg-white">
        <?php include '../includes/alerts.php'; ?>
        <?php $header_title = 'profile'; ?>
        <div class="content">
            <div class="container-fluid">
                <div class="">
                    <!-- <header class="content-header">
                        <div class="container-fluid">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-user fs-3 my-0 text-light-brown"></i>
                                <span class="text-gray2 ms-3 fw-medium fs-5">Profile</span>
                            </div>
                        </div>
                    </header>
                    <br> -->
                    <h5 class="text-dark fw-medium">Profile</h5>
                    <p>Update your photo and personal details</p>
                    <hr>
                    <form enctype="multipart/form-data" action="" method="post">
                        <div class="edit-profile-photo-group">
                            <div class="wrapper">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#photo-modal" class="camera-btn">
                                    <i class="bx bxs-camera"></i>
                                </button>
                                <?php $profile_pic_size = 'lg';
                                require '../includes/user-profile-pic.php' ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="firstname" class="col-sm-2 fw-normal col-form-label">Firstname</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?= isset($_POST['submit']) ? $firstname : $user['firstname'] ?>" class="form-control" name="firstname" id="firstname">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="middlename" class="col-sm-2 fw-normal col-form-label">Middlename</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?= isset($_POST['submit']) ? $middlename : $user['middlename'] ?>" class="form-control" name="middlename" id="middlename">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lastname" class="col-sm-2 fw-normal col-form-label">Lastname</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?= isset($_POST['submit']) ? $lastname : $user['lastname'] ?>" class="form-control" name="lastname" id="lastname">
                            </div>
                        </div>
                        <div class="row mb-5">
                            <label for="username" class="col-sm-2 fw-normal col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?= isset($_POST['submit']) ? $username : $user['username'] ?>" class="form-control" name="username" id="username">
                                <?php if (isset($error['username'])) : ?>
                                    <p class="my-1 form-text text-danger"><?= $error['username'] ?></p>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button class="btn btn-dark-brown text-light" type="submit" name="edit-info">Save Changes</button>
                        </div>
                    </form>
                </div>
                <div class=" mt-3 mb-5">
                    <h5 class="text-dark">Password</h5>
                    <p>Change your account's password</p>
                    <hr>
                    <form action="#password-form" method="post" autocomplete="off" id="password-form">
                        <div class="row mb-3">
                            <label for="current-password" class="col-sm-2 fw-normal col-form-label">Current Password</label>
                            <div class="col-sm-10">
                                <input type="password" value="" class="form-control" name="current_pass" id="current-password">
                                <?php if (isset($password_err['current'])) : ?>
                                    <p class="form-text text-danger"><?= $password_err['current'] ?></p>
                                <?php endif ?>
                                <?php if (isset($error['current_pass'])) : ?>
                                    <p class="my-1 form-text text-danger"><?= $error['current_pass'] ?></p>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="new-password" class="col-sm-2 fw-normal col-form-label">New Password</label>
                            <div class="col-sm-10">
                                <input type="password" value="" class="form-control" name="new_pass" id="new-password">
                                <?php if (isset($password_err['new'])) : ?>
                                    <p class="form-text text-danger"><?= $password_err['new'] ?></p>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <label for="confirm-password" class="col-sm-2 fw-normal col-form-label">Confirm new password</label>
                            <div class="col-sm-10">
                                <input type="password" value="" class="form-control" name="confirm_pass" id="confirm-password">
                                <?php if (isset($password_err['confirm_pass'])) : ?>
                                    <p class="my-1 form-text text-danger"><?= $password_err['confirm_pass'] ?></p>
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
    <?php require '../includes/footer.php' ?>
    <?php require '../includes/profile-modals.php' ?>
    <?php require_once '../includes/scripts.php' ?>

    <script>
        $(function() {
            // live update of time
            const updateTime = () => {
                let timeTxt = $("#text-time");
                let timeInput = $("#input-time");
                let date = new Date();

                let H = date.getHours();
                let h = H > 12 ? H - 12 : H;
                h = h >= 10 ? h : '0' + h;
                let m = date.getMinutes() >= 10 ? date.getMinutes() : '0' + date.getMinutes();

                timeTxt.html(`${h}:${m} ${H >= 12 ? 'PM' : 'AM'}`)
                timeInput.val(`${H >= 10 ? H : '0' + H}:${m}`)
            }
            setInterval(updateTime, 1000)

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