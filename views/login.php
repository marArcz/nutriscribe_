<?php
require_once '../includes/session.php';
require_once '../app/login.php';

// if already signed in redirect to homepage
if (Session::getUser($pdo)) {
    Session::redirectTo("home.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles/css/custom.css">
    <link rel="stylesheet" href="../assets/styles/css/user_login.css">
    <link rel="stylesheet" href="../assets/styles/css/components.css">
    <link rel="stylesheet" href="../assets/styles/css/typography.css">
    <link rel="stylesheet" href="../node_modules/boxicons/css/boxicons.min.css">
    <title>Login - Nutriscribe</title>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="#" class="text-light">
                Nutriscribe
                <span>BN Scholar Portal</span>
            </a>
        </div>
    </nav>
    <main>
        <section class="container login-form">
            <div class="text-center">
                <img src="../assets/images/logo.png" class="img-fluid logo" alt="">
                <h3 class="mt-3 fw-bold text-light">Sign In</h3>
                <p class=" fw-light text-light fs-5">Welcome to Nutriscribe, sign in to your account!</p>

                <div class="col-10 col-lg-3 col-md-5 col-sm-10 col-xs-10 mt-5 mx-auto">
                    <?php if (Session::hasSession('error')) : ?>
                        <div class="alert alert-danger text-start">
                            <i class="bx bx-info-circle"></i>
                            <?= Session::getError() ?>
                        </div>
                    <?php endif ?>
                    <form action="" method="post">
                        <?php if (isset($error)) : ?>
                            <!-- <p class="text-white fw-medium text-start fs-5"><?= $error ?></p> -->
                            <div class="alert alert-danger text-start fw-medium" role="alert">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>
                        <input value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>" required type="text" name="username" class=" bg-green-20 input text-light" placeholder="Username">
                        <input required type="password" name="password" class=" bg-green-20 input mt-4 text-light" placeholder="Password">
                        <div class="text-start mt-4 d-flex">
                            <input type="checkbox" id="remember-me" class="checkbox" name="remember">
                            <label class="text-light ms-2" for="remember-me">Remember me</span>
                        </div>
                        <br>
                        <div class="mt-4 mb-2 d-grid">
                            <button type="submit" name="login" class="btn btn-light fs-5 rounded text-dark">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>

</html>