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
                        <div class="">
                            <a href="add_activity.php" class="btn-add rounded-pill shadow-sm btn btn-green-accent">
                                <i class="icon bx bx-plus"></i>
                                <span class="text fs-6">Add</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <div class="d-flex align-items-center justify-content-between mt-2">
                <p class=" align-self-center text-secondary my-2 ">
                    Page <?= $page ?> of <?= $total_pages ?>
                </p>
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
            <div class="table-responsive-sm mt-2">
                <table class="table table-hover mb-0 align-middle" id="activities-table">
                    <thead class="table-light">
                        <tr class="">

                            <th class="fw-medium">Project / Task</th>
                            <th class="fw-medium">Date</th>
                            <th class="fw-medium">Location</th>
                            <th class="fw-medium">Beneficiaries</th>
                            <th class="fw-medium">Created At</th>
                            <th class="fw-medium">Status</th>
                            <th class="fw-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($rows) > 0) : ?>
                            <?php
                            foreach ($rows as $key => $row) {
                            ?>
                                <tr>
                                    <th><?= $row['title'] ?></th>
                                    <th><?= date('M d, Y', strtotime($row['date'])) ?></th>
                                    <th><?= $row['location'] ?></th>
                                    <th><?= substring($row['beneficiaries']) ?></th>
                                    <th><?= date('M d, Y', strtotime($row['created_at'])) ?></th>
                                    <th>
                                        <span class="badge fw-medium bg-<?= $row['status'] == 'SUBMITTED' ? 'dark-brown' : 'green-accent' ?>"><?= $row['status'] ?></span>
                                    </th>
                                    <th>
                                        <div class="dropdown">
                                            <a class="btn btn-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class='fs-3 text-dark-brown bx bx-dots-horizontal-rounded'></i>
                                            </a>

                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="view_activity.php?id=<?= $row['id'] ?>">View</a></li>
                                                <li>
                                                    <?php if($row['status'] == 'SUBMITTED'): ?>
                                                        <a class="dropdown-item" href="edit_activity.php?id=<?= $row['id'] ?>">Edit</a>
                                                    <?php else: ?>
                                                        <a class="dropdown-item disabled" title="Cannot be edited anymore." href="edit_activity.php">Edit</a>
                                                    <?php endif; ?>
                                                </li>
                                                <li><a class="dropdown-item" href="delete_activity.php?id=<?= $row['id'] ?>">Delete</a></li>
                                            </ul>
                                        </div>
                                    </th>
                                </tr>
                            <?php
                            }
                            ?>
                        <?php else : ?>
                            <tr>
                                <th colspan="8">
                                    <p class="text-center my-0">Nothing to show.</p>
                                </th>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
                <div class="table-pagination bg-light py-2">
                    <div class="d-flex align-items-center">
                        <div class="ps-3">

                            <p class=" align-self-center text-secondary my-2 ">
                                Showing <?= $offset + 1 ?> to <?= $offset + count($rows) ?> of <?= $total_rows ?> entries.
                            </p>
                        </div>
                        <div class="ms-auto d-flex gap-3 align-items-center">
                            <a href="?page=<?= $page - 1 ?>" class="<?= ($page - 1) <= 0 ? 'disabled border-0' : '' ?> d-flex align-items-center btn text-btn-green-accent fw-medium">
                                <i class="bx bx-skip-previous"></i>
                                Prev
                            </a>
                            <a href="?page=<?= $page + 1 ?>" class="<?= ($page + 1) > $total_pages ? 'disabled border-0' : '' ?> d-flex align-items-center btn text-btn-green-accent fw-medium">
                                Next
                                <i class="bx bx-skip-next"></i>
                            </a>
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