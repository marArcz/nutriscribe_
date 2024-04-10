<?php require_once '../includes/auth.php' ?>
<?php
require_once '../app/edit_activity.php';

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
            <div class="col-md-7 mx-auto mt-4">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label fw-medium">Title:</label>
                        <input type="text" value="<?= $activity['title'] ?>" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label fw-medium">Type of activity:</label>
                        <input type="text" class="form-control" name="type" value="<?= $activity['type'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label fw-medium">Location:</label>
                        <input type="text" class="form-control" name="location" required value="<?= $activity['location'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label fw-medium">Beneficiaries:</label>
                        <input type="text" class="form-control" name="beneficiaries" required value="<?= $activity['beneficiaries'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label fw-medium">Date:</label>
                        <input type="date" class="form-control" name="date" required value="<?= date('Y-m-d',strtotime($activity['date'])) ?>">
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-dark-brown text-light fw-medium col-12 col-md-7 mx-auto" name="submit" type="submit">Save Changes</button>
                    </div>
                </form>
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