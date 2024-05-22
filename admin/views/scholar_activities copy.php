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
                <div class="mb-4">
                    <p class="text-secondary fs-6 fw-medium">BN Scholar Activities</p>
                    <div class="row gy-3">
                        <div class="col-md-4 col-12">
                            <form action="<?= $_SERVER['PHP_SELF'] . '?' . http_build_query($page_query_param) ?>" method="get">
                                <div class="search-input rounded-3 <?= isset($_GET['search']) ? 'active' : '' ?>">
                                    <i class="icon bx bx-search"></i>
                                    <input type="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" name="search" placeholder="Search" class="rounded-3 form-control">
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php if (isset($_GET['search'])) : ?>
                        <a href="?" class="btn btn-secondary mt-3">
                            <span>Search: </span>
                            <span><?= $_GET['search'] ?></span>
                            <i class="bx bx-x"></i>
                        </a>
                    <?php endif ?>
                </div>

                <!-- tab filter -->
                <ul class="nav flex-row mb-4 tab-list">
                    <?php
                    if (isset($_GET['search'])) {
                        $search_str = $_GET['search'];
                        $search_query = "(DATE(scholar_activities.created_at) LIKE :search || scholar_infos.firstname LIKE :search || scholar_infos.middlename LIKE :search || scholar_infos.lastname LIKE :search || CONCAT(scholar_infos.firstname,' ',scholar_infos.lastname) LIKE :search || scholar_activities.title LIKE :search || scholar_activities.location LIKE :search || scholar_activities.beneficiaries LIKE :search || scholar_activities.type LIKE :search) AND scholar_activities.status = :status";
                        $query = $pdo->prepare("SELECT count(scholar_activities.id) FROM scholar_activities INNER JOIN scholar_infos ON scholar_activities.scholar_id = scholar_infos.id WHERE $search_query");
                        $query->execute([':search' => "%$search_str%", ':status' => "SUBMITTED"]);
                        $submitted = $query->fetch()[0];
                        $query->execute([':search' => "%$search_str%", ':status' => "RECIEVED"]);
                        $recieved = $query->fetch()[0];

                        // get all
                        $search_query = "DATE(scholar_activities.created_at) LIKE :search || scholar_infos.firstname LIKE :search || scholar_infos.middlename LIKE :search || scholar_infos.lastname LIKE :search || CONCAT(scholar_infos.firstname,' ',scholar_infos.lastname) LIKE :search || scholar_activities.title LIKE :search || scholar_activities.location LIKE :search || scholar_activities.beneficiaries LIKE :search || scholar_activities.type LIKE :search";
                        $query = $pdo->prepare("SELECT count(scholar_activities.id) FROM scholar_activities INNER JOIN scholar_infos ON scholar_activities.scholar_id = scholar_infos.id WHERE $search_query");
                        $query->execute([':search' => "%$search_str%"]);
                        $total = $query->fetch()[0];
                    } else {
                        $query = $pdo->prepare("SELECT count(id) FROM scholar_activities WHERE status = ?");
                        $query->execute(["SUBMITTED"]);
                        $submitted = $query->fetch()[0];
                        $query->execute(["RECIEVED"]);
                        $recieved = $query->fetch()[0];

                        // get all
                        $query = $pdo->prepare("SELECT count(id) FROM scholar_activities");
                        $query->execute();
                        $total = $query->fetch()[0];
                    }

                    $tabs = [
                        ['All', $total],
                        ['Submitted', $submitted],
                        ['Recieved', $recieved],
                    ];

                    ?>
                    <?php
                    foreach ($tabs as $index => $tab) :
                        $params = $page_query_param;
                        $params['page'] = 1;
                        if ($index == 0) {
                            unset($params['status']);
                        } else {
                            $params['status'] = strtoupper($tab[0]);
                        }
                    ?>
                        <li class="nav-item <?= strtolower($tab[0]) ?> <?= !isset($_GET['status']) && $index == 0 ? 'active' : (isset($_GET['status']) && $_GET['status'] == strtoupper($tab[0]) ? 'active' : '') ?>">
                            <a href="?<?= http_build_query($params) ?>" class="d-flex px-3 py-2 text-dark align-items-center gap-3 text-decoration-none">
                                <span><?= $tab[0] ?></span>
                                <span class="badge fw-medium"><?= $tab[1] ?></span>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $rows_per_page = 10;
                $starting_row = ($page - 1) * $rows_per_page;

                if (isset($_GET['search'])) {
                    $search_str = $_GET['search'];
                    if (isset($_GET['status'])) {
                        $status = $_GET['status'];
                        $search_query = "(DATE(scholar_activities.created_at) LIKE :search || scholar_infos.firstname LIKE :search || scholar_infos.middlename LIKE :search || scholar_infos.lastname LIKE :search || CONCAT(scholar_infos.firstname,' ',scholar_infos.lastname) LIKE :search || scholar_activities.title LIKE :search || scholar_activities.location LIKE :search || scholar_activities.beneficiaries LIKE :search || scholar_activities.type LIKE :search) AND status = :status";
                        // get total rows
                        $query = $pdo->prepare("SELECT scholar_activities.id FROM scholar_activities INNER JOIN scholar_infos ON scholar_activities.scholar_id = scholar_infos.id WHERE $search_query");
                        $query->execute([':search' => "%$search_str%", ':status' => $status]);
                        $total_rows = $query->rowCount();
                        $total_pages = ceil($total_rows / $rows_per_page);
                        // get data
                        $query = $pdo->prepare("SELECT scholar_activities.*, scholar_infos.firstname,scholar_infos.middlename,scholar_infos.lastname FROM scholar_activities INNER JOIN scholar_infos ON scholar_activities.scholar_id = scholar_infos.id WHERE $search_query LIMIT $rows_per_page OFFSET $starting_row");
                        $query->execute([':search' => "%$search_str%", ':status' => $status]);
                    } else {
                        $search_query = "DATE(scholar_activities.created_at) LIKE :search || scholar_infos.firstname LIKE :search || scholar_infos.middlename LIKE :search || scholar_infos.lastname LIKE :search || CONCAT(scholar_infos.firstname,' ',scholar_infos.lastname) LIKE :search || scholar_activities.title LIKE :search || scholar_activities.location LIKE :search || scholar_activities.beneficiaries LIKE :search || scholar_activities.type LIKE :search";
                        $search_str = $_GET['search'];
                        // get total rows
                        $query = $pdo->prepare("SELECT scholar_activities.id FROM scholar_activities INNER JOIN scholar_infos ON scholar_activities.scholar_id = scholar_infos.id WHERE $search_query");
                        $query->execute([':search' => "%$search_str%"]);
                        $total_rows = $query->rowCount();
                        $total_pages = ceil($total_rows / $rows_per_page);
                        // get data
                        $query = $pdo->prepare("SELECT scholar_activities.*, scholar_infos.firstname,scholar_infos.middlename,scholar_infos.lastname FROM scholar_activities INNER JOIN scholar_infos ON scholar_activities.scholar_id = scholar_infos.id WHERE $search_query LIMIT $rows_per_page OFFSET $starting_row");
                        $query->execute([':search' => "%$search_str%"]);
                    }

                    $rows = $query->fetchAll();
                } else {
                    if (isset($_GET['status'])) {
                        $query = $pdo->prepare("SELECT scholar_activities.id FROM scholar_activities INNER JOIN scholar_infos ON scholar_activities.scholar_id = scholar_infos.id WHERE scholar_activities.status = ?");
                        $query->execute([$_GET['status']]);

                        $total_rows = $query->rowCount();
                        $total_pages = ceil($total_rows / $rows_per_page);
                        $query = $pdo->prepare("SELECT scholar_activities.*, scholar_infos.firstname,scholar_infos.middlename,scholar_infos.lastname FROM scholar_activities INNER JOIN scholar_infos ON scholar_infos.id = scholar_activities.scholar_id WHERE scholar_activities.status = ? LIMIT $rows_per_page OFFSET $starting_row");
                        $query->execute([$_GET['status']]);
                        $rows = $query->fetchAll();
                    } else {
                        $query = $pdo->prepare("SELECT scholar_activities.id FROM scholar_activities INNER JOIN scholar_infos ON scholar_activities.scholar_id = scholar_infos.id");
                        $query->execute();

                        $total_rows = $query->rowCount();
                        $total_pages = ceil($total_rows / $rows_per_page);
                        $query = $pdo->prepare("SELECT scholar_activities.*, scholar_infos.firstname,scholar_infos.middlename,scholar_infos.lastname FROM scholar_activities INNER JOIN scholar_infos ON scholar_infos.id = scholar_activities.scholar_id LIMIT $rows_per_page OFFSET $starting_row");
                        $query->execute();
                        $rows = $query->fetchAll();
                    }
                }
                ?>
                <div class="table-responsive-sm">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-medium text-dark py-2">Project / Task</th>
                                <th class="fw-medium col-2 text-dark py-2">BN Scholar</th>
                                <th class="fw-medium text-dark py-2">Date</th>
                                <th class="fw-medium text-dark py-2">Location</th>
                                <th class="fw-medium text-dark py-2">Status</th>
                                <th class="fw-medium text-dark py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $key => $row) : ?>
                                <tr>
                                    <td class="py-2"><?= $row['title'] ?></td>
                                    <td class="py-2"><?= $row['firstname'] . ' ' . $row['lastname'] ?></td>
                                    <td class="py-2"><?= date('M d, Y', strtotime($row['date'])) ?></td>
                                    <td class="py-2"><?= $row['location'] ?></td>
                                    <td class="py-2">
                                        <!-- <span class="badge bg-<?= $row['status'] == 'SUBMITTED' ? 'dark-brown' : 'green-accent' ?>"><?= $row['status'][0] . strtolower(substr($row['status'], 1)) ?></span> -->
                                        <div class="dropdown table-item">
                                            <a class="btn d-flex align-items-center gap-1 btn-sm btn-<?= $row['status'] == 'SUBMITTED' ? 'dark-brown text-light' : 'green-accent' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span><?= $row['status'][0] . strtolower(substr($row['status'], 1)) ?></span>
                                                <i class="bx bx-chevron-down"></i>
                                            </a>
                                            <ul class="dropdown-menu" style="width:min-content !important;">
                                                <li>
                                                    <a class="dropdown-item" href="../app/update_activity_status.php?id=<?= $row['id'] ?>&status=<?= $row['status'] == 'SUBMITTED' ? 'RECIEVED' : 'SUBMITTED' ?>">
                                                        <small><?= $row['status'] == 'SUBMITTED' ? 'Recieved' : 'Submitted' ?></small>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class='fs-3 text-dark-brown bx bx-dots-horizontal-rounded'></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="view_activity.php?id=<?= $row['id'] ?>">View</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <?php if (count($rows) == 0) : ?>
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
                                <?php
                                ?>
                                <a href="?<?= http_build_query(array_merge($page_query_param, ['page' => $page - 1])) ?>" class="<?= ($page - 1) <= 0 ? 'disabled border-0' : '' ?> d-flex align-items-center btn text-btn-green-accent fw-medium">
                                    <i class="bx bx-skip-previous"></i>
                                    Prev
                                </a>
                                <a href="?<?= http_build_query(array_merge($page_query_param, ['page' => $page + 1])) ?>" class="<?= ($page + 1) > $total_pages ? 'disabled border-0' : '' ?> d-flex align-items-center btn text-btn-green-accent fw-medium">
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