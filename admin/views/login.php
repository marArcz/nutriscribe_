<?php
require_once '../../conn/conn.php';
require_once '../includes/session.php';
require_once '../app/login.php';

$query = $pdo->prepare('SELECT * FROM admins');
$query->execute();
if ($query->rowCount() == 0) {
    Session::redirectTo('signup.php');
    exit;
} else {
    $admin = Session::getUser($pdo);
    if ($admin) {
        Session::redirectTo('dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_ENV['APP_NAME'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/styles/css/custom.css">
    <link rel="stylesheet" href="../../assets/styles/css/app.css">
    <link rel="stylesheet" href="../../assets/styles/css/typography.css">
    <link rel="shortcut icon" href="../../assets/images/logo.png" type="image/x-icon">
</head>

<body class="bg-light-brown">
    <main>
        <div class="login-container py-3">
            <div class="container">
                <div class="row justify-content-center">
                    <!-- <p class="text-center fs-3 mb-4 fw-bold text-light">Admin Login</p> -->
                    <div class=" col-xl-9 col-md-10">
                        <div class="card border-0 rounded-3 login-card">
                            <div class="card-body d-flex position-relative">
                                <div class="row h-100 w-100 align-items-center login-content gy-4">
                                    <div class="col-md-6 order-1 order-md-0">
                                        <div class="h-100 text-center">
                                            <div class="col-md-7 col-5 col-lg-7 col-sm-6 mx-auto">
                                                <img class="img-fluid" src="../../assets/images/logo.png" alt="">
                                            </div>
                                            <p class="text-center form-text text-sm text-secondary mt-3">
                                                <small><?= $_ENV['APP_NAME'] ?> &copy; <?= date('Y') ?></small>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md order-0 order-md-1">
                                        <form action="" method="post">
                                            <p class="text-green mb-1 fw-medium fs-5 mt-3">Welcome to</p>
                                            <p class="text-green fw-bold fs-2"><?= $_ENV['APP_NAME'] ?></p>
                                            <div class="mt-5">
                                                <p class="text-dark">ADMIN | LOGIN</p>
                                                <?php if (isset($error['email'])) : ?>
                                                    <p class="text-danger form-text"><?= $error['email'] ?></p>
                                                <?php endif ?>
                                                <div class="mb-3">
                                                    <input value="<?= isset($_POST['login'])? $email:'' ?>" type="email" class="form-control custom rounded-0 fw-normal" required name="email" placeholder="Email Address">

                                                </div>
                                                <div class="mb-3">
                                                    <input type="password" class="form-control custom rounded-0 fw-normal" name="password" required placeholder="Password">
                                                    <?php if (isset($error['password'])) : ?>
                                                        <p class="text-danger form-text"><?= $error['password'] ?></p>
                                                    <?php endif ?>
                                                </div>
                                                <div class="mb-3 mt-5">
                                                    <div class="d-flex align-items-center gap-3 flex-wrap">
                                                        <div class="col-12 col-md-auto">
                                                            <button name="login" type="submit" class="btn btn-green-accent col-md-auto w-100 px-lg-5 px-4 py-2 fs-6 rounded-0">
                                                                LOGIN
                                                            </button>
                                                        </div>
                                                        <div>
                                                            <a href="forgot-password.php" class="link-secondary fs-6 text-decoration-none">Forgot Password?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="position-absolute bottom-0 w-100 start-0 d-none footer-bg rounded-3">
                                    <img src="../../assets/images/footer-bg.png" class="img-fluid w-100 rounded-3" alt="">
                                </div>
                                <div class="position-absolute top-0 end-0 d-none">
                                    <img src="../../assets/images/top.png" class="img-fluid rounded-3" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>