<?php
require_once '../includes/authenticated.php';
require '../app/reset_scholar_password.php';

if (!isset($_GET['username'])) {
    Session::redirectTo("scholars.php");
    exit;
}

$username = $_GET['username'];
$query = $pdo->prepare("SELECT scholar_infos.*,scholar_accounts.id AS scholar_account_id FROM scholar_accounts INNER JOIN scholar_infos ON scholar_accounts.id = scholar_infos.scholar_account_id WHERE username = ?");
$query->execute([$username]);

$scholar = $query->fetch();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BN Scholars | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php
    $current_page = 'scholars';
    require_once '../includes/sidebar.php'
    ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'Dashboard'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid-sm">
                <div class=" mb-4">
                    <p class="text-secondary mb-1 fw-medium">BN Scholars</p>
                    <p class="text-light-brown fs-6 fw-medium">Reset Password</p>
                </div>

                <div class="mt-4">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div id="profile-pic-div" class="image-div md" data-image="../../assets/images/<?= $scholar['photo'] ?>"></div>
                        <div>
                            <p class="mb-1 mt-2 fw-medium fs-5">
                                <?= $scholar['firstname'] ?> <?= $scholar['middlename'] ?> <?= $scholar['lastname'] ?>
                            </p>
                            <p class="my-1 fw-normal text-green-accent">BN Scholar</p>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-3">
                        <strong>Note:</strong> You will need to provide a temporary password that will be used for this account. After signing into this account, the user will then be asked to create their new password.
                    </div>

                    <div class="card mt-3 border shadow-sm">
                        <div class="card-body">
                            <form action="#form" method="post" id="form">
                                <p class="text-secondary form-text">Temporary password</p>
                                <div class="mb-3">
                                    <label for="" class="form-label fw-normal text-gray2">Password:</label>
                                    <input type="password" name="password" required class="form-control">
                                    <?php if (isset($error)) : ?>
                                        <p class="mt-0 mb-2 form-text text-danger"><?= $error ?></p>
                                    <?php endif ?>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label fw-normal text-gray2">Repeat Password:</label>
                                    <input type="password" name="confirm_password" required class="form-control">
                                </div>
                                <div class="row gy-2">
                                    <div class="col-md">
                                        <a class="btn btn-light-dark col-12" href="scholars.php">Cancel</a>
                                    </div>
                                    <div class="col-md">
                                        <button class="fw-medium btn btn-green-accent col-12" type="submit" name="reset">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
    <script>
        $(function() {
            const setPasswordvalue = () => {
                $("#password-input").val($("#lastname-input").val().toUpperCase());
            }

            $("#lastname-input").on('input', (e) => {
                setPasswordvalue();
            })
            $("#lastname-input").on("blur", (e) => {
                setPasswordvalue();
            })
        })
    </script>
</body>

</html>