<?php require_once '../includes/authenticated.php' ?>
<?php
if (!isset($_GET['id'])) {
    Session::redirectTo("scholar_activities.php");
    exit;
}

$id = $_GET['id'];

$query = $pdo->prepare("SELECT scholar_activities.*,scholar_infos.photo as scholar_photo,scholar_infos.firstname,scholar_infos.lastname,scholar_infos.middlename FROM scholar_activities INNER JOIN scholar_infos ON scholar_activities.scholar_id = scholar_infos.id WHERE scholar_activities.id = ?");
$query->execute([$id]);

$activity = $query->fetch();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BN Scholar Attendance | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-white">
    <?php
    $current_page = 'scholar_activities';
    require_once '../includes/sidebar.php'
    ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'scholar_activities'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid-sm">
                <!-- header -->
                <div class="mb-3">
                    <p class="text-secondary fs-6 fw-medium mb-1">BN Scholar Activities</p>
                    <p class="text-green-accent mb-0 mt-1 fw-medium">View Activity</p>
                </div>
                <div class="text-end">
                    <button class="d-flex align-items-center gap-2 ms-auto btn btn-dark-brown mb-3 rounded-3 px-3 fw-normal text-light" type="button">
                        <span>Update Status</span>
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="card shadow-sm rounded-2 border">
                    <div class="card-body p-4">
                        <p class="mb-3 text-dark-brown ">
                            <i class="bx bxs-info-circle"></i>
                            <span class="fw-medium">Activity Details</span>
                        </p>
                        <div class="row g-2">
                            <div class="col-md">
                                <p class="fs-5 text-green fw-medium"><?= $activity['title'] ?></p>
                                <div class="mb-3">
                                    <p class="my-1 fs-6 fw-medium">Location:</p>
                                    <p class="my-1 fs-6"><?= $activity['location'] ?></p>
                                </div>
                                <div class="mb-3">
                                    <p class="my-1 fs-6 fw-medium">Beneficiaries:</p>
                                    <p class="my-1 fs-6"><?= $activity['beneficiaries'] ?></p>
                                </div>
                                <div class="mb-3">
                                    <p class="my-1 fs-6 fw-medium">Type:</p>
                                    <p class="my-1 fs-6"><?= $activity['type'] ?></p>
                                </div>
                                <div class="mb-3">
                                    <p class="my-1 fs-6 fw-medium">Status:</p>
                                    <p class="my-1 fs-6">
                                        <span class=" fw-medium text-<?= $activity['status'] == 'SUBMITTED' ? 'dark-brown' : 'success' ?>"><?= $activity['status'] ?></span>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <p class="my-1 fs-6 fw-medium">Date:</p>
                                    <p class="my-1 fs-6"><?= date('M d, Y', strtotime($activity['date'])) ?></p>
                                </div>
                            </div>
                            <div class="col-md">
                                <p class="badge bg-success fw-normal">Submitted By:</p>
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div class="image-div sm" data-image="../../assets/images/<?= $activity['scholar_photo'] ?>"></div>
                                    <p class="fw-medium my-0 fs-5 text-gray2"><?= $activity['firstname'] ?> <?= $activity['middlename'] ?> <?= $activity['lastname'] ?></p>
                                </div>
                                <div class="mt-4">
                                    <p class="badge bg-secondary mb-0 fw-bold">Date Submitted:</p>
                                    <p class="mt-3 fs-6 text-gray2 fw-medium"><?= date("M d, Y", strtotime($activity['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
</body>

</html>