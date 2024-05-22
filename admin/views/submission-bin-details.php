<?php require_once '../includes/authenticated.php' ?>
<?php
if (!isset($_GET['sb'])) {
    Session::redirectTo('scholar_activities.php');
    exit;
}

$submission_bin_id = $_GET['sb'];
$query = $pdo->prepare("SELECT * FROM submission_bins WHERE id = ?");
$query->execute([$submission_bin_id]);

$submission_bin = $query->fetch();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $submission_bin['title'] ?> | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php
    $current_page = 'scholar_activities';
    require_once '../includes/sidebar.php'
    ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid-sm">
                <div class="d-flex mb-4">
                    <h5 class="text-dark fw-semibold">
                        Scholar Activities
                    </h5>
                </div>

                <a href="scholar_activities.php" class="link-secondary text-decoration-none">
                    <i class="bx bx-arrow-back"></i>
                    <span class="ms-1">Submission bins</span>
                </a>

                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body p-lg-4">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="circle-icon bg-green-accent">
                                <i class="bx bx-notepad"></i>
                            </div>
                            <p class="my-0 fs-4"><?= $submission_bin['title'] ?></p>
                        </div>
                        <p class="mb-0 text-secondary mt-2 text-sm">
                            Due on <?= date('M d, Y', strtotime($submission_bin['deadline'])) ?>, <?= date('h:i A', strtotime($submission_bin['deadline'])) ?>
                        </p>
                        <hr>
                        <p class="text-secondary fw-light">
                            <?= $submission_bin['instructions'] != null && $submission_bin['instructions'] != '' ? $submission_bin['instructions'] : 'No instructions.' ?>
                        </p>

                        <div class=" mt-5">
                            <?php
                            // get submission count 
                            $q = $pdo->prepare('SELECT id FROM submissions WHERE submission_bin_id = ?');
                            $q->execute([$submission_bin['id']]);
                            $reports_count = $q->rowCount();
                            $q = $pdo->prepare('SELECT id FROM scholar_accounts');
                            $q->execute();
                            $scholars_count = $q->rowCount();
                            ?>
                            <div class="d-flex justify-content-end align-items-center">
                                <div class=" text-center border-start text-secondary px-3">
                                    <p class=" fs-4"><?= $reports_count ?></p>
                                    <p class="mb-0">Submitted</p>
                                </div>
                                <div class=" text-center border-start text-secondary px-3">
                                    <p class=" fs-4"><?= $scholars_count ?></p>
                                    <p class="mb-0">BN Scholars</p>
                                </div>
                            </div>
                        </div>

                        <?php if ($reports_count > 0) : ?>
                            <a href="submissions.php" class="mt-2 btn btn-green">
                                View Submissions
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
</body>

</html>