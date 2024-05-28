<nav id="navbar" class="navbar bg-green-accent navbar-light shadow-sm py-0">
    <div class="w-100 ">
        <div class="container-fluid d-flex align-items-center py-2">
            <div class="d-block d-lg-none">
                <button class="btn btn-light" type="submit" id="menu-toggler">
                    <i class="bx bx-menu"></i>
                </button>
            </div>
            <div class="ms-auto ms-lg-1">
                <a class=" d-flex py-2 link-light justify-content-center align-items-center text-decoration-none" href="home.php">
                    <img src="../assets/images/logo.png" width="40" alt="">
                    <small class="ms-2 text-light fw-bold title">Nutriscribe</small>
                </a>
            </div>
            <div class="ms-auto" id="navbarNav">
                <ul class="nav flex-row ms-auto align-items-center my-0">
                    <li class="nav-item">
                        <div class="dropdown">
                            <button id="menu-toggler" class="btn btn-sm d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $user['firstname'][0] .  $user['lastname'][0] ?>
                                <?php
                                $profile_pic_size = 'sm';
                                require_once '../includes/user-profile-pic.php'
                                ?>
                                <div class="text-start text-light d-none d-md-block">
                                    <p class="my-0 fw-semibold"><?= $user['firstname'] . ' ' .  $user['lastname'] ?></p>
                                    <p class="my-0">
                                        <small>BN Scholar</small>
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
                                    <a class="dropdown-item delete" href="logout.php">
                                        <i class="bx bx-log-out me-2"></i>
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