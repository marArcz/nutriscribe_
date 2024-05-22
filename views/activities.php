<?php require_once '../includes/auth.php' ?>
<?php
$is_searching = isset($_GET['search']);
// pagination
$limit = 5;
// get number of pages
if ($is_searching) {
    $search = $_GET['search'];
    $query = $pdo->prepare("SELECT id FROM scholar_activities WHERE scholar_id = :scholar_id AND scholar_id = :scholar_id AND (title LIKE :search OR date LIKE :search OR location LIKE :search OR type LIKE :search OR beneficiaries LIKE :search)");
    $query->execute([':scholar_id' => $user['scholar_info_id'], ':search' => "%$search%"]);
} else {
    $query = $pdo->prepare("SELECT id FROM scholar_activities WHERE scholar_id = ?");
    $query->execute([$user['scholar_info_id']]);
}
$total_rows = $query->rowCount();
$total_pages = ceil($total_rows / $limit);
//page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// if (($page > $total_pages || $page <= 0) && !$is_searching) {
//     Session::redirectTo("?page=1");
// }
$offset = ($page - 1) * $limit;

if ($is_searching) {
    $search = $_GET['search'];
    $query = $pdo->prepare("SELECT * FROM scholar_activities WHERE scholar_id = :scholar_id AND (MONTHNAME(date) LIKE :search OR title LIKE :search OR date LIKE :search OR location LIKE :search OR type LIKE :search OR beneficiaries LIKE :search) LIMIT $limit OFFSET $offset");
    $query->execute([':scholar_id' => $user['scholar_info_id'], ':search' => "%$search%"]);
} else {
    $query = $pdo->prepare("SELECT * FROM scholar_activities WHERE scholar_id = ? LIMIT $limit OFFSET $offset");
    $query->execute([$user['scholar_info_id']]);
}

$rows = $query->fetchAll(PDO::FETCH_ASSOC);
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
        <?php include '../includes/alerts.php'; ?>
        <?php $header_title = 'activities'; ?>
        <div class="content">
            <header class="content-header">
                <div class="container-fluid d-flex align-items-center flex-wrap justify-content-between">
                    <div class="d-flex align-items-center me-auto">
                        <!-- <img src="../assets/images/clipboard-list.png" class="img-icon sm" alt=""> -->
                        <i class="bx bxs-note bx-md text-light-brown"></i>
                        <span class="text-gray2 ms-2 fw-medium fs-5">Activities</span>
                    </div>
                    <div class="d-flex align-items-center col-md col-12 my-2 flex-wrap justify-content-end">
                        <div class="search-input d-flex me-3 shadow-sm rounded-4 col-md-4 col ">
                            <i class="icon bx bx-search"></i>
                            <form action="" method="get" class="w-100 d-flex">
                                <input value="<?= $_GET['search'] ?? '' ?>" type="search" name="search" class="py-2 form-control rounded-4" placeholder="Search">
                            </form>
                        </div>

                    </div>
                </div>
            </header>
            <div class="d-flex align-items-center justify-content-between mt-2">
                <?php if (isset($_GET['search'])) : ?>
                    <div class="">
                        <a href="activities.php" class="btn bordered-btn-dark mt-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-x bx-sm"></i>
                                <span>Searching for: <?= $_GET['search'] ?></span>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <!-- submission_bins -->
            <div class="mt-3">
                <p class="fw-medium fs-6">Submission bins</p>
            </div>
            <hr>
            <?php $query = $pdo->query('SELECT * FROM submission_bins ORDER BY id DESC'); ?>
            <div class="accordion" id="accordionExample">
                <?php
                // get 
                while ($row = $query->fetch()) {

                ?>
                    <div class="card active submission-bin-card border-0 bg-transparent mt-1 mb-2">
                        <div class="card-header py-2 px-3" id="heading-<?= $row['id'] ?>">
                            <div class="d-flex align-items-center gap-2 my-2">
                                <button class=" text-dark btn flex-1 flex-fill border-0 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-item-<?= $row['id'] ?>" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="row align-items-center ">
                                        <div class="col-auto">
                                            <div class="circle-icon bg-green-accent">
                                                <i class="bx bx-box text-secondary"></i>
                                            </div>
                                        </div>
                                        <div class="ms-1 col">
                                            <div class="row align-items-center">
                                                <div class="col-md-auto col">
                                                    <p class=" my-0 fs-5 text-secondary"><?= $row['title'] ?></p>
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
                                    $q = $pdo->prepare('SELECT id FROM submissions WHERE submission_bin_id = ?');
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
                                <a href="submission_bin.php?sb=<?= $row['id'] ?>" class=" btn btn-light my-2">
                                    Open submission bin
                                </a>
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
    </main>
    <?php require '../includes/footer.php' ?>
    <?php require_once '../includes/scripts.php' ?>

    <script>
        // $("#activities-table")
    </script>
</body>

</html>