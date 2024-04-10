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
    <main id="main" class="expanded bg-white">
        <?php $header_title = 'Dashboard'; ?>
        <div class="content">
            <header class="content-header">
                <div class="container-fluid">
                    <div class="d-flex align-items-center">
                        <img src="../assets/images/clipboard-list.png" class="img-icon sm" alt="">
                        <span class="text-secondary ms-2 fw-medium fs-6">Activities</span>
                    </div>
                </div>

            </header>
        </div>
    </main>
    <?php require '../includes/footer.php' ?>
    <?php require_once '../includes/scripts.php' ?>
</body>

</html>