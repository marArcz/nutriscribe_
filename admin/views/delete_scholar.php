<?php require_once '../includes/authenticated.php' ?>
<?php
require '../app/delete_scholar.php';

if (!isset($_GET['id'])) {
    Session::redirectTo('scholars.php');
    exit;
}

$id = $_GET['id'];

$query = $pdo->prepare('SELECT * FROM scholar_infos WHERE scholar_account_id = ?');
$query->execute([$id]);

$user_info = $query->fetch();

if (!$user_info) {
    Session::redirectTo("scholars.php");
    exit;
}

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
                <div class="d-flex mb-4 gap-2 align-items-center">
                    <p class="text-dark fw-medium">BN Scholars</p>
                    <p class="text-dark fw-medium">
                        <span class="bx bx-chevron-right"></span>
                    </p>
                    <p class="text-dark fw-medium">Delete</p>
                </div>
                <div class="col-md-6 mx-auto mt-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                <div class="mb-3">
                                    <p for="" class="mb-1 text-secondary fw-medium">Confirm Action</p>
                                    <p for="" class="mb-3 fs-5 text-dark fw-medium">Are you sure to delete this user?</p>
                                    <input type="text" readonly value="<?= $user_info['firstname'] . (empty($user_info['middlename']) ? '' : ' ' . $user_info['middlename']) . ' ' . $user_info['lastname'] ?>" class="form-control text-green fw-medium fs-5" name="title" required>
                                </div>
                                <div class="mt-5 d-flex gap-3">
                                    <a href="javascript:history.go(-1)" class="btn btn-light-dark text-light fw-medium col mx-auto">Cancel</a>
                                    <button class="btn btn-secondary text-light fw-medium col mx-auto" name="submit" type="submit">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
</body>

</html>