<?php require_once '../includes/authenticated.php' ?>

<?php
require_once '../../conn/conn.php';

// pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$rows_per_page = 10;
$starting_row = ($page - 1) * $rows_per_page;

// get total rows from db
$query = $pdo->prepare("SELECT id FROM scholar_infos");
$query->execute();

$total_rows = $query->rowCount();
$total_pages = ceil($total_rows / $rows_per_page);

// get data
if (isset($_GET['search'])) {
    $search_query = "scholar_infos.firstname LIKE :search || scholar_infos.lastname LIKE :search || scholar_infos.middlename LIKE :search || scholar_infos.email LIKE :search || scholar_infos.address LIKE :search || scholar_infos.phone LIKE :search || scholar_accounts.username LIKE :search";
    $query = $pdo->prepare("SELECT scholar_infos.*,scholar_accounts.username FROM scholar_accounts INNER JOIN scholar_infos ON scholar_accounts.id = scholar_infos.scholar_account_id WHERE $search_query ORDER BY lastname ASC LIMIT $rows_per_page OFFSET $starting_row");
    $search_str = $_GET['search'];
    $query->execute([':search' => "%$search_str%"]);
    $rows = $query->fetchAll();
} else {
    $query = $pdo->prepare("SELECT scholar_infos.*,scholar_accounts.username FROM scholar_accounts INNER JOIN scholar_infos ON scholar_accounts.id = scholar_infos.scholar_account_id ORDER BY lastname ASC LIMIT $rows_per_page OFFSET $starting_row");
    $query->execute();
    $rows = $query->fetchAll();
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

<body class="bg-white">
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
                    <p class="text-dark fw-medium">BN Scholars</p>
                </div>

                <div class="row gy-3">
                    <div class="col-md-4 col-12">
                        <form action="" method="get">
                            <div class="search-input rounded-3 <?= isset($_GET['search']) ? 'active' : '' ?>">
                                <i class="icon bx bx-search"></i>
                                <input type="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" name="search" placeholder="Search" class="rounded-3 form-control">
                            </div>
                        </form>
                    </div>
                    <div class="col-auto ms-auto">
                        <a href="add_scholar.php" class="btn btn-green-accent rounded-pill px-3 shadow-sm ms-auto d-flex align-items-center" type="button">
                            <i class="bx bx-plus me-3"></i>
                            <span class="">Add</span>
                        </a>
                    </div>
                </div>
                <?php if (isset($_GET['search'])) : ?>
                    <a href="scholars.php" class="btn btn-secondary mt-3">
                        <span>Search: </span>
                        <span><?= $_GET['search'] ?></span>
                        <i class="bx bx-x"></i>
                    </a>
                <?php endif ?>
                <div class="table-responsive-sm mt-4">
                    <table class="table table-hovered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-medium">Name</th>
                                <th class="fw-medium">Email</th>
                                <th class="fw-medium">Phone</th>
                                <th class="fw-medium">Address</th>
                                <th class="fw-medium">Username</th>
                                <th class="fw-medium">Created At</th>
                                <th class="fw-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = $pdo->prepare("SELECT scholar_infos.*,scholar_accounts.username FROM scholar_infos INNER JOIN scholar_accounts ON scholar_infos.scholar_account_id = scholar_accounts.id ORDER BY id DESC");
                            $query->execute();

                            foreach ($rows as $row) {
                                $created_at = date('M d, Y', strtotime($row['created_at']));
                            ?>
                                <tr>
                                    <td><?= $row['firstname'] ?> <?= $row['middlename'] ?> <?= $row['lastname']  ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['phone'] ?></td>
                                    <td><?= $row['address'] ?></td>
                                    <td><?= $row['username'] ?></td>
                                    <td><?= $created_at ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class='fs-3 text-dark-brown bx bx-dots-horizontal-rounded'></i>
                                            </a>

                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="edit_scholar.php?id=<?= $row['scholar_account_id'] ?>">Edit</a></li>
                                                <li><a class="dropdown-item" href="delete_scholar.php?id=<?= $row['scholar_account_id'] ?>">Delete</a></li>
                                                <li><a class="dropdown-item" href="reset_scholar_password.php?username=<?= $row['username'] ?>">Reset Password</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="table-pagination bg-light py-2">
                        <div class="d-flex align-items-center">
                            <div class="ps-3">
                                <p class=" align-self-center text-secondary my-2 ">
                                    Showing <?= $starting_row + 1 ?> to <?= $starting_row + count($rows) ?> of <?= $total_rows ?> entries.
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
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
    <script>
        $("#table").DataTable();
    </script>
</body>

</html>