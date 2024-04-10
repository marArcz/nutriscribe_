<?php require_once '../includes/authenticated.php' ?>
<?php

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
    $current_page = 'attendance';
    require_once '../includes/sidebar.php'
    ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'Attendance'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid-sm">
                <div class="mb-2">
                    <p class="text-secondary fs-6 fw-medium">BN Scholar Attendance</p>

                    <form action="" method="get">
                        <div class="text-end">
                            <button type="button" data-bs-toggle="collapse" data-bs-target="#filter-group" class="btn btn-secondary">
                                <i class="bx bx-filter "></i>
                                <span class="fw-medium">Filter</span>
                            </button>
                        </div>
                        <div class=" mb-4 collapse  border-0 mt-2 <?= isset($_GET['filter'])? 'show':'' ?>" id="filter-group">
                            <div class="">
                                <div class="row g-3">
                                    <div class="col-md">
                                        <label for="" class="form-label text-gray2 fw-normal">Starting Date:</label>
                                        <input type="date" value="<?= isset($_GET['start_date']) ? $_GET['start_date']:'' ?>" name="start_date" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label for="" class="form-label text-gray2 fw-normal">End Date:</label>
                                        <input type="date" value="<?= isset($_GET['end_date']) ? $_GET['end_date']:'' ?>" name="end_date" class="form-control">
                                    </div>
                                    <div class="col-md-auto align-self-end">
                                        <button class="btn btn-green-accent" name="filter" type="submit">Go</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $rows_per_page = 10;
                $starting_row = ($page - 1) * $rows_per_page;

                if (isset($_GET['filter'])) {
                    $start_date = $_GET['start_date'];
                    $end_date = $_GET['end_date'];

                    $query = $pdo->prepare("SELECT id FROM attendances WHERE DATE(created_at) >= ? AND DATE(created_at) <= ?");
                    $query->execute([$start_date, $end_date]);
                    $total_rows = $query->rowCount();
                    $total_pages = ceil($total_rows / $rows_per_page);
                    $query = $pdo->prepare("SELECT attendances.*, scholar_infos.firstname,scholar_infos.middlename,scholar_infos.lastname FROM attendances INNER JOIN scholar_infos ON attendances.scholar_id = scholar_infos.id WHERE DATE(attendances.created_at) >= ? AND DATE(attendances.created_at) <= ? ORDER BY attendances.created_at DESC, type ASC LIMIT $rows_per_page OFFSET $starting_row");
                    $query->execute([$start_date, $end_date]);

                    $rows = $query->fetchAll();
                } else {
                    $query = $pdo->prepare("SELECT id FROM attendances");
                    $query->execute();
                    $total_rows = $query->rowCount();
                    $total_pages = ceil($total_rows / $rows_per_page);
                    $query = $pdo->prepare("SELECT attendances.*, scholar_infos.firstname,scholar_infos.middlename,scholar_infos.lastname FROM attendances INNER JOIN scholar_infos ON attendances.scholar_id = scholar_infos.id ORDER BY attendances.created_at DESC, attendances.type ASC LIMIT $rows_per_page OFFSET $starting_row");
                    $query->execute();
                    $rows = $query->fetchAll();
                }
                ?>
                <div class="table-responsive-sm">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-medium text-dark py-3">BN Scholar</th>
                                <th class="fw-medium text-dark py-3">Type</th>
                                <th class="fw-medium text-dark py-3">Time</th>
                                <th class="fw-medium text-dark py-3">Date</th>
                                <th class="fw-medium text-dark py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $row) : ?>
                                <tr>
                                    <td class="py-2"><?= $row['firstname'] . ' ' . $row['lastname'] ?></td>
                                    <td class="py-2"><?= strtoupper($row['type']) ?></td>
                                    <td class="py-2"><?= date('h:i A', strtotime($row['time'])) ?></td>
                                    <td class="py-2"><?= date('M d, Y', strtotime($row['time'])) ?></td>
                                    <td></td>
                                </tr>
                            <?php endforeach ?>
                            <?php if(count($rows) == 0): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Nothing to show.</td>
                                </tr>
                            <?php endif ?>
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
</body>

</html>