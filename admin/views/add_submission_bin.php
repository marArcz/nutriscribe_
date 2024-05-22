<?php require_once '../includes/authenticated.php' ?>
<?php
    include '../app/add_submission_bin.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Submission Bin | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php
    $current_page = 'scholar_activities';
    require_once '../includes/sidebar.php'
    ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'Add Submission Bin'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid-sm">
                <div class="d-flex mb-4">
                    <h6 class="text-dark fw-medium fs-5">Add Submission Bin</h6>
                </div>

                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <p>
                            <i class="bx bxs-inbox"></i>
                            <span class="ms-1">Submission Bin</span>
                        </p>

                        <div class="mt-4">
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="" class="form-label fw-normal text-secondary">Title: <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="" class="form-control" required name="title" value="<?= isset($_POST['title'])?$_POST['title']:'' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label fw-normal text-secondary">Instructions (optional):</label>
                                    <textarea name="instructions" class="form-control" rows="3"><?= isset($_POST['instruction'])?$_POST['instruction']:'' ?></textarea>
                                </div>
                                <hr>
                                <p class="fw-medium mb-2">Date of submission</p>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md">
                                            <label for="" class="form-label text-secondary">Date:</label>
                                            <input type="date" name="deadline_date" class="form-control px-3">
                                        </div>
                                        <div class="col-md">
                                            <label for="" class="form-label text-secondary">Time:</label>
                                            <input type="time" name="deadline_time" class="form-control px-3">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md">
                                        <a href="scholar_activities.php" class="btn btn-light-dark fw-medium col-12">Cancel</a>
                                    </div>
                                    <div class="col-md">
                                        <button name="add" type="submit" class="btn btn-green-accent col-12">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
</body>

</html>