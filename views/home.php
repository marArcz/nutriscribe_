<?php require_once '../includes/auth.php' ?>
<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BN Scholar</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php
    $current_page = 'home';
    require_once '../includes/sidebar.php'
    ?>
    <?php require_once '../includes/navbar.php' ?>
    <main id="main" class="expanded">
        <?php $header_title = 'Dashboard'; ?>
        <div class="row gap-3 align-items-center">
            <div class="col-lg-4 flex-1 col-md-6 col-sm-12 position-relative">
                <div class="card user-card shadow-none border rounded-0">
                    <div class="card-header border-0 p-0 position-relative">
                        <img src="../assets/images/card-header-bg.png" class="w-100" alt="">
                        <div class="user-card__name">
                            <p class="my-1 fw-medium fs-5">
                                <?= $user['firstname'] ?> <?= $user['middlename'] ?> <?= $user['lastname'] ?>
                            </p>
                        </div>
                        <div class="user-card__photo">
                            <?php $profile_pic_size = 'xl';
                            require '../includes/user-profile-pic.php' ?>
                        </div>
                    </div>
                    <div class="card-body pt-2 px-4">
                        <div class="text-end">
                            <a href="profile.php" class="btn rounded-pill btn-dark-brown text-dark px-4 shadow-sm">
                                <i class="bx bx-pencil"></i>
                                <span class="fw-medium">Edit</span>
                            </a>
                        </div>
                        <div class="mt-4">
                            <div class="mb-4">
                                <p class="card-text mb-1 text-secondary">Address</p>
                                <p class="card-text fw-medium fs-6"><?= $user['address'] ?></p>
                            </div>
                            <div class="mb-4">
                                <p class="card-text mb-1 text-secondary">Email Address</p>
                                <p class="card-text fw-medium fs-6"><?= $user['email'] ?></p>
                            </div>
                            <div class="mb-4">
                                <p class="card-text mb-1 text-secondary">Phone</p>
                                <p class="card-text fw-medium fs-6"><?= $user['phone'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm align-self-center py-4">
                <div class="container-fluid">
                    <h3 class="text-secondary fw-semibold">Welcome to Nutriscribe!</h3>
                    <p class="text-secondary fw-normal fs-4">You can track activities, submit attendance....</p>

                    <div class="mt-5">
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="attendance.php" class="btn d-flex align-items-center btn-white border shadow-sm px-4 rounded-3 py-3">
                                <img src="../assets/images/clipboard-text-clock.png" alt="">
                                <span class=" ms-3 fs-5 fw-medium text-secondary">Attendance</span>
                            </a>
                            <a href="activities.php" class="btn d-flex align-items-center btn-white border shadow-sm px-4 rounded-3 py-3">
                                <img src="../assets/images/clipboard-list.png" alt="">
                                <span class=" ms-3 fs-5 fw-medium text-secondary">Activities</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require '../includes/footer.php' ?>
    <?php require_once '../includes/scripts.php' ?>
</body>

</html>