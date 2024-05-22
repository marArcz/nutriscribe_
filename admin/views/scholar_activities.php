<?php require_once '../includes/authenticated.php' ?>
<?php
$page_query_param = $_GET;

// function updateQueryParam()
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BN Scholar Activities | Admin</title>
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
                <div class="mb-4">
                    <p class="text-dark mb-1 fs-5 fw-medium">BN Scholar Activities</p>
                    <!-- <p class="text-dark">Submission Bins</p> -->
                </div>

                <!-- submission bins -->
                <a href="add_submission_bin.php" class="btn btn-green-accent rounded-pill">
                    <i class="bx bx-plus"></i>
                    <span>Create</span>
                </a>
                <p class="text-secondary mt-3">
                    This is where you can create submission bins for the activity reports of BN Scholars.
                </p>
                <hr>

                <!-- bins -->
                <div class="mt-3">
                    <!-- <div class="card active border rounded-2 shadow-sm mb-3 submission-bin-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="icon ">
                                        <i class="bx bx-notepad"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="my-0 title fw-medium">Reports for May</p>
                                </div>
                            </div>
                        </div>
                    </div> -->


                    <?php $query = $pdo->query('SELECT * FROM submission_bins ORDER BY id DESC'); ?>
                    <div class="accordion" id="accordionExample">
                        <?php
                        // get 
                        while ($row = $query->fetch()) {

                        ?>
                            <div class="card active submission-bin-card border shadow-sm bg-white my-1">
                                <div class="card-header py-2 px-3 bg-white" id="heading-<?= $row['id'] ?>">
                                    <div class="d-flex align-items-center gap-2 my-3">
                                        <button class=" text-dark btn flex-1 flex-fill border-0 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-item-<?= $row['id'] ?>" aria-expanded="true" aria-controls="collapseOne">
                                            <div class="row align-items-center ">
                                                <div class="col-auto">
                                                    <div class=" fs-3 d-flex align-items-center">
                                                        <i class="bx bx-box text-secondary"></i>
                                                    </div>
                                                </div>
                                                <div class="ms-1 col">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-auto col">
                                                            <p class="title my-0 text-secondary"><?= $row['title'] ?></p>
                                                        </div>
                                                        <div class="col-auto ms-auto">
                                                            <div class="">
                                                                <?php
                                                                if ($row['deadline']) :
                                                                    $date = date('M d Y', strtotime($row['deadline']));
                                                                    $time = date('h:i:A', strtotime($row['deadline']));
                                                                    $deadline = 'Due ' . $date . ', ' . $time;
                                                                ?>
                                                                    <p class="my-0 text-secondary deadline-text me-3"><?= $deadline ?></p>
                                                                <?php else : ?>
                                                                    <p class="my-0 text-secondary deadline-text me-3">No due date</p>
                                                                <?php endif ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <div id="collapse-item-<?= $row['id'] ?>" class="collapse bg-white" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="card-body py-3 bg-white ">
                                        <div class="d-flex">
                                            <p class="my-0 fs-6 text-secondary text-sm">
                                                Created on <?= date('M d, Y', strtotime($row['created_at']))  ?>
                                            </p>
                                            <div class="dropleft ms-auto">
                                                <button class="btn btn-light btn-sm" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-sm bx-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item fs-12" href="edit-submission-bin.php?id=<?= $row['id'] ?>">Edit</a>
                                                    <a class="dropdown-item fs-12" href="../app/delete-submission-bin.php?id=<?= $row['id'] ?>">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-secondary fw-light">
                                            <?= $row['instructions'] != null && $row['instructions'] != '' ? $row['instructions'] : 'No instructions.' ?>
                                        </p>

                                        <div class=" mt-5">
                                            <?php
                                            // get submission count 
                                            $q = $pdo->prepare('SELECT id FROM submissions WHERE submission_bin_id = ? AND submitted = TRUE');
                                            $q->execute([$row['id']]);
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
                                    </div>
                                    <div class="card-footer d-flex align-items-center bg-white">
                                        <?php if ($reports_count > 0) : ?>
                                            <a href="view-submissions.php?sb=<?= $row['id'] ?>" class=" btn btn-green-accent  ms-auto my-2 ">
                                                View submissions
                                            </a>
                                        <?php else: ?>
                                            <a class=" btn btn-green-accent  ms-auto my-2 disabled text-light">
                                                View submissions
                                            </a>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php if ($query->rowCount() == 0) : ?>
                        <div class="text-center">
                            <img src="../assets/images/empty-box (3).png" class="img-fluid mb-3" width="100" alt="">
                        </div>
                        <p class=" text-center">There are no submission bins to show.</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
</body>

</html>