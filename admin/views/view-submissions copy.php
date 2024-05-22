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
                            <div class="">
                                <i class="bx bx-box bx-sm"></i>
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

                        <div class=" mt-3">
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
                    </div>
                </div>
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body p-lg-4">
                        <div class="row">
                            <div class="col-md">
                                <p>Submissions</p>
                                <div class="row mt-2">
                                    <?php
                                    $query = $pdo->prepare("SELECT submissions.* FROM submissions WHERE submission_bin_id = ?");
                                    $query->execute([$submission_bin['id']]);

                                    while ($row = $query->fetch()) {
                                        $q = $pdo->prepare("SELECT * FROM scholar_infos WHERE scholar_account_id = ?");
                                        $q->execute([$row['scholar_id']]);
                                        $scholar = $q->fetch();

                                        $get_attachments = $pdo->prepare("SELECT * FROM submission_attachments WHERE submission_id = ?");
                                        $get_attachments->execute([$row['id']]);
                                        $attachments = $get_attachments->fetchAll();
                                    ?>
                                        <?php if (count($attachments) > 0) : ?>
                                            <div class="col-md-3">
                                                <a href="submission.php?s=<?= $row['id'] ?>&sb=<?= $_GET['sb'] ?>" class="text-decoration-none">
                                                    <div class="card border-0 bg-ash rounded-0 submission-card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <?php if ($scholar['photo']) : ?>
                                                                    <div class="image-div sm" data-image="../../assets/images/<?= $scholar['photo'] ?>"></div>
                                                                <?php else : ?>
                                                                    <div class="text-profile-pic photo sm bg-secondary border-light border-2 border text-light shadow-sm">
                                                                        <div class="text fw-normal">
                                                                            <?= $scholar['firstname'][0] .  $scholar['lastname'][0] ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endif ?>
                                                                <p class="my-0 ms-2">
                                                                    <?= $scholar['firstname'] ?> <?= $scholar['lastname'] ?>
                                                                </p>
                                                            </div>
                                                            <div class="row justify-content-center">
                                                                <?php foreach ($attachments as $attachment) : ?>
                                                                    <div class="col-md-<?= count($attachments) > 1? '6':'8'?>">
                                                                        <a href="">

                                                                            <div class="text-center mt-3 border rounded-3 p-3 bg-light">
                                                                                <div class="file-icon">
                                                                                    <img src="../../assets/images/file-icons/pdf.png" alt="">
                                                                                </div>
                                                                                <p class="mt-2 px-2 text-sm"><?= $attachments[0]['uri'] ?></p>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>

                                                            <div class="mt-2">
                                                                <?php if (count($attachments) > 1) : ?>
                                                                    <p><?= count($attachments) ?> attachments.</p>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif ?>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <p class="text-secondary">BN Scholars</p>
                                <?php
                                $query = $pdo->prepare("SELECT * FROM scholar_infos");
                                $query->execute();
                                $scholars = $query->fetchAll();
                                ?>

                                <div class=" mt-2">
                                    <?php foreach ($scholars as $scholar) : ?>
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <?php if ($scholar['photo']) : ?>
                                                        <div class="image-div sm" data-image="../../assets/images/<?= $scholar['photo'] ?>"></div>
                                                    <?php else : ?>
                                                        <div class="text-profile-pic photo sm bg-secondary border-light border-2 border text-light shadow-sm">
                                                            <div class="text fw-normal">
                                                                <?= $scholar['firstname'][0] .  $scholar['lastname'][0] ?>
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                                <p class="my-0 ms-2"><?= $scholar['firstname'] ?> <?= $scholar['lastname'] ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
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