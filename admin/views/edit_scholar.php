<?php
require_once '../includes/authenticated.php';
require '../app/edit_scholar.php';

if (!isset($_GET['id'])) {
    Session::redirectTo("scholars.php");
    exit;
}

$id = $_GET['id'];

$query = $pdo->prepare('SELECT scholar_infos.*,scholar_accounts.username FROM scholar_infos INNER JOIN scholar_accounts ON scholar_infos.scholar_account_id = scholar_accounts.id WHERE scholar_infos.scholar_account_id = ?');
$query->execute([$id]);

$user = $query->fetch();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BN Scholars | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php
    $current_page = 'scholars';
    require_once '../includes/sidebar.php'
    ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'Dashboard'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid-sm">
                <div class=" mb-4">
                    <h6 class="text-dark">BN Scholars</h6>
                </div>

                <div class="col-md-6 col-12 mx-auto mb-5">
                    <p class="text-green fs-6 fw-bold">Edit Scholar</p>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label text-secondary fw-medium">Firstname</label>
                            <input type="text" value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : $user['firstname'] ?>" class="form-control" name="firstname" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label text-secondary fw-medium">Middlename</label>
                            <input type="text" value="<?= isset($_POST['middlename']) ? $_POST['middlename'] : $user['middlename'] ?>" class="form-control" name="middlename">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label text-secondary fw-medium">Lastname</label>
                            <input type="text" id="lastname-input" value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : $user['lastname'] ?>" class="form-control" name="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label text-secondary fw-medium">Email</label>
                            <input type="email" class="form-control" value="<?= isset($_POST['email']) ? $_POST['email'] : $user['email'] ?>" name="email" required>
                            <?php if (isset($_POST['submit']) && $is_email_taken) : ?>
                                <p class="form-text text-danger">Sorry this email is already taken.</p>
                            <?php endif ?>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label text-secondary fw-medium">Address</label>
                            <input type="text" class="form-control" name="address" value="<?= isset($_POST['address']) ? $_POST['address'] : $user['address'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label text-secondary fw-medium">Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?= isset($_POST['phone']) ? $_POST['phone'] : $user['phone'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label text-secondary fw-medium">Username</label>
                            <input type="text" class="form-control" name="username" value="<?= isset($_POST['username']) ? $_POST['username'] : $user['username'] ?>" required>
                            <?php if (isset($_POST['submit']) && $is_username_taken) : ?>
                                <p class="form-text text-danger">Sorry this username is already taken.</p>
                            <?php endif ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="scholars.php" class="btn btn-dark">Cancel</a>
                            <button class="btn btn-green-accent" type="submit" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
    <script>
        $(function() {
            const setPasswordvalue = () => {
                $("#password-input").val($("#lastname-input").val().toUpperCase());
            }

            $("#lastname-input").on('input', (e) => {
                setPasswordvalue();
            })
            $("#lastname-input").on("blur", (e) => {
                setPasswordvalue();
            })
        })
    </script>
</body>

</html>