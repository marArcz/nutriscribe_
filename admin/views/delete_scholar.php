<?php require_once '../includes/authenticated.php' ?>
<?php
require '../app/delete_scholar.php';

if(!isset($_GET['id'])){
    Session::redirectTo('scholars.php');
    exit;
}

$id = $_GET['id'];

$query = $pdo->prepare('SELECT * FROM scholar_infos WHERE scholar_account_id = ?');
$query->execute([$id]);

$user_info = $query->fetch();

if(!$user_info){
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
                <div class="d-flex mb-4">
                    <h6 class="text-dark">BN Scholars</h6>
                </div>
                <div class="mt-3">
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                        <h4 class="text-danger">Do you really want to delete this BN Scholar?</h3>
                        <h5 class="mb-4"><?= $user_info['firstname'] . (empty($user_info['middlename']) ? '' : ' ' . $user_info['middlename']) . ' ' . $user_info['lastname'] ?></h5>
                        <div class="mt-3">
                            <div class="d-flex gap-2">
                                <button class="btn btn-danger" type="submit">Yes</button>
                                <a href="scholars.php" class="btn btn-dark">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
</body>

</html>