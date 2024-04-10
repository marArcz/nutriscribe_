<?php
require_once '../includes/authenticated.php';
require '../app/add_scholar.php';

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
                    <p class="text-secondary mb-1 fw-medium">BN Scholars</p>
                    <p class="text-light-brown fs-6 fw-medium">Add New Scholar</p>
                </div>

                <div class="col-md col-12 mx-auto mb-5">
                    <div class="card shadow border-0">
                        <div class="card-body p-4">
                            <form action="" method="post">
                                <div class="row mb-3">
                                    <div class="col-md">
                                        <label for="" class="form-label text-secondary fw-medium">Firstname</label>
                                        <input type="text" value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>" class="form-control" name="firstname" required>
                                    </div>
                                    <div class="col-md">
                                        <label for="" class="form-label text-secondary fw-medium">Middlename</label>
                                        <input type="text" value="<?= isset($_POST['middlename']) ? $_POST['middlename'] : '' ?>" class="form-control" name="middlename" required>
                                    </div>
                                    <div class="col-md">
                                        <label for="" class="form-label text-secondary fw-medium">Lastname</label>
                                        <input type="text" id="lastname-input" value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>" class="form-control" name="lastname" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md">
                                        <label for="" class="form-label text-secondary fw-medium">Email</label>
                                        <input type="email" class="form-control" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" name="email" required>
                                        <?php if (isset($_POST['submit']) && $is_email_taken) : ?>
                                            <p class="form-text text-danger">Sorry this email is already taken.</p>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-md">
                                        <label for="" class="form-label text-secondary fw-medium">Address</label>
                                        <input type="text" class="form-control" name="address" value="<?= isset($_POST['address']) ? $_POST['address'] : '' ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary fw-medium">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="<?= isset($_POST['phone']) ? $_POST['phone'] : '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary fw-medium">Username</label>
                                    <input type="text" class="form-control" name="username" value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>" required>
                                    <?php if (isset($_POST['submit']) && $is_username_taken) : ?>
                                        <p class="form-text text-danger">Sorry this username is already taken.</p>
                                    <?php endif ?>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label text-secondary fw-medium">Password</label>
                                    <p class="form-text mt-0 mb-1 text-dark fw-medium"><i class=" bx bx-info-circle fs-6"></i> Default password will be the user's lastname in uppercase.</p>
                                    <input id="password-input" readonly type="text" class="form-control" name="password" value="<?= isset($_POST['password']) ? strtoupper($_POST['password']) : '' ?>" required>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <a href="scholars.php" class="btn btn-light-dark fw-medium col-12">Cancel</a>
                                    </div>
                                    <div class="col-md">
                                        <button class="btn btn-green-accent fw-medium col-12" type="submit" name="submit">Save</button>
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