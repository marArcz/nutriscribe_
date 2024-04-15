<nav id="navbar" class="navbar bg-white navbar-dark shadow-sm py-0">
    <div class="w-100 ">
        <div class="container-fluid d-flex align-items-center py-2">
            <div>
                <button class="btn btn-sm text-secondary border-0 d-flex align-items-center" id="menu-toggler" type="button"><i class="bx bx-menu fs-4"></i></button>
            </div>
            <div class="ms-auto" id="navbarNav">
                <ul class="nav flex-row ms-auto align-items-center my-0">
                    <li class="nav-item">
                        <div class="dropdown">
                            <button id="menu-toggler" class="btn btn-sm d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- <div class="text-profile-pic bg-light-brown text-dark ">
                                    <div class="text fw-normal">
                                        <?= $admin['firstname'][0] .  $admin['lastname'][0] ?>
                                    </div>
                                </div> -->

                                <?php $profile_pic_size = 'sm';
                                require '../includes/user-profile-pic.php' ?>
                                <div class="text-start">
                                    <p class="my-0 fw-semibold"><?= $admin['firstname'] . ' ' .  $admin['lastname'] ?></p>
                                    <p class="my-0">
                                        <small>Admin</small>
                                    </p>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end py-0">
                                <li class="border-bottom py-1">
                                    <a class="dropdown-item" href="profile.php">
                                        <i class="bi bi-person-fill me-2"></i>
                                        <small>Profile</small>
                                    </a>
                                </li>
                                <li class="border-bottom py-2">
                                    <a class="dropdown-item delete" href="../app/logout.php">
                                        <i class="bi bi-sign-out me-2"></i>
                                        <small>Log out</small>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<?php if (Session::hasSession('success')) : ?>
    <div class="alert bg-green-accent bg-opacity-75 shadow-sm fw-normal py-2 rounded-0 alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class='bx bxs-check-circle bx-sm text-white me-3'></i>
        <span class="text-white"><?= Session::getSuccess() ?></span>
        <button type="button" class="btn btn-sm my-0 ms-auto" data-bs-dismiss="alert" aria-label="Close">
            <i class="bx bx-x bx-sm text-white"></i>
        </button>
    </div>
<?php endif ?>