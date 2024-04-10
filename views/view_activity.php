<?php require_once '../includes/auth.php' ?>
<?php

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
    <main id="main" class="expanded bg-white">
        <?php $header_title = 'activities'; ?>
        <div class="content">
            <header class="content-header">
                <div class="container-fluid d-flex align-items-center flex-wrap justify-content-between">
                    <div class="d-flex align-items-center me-auto">
                        <!-- <img src="../assets/images/clipboard-list.png" class="img-icon sm" alt=""> -->
                        <i class="bx bxs-note bx-md text-light-brown"></i>
                        <span class="text-gray2 ms-2 fw-medium fs-5">Activities</span>
                        <span class="text-gray2 fw-medium fs-5 ms-2 bx bx-chevron-right"></span>
                        <span class="text-gray2 fs-5 ms-2">View activity</span>
                    </div>
                    <div class="d-flex align-items-center col-md col-12 my-2 justify-content-end">
                        <div class="">
                            <a href="javascript:history.go(-1)" class="btn-add rounded-pill d-flex shadow-sm btn btn-light-dark">
                                <i class="icon bx bx-x fs-5"></i>
                                <span class="text fs-6">Close</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <?php
            // get activity details
            $id = $_GET['id'];
            $query = $pdo->prepare("SELECT * FROM scholar_activities WHERE id = ?");
            $query->execute([$id]);
            $activity = $query->fetch();
            ?>
            <div class="card border-0 mt-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md">
                            <p class="mb-3 text-dark-brown ">
                                <i class="bx bxs-info-circle"></i>
                                <span class="fw-medium">Activity Details</span>
                            </p>
                            <p class="fw-medium fs-4 mb-4 text-green"><?= $activity['title'] ?></p>
                            <div class="mb-3">
                                <p class="fs-6 fw-semibold my-1 text-dark">Type of Activity:</p>
                                <p class="fs-5 fw-normal my-1 text-gray2"><?= $activity['type'] ?></p>
                            </div>
                            <div class="mb-3">
                                <p class="fs-6 fw-semibold my-1 text-dark">Location: </p>
                                <p class="fs-5 fw-normal my-1 text-gray2"><?= $activity['location'] ?></p>
                            </div>
                            <div class="mb-3">
                                <p class="fs-6 fw-semibold my-1 text-dark">Beneficiaries: </p>
                                <p class="fs-5 fw-normal my-1 text-gray2"><?= $activity['beneficiaries'] ?></p>
                            </div>
                            <div class="mb-3">
                                <p class="fs-6 fw-semibold my-1 text-dark">Date: </p>
                                <p class="fs-5 fw-normal my-1 text-gray2"><?= date('F d, Y', strtotime($activity['date'])) ?></p>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="text-end">
                                <p class="my-2 fw-medium">Status:</p>
                                <span class="badge bg-dark-brown fw-medium p-2"><?= $activity['status'] ?></span>
                            </div>
                        </div>
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