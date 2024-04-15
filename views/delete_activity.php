<?php require_once '../includes/auth.php' ?>
<?php
require_once '../app/delete_activity.php';

$id = $_GET['id'];

$query = $pdo->prepare("SELECT * FROM scholar_activities WHERE id = ?");
$query->execute([$id]);

$activity = $query->fetch();
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
    $current_page = 'activities';
    require_once '../includes/sidebar.php'
    ?>
    <?php require_once '../includes/navbar.php' ?>
    <main id="main" class="expanded bg-white pb-4">
        <?php $header_title = 'activities'; ?>
        <div class="content">
            <header class="content-header">
                <div class="container-fluid d-flex">
                    <div class="d-flex align-items-center">
                        <!-- <img src="../assets/images/clipboard-list.png" class="img-icon sm" alt=""> -->
                        <i class="bx bxs-note bx-md text-light-brown"></i>
                        <span class="text-gray2 ms-2 fw-medium fs-5">Activities</span>
                        <span class="text-gray2 fw-medium fs-5 ms-2 bx bx-chevron-right"></span>
                        <span class="text-gray2 fs-5 ms-2">Edit activity</span>
                    </div>
                    <div class="ms-auto">
                        <a href="javascript:history.go(-1)" class="btn-add rounded-pill shadow-sm  btn btn-light-dark">
                            <i class="icon bx bx-block"></i>
                            <span class="text fs-6 fw-medium">Cancel</span>
                        </a>
                    </div>
                </div>
            </header>
            <div class="col-md-6 mx-auto mt-4">
                <div class="card">
                    <div class="card-body p-4">
                        <form action="" method="post">
                            <div class="mb-3">
                                <p for="" class="mb-1 text-secondary fw-medium">Confirm Action</p>
                                <p for="" class="mb-3 fs-5 text-dark fw-medium">Are you sure to delete this activity?</p>
                                <input type="text" readonly value="<?= $activity['title'] ?>" class="form-control text-green fw-medium fs-5" name="title" required>
                            </div>
                            <div class="mt-5 d-flex gap-3">
                                <a href="javascript:history.go(-1)" class="btn btn-secondary text-light fw-medium col mx-auto">Cancel</a>
                                <button class="btn btn-dark-brown text-light fw-medium col mx-auto" name="submit" type="submit">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require '../includes/footer.php' ?>
    <?php require_once '../includes/scripts.php' ?>

    <script>
        // $("#activities-table")
    </script>
</body>

</html>