<?php require_once '../includes/auth.php' ?>
<?php
require '../app/add_attendance.php';
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
    $current_page = 'attendance';
    require_once '../includes/sidebar.php'
    ?>
    <?php require_once '../includes/navbar.php' ?>
    <main id="main" class="expanded bg-white">
        <?php include '../includes/alerts.php'; ?>
        <?php $header_title = 'attendance'; ?>
        <div class="content">
            <header class="content-header">
                <div class="container-fluid d-flex">
                    <div class="d-flex align-items-center">
                        <!-- <img src="../assets/images/clipboard-list.png" class="img-icon sm" alt=""> -->
                        <i class="bx bxs-notepad bx-md text-light-brown"></i>
                        <span class="text-gray2 ms-2 fw-medium fs-5">Attendance</span>
                    </div>
                </div>
            </header>

            <div class="mt-4">
                <div class="row gy-4 mb-3 mt-3">
                    <div class="col-md-6 my-2">
                        <div class="d-flex">
                            <div class="d-flex flex-wrap gap-2">
                                <?php $profile_pic_size='md'; include '../includes/user-profile-pic.php' ?>
                                <span class="align-self-end mb-3 ms-2 fs-5 fw-medium"><?= $user['firstname'] ?> <?= $user['middlename'] ?> <?= $user['lastname'] ?></span>
                            </div>
                            <div class="ms-auto">
                                <p class="mb-1">Today is</p>
                                <p class="text-dark-brown fw-medium"><?= date('F d, Y') ?></p>
                            </div>
                        </div>
                        <p class="mt-3 fs-5 fw-medium text-gray2">
                            Welcome, you can submit your attendance by selecting an action and submitting the form.
                        </p>
                        <br><br>
                        <div class="mt-3">
                            <p class="fw-medium text-secondary fs-5">
                                <span class="fw-medium text-gray2">Time in (Today):</span>
                                <?php
                                $query = $pdo->prepare("SELECT * FROM attendances WHERE type = 'in' AND scholar_id = ? AND DATE(created_at) = ?");
                                $query->execute([$user['scholar_info_id'], date('Y-m-d')]);

                                $time_in = $query->fetch();
                                ?>
                                <?php if ($time_in) : ?>
                                    <span class="fw-medium text-green-accent ms-2"><?= date('h:i A', strtotime($time_in['time'])) ?> <i class="bx bxs-check-circle"></i></span>
                                <?php else : ?>
                                    <span class="text-gray2 fw-medium">None</span>
                                <?php endif; ?>
                            </p>
                            <p class="fw-medium text-secondary fs-5">
                                <span class="fw-medium text-gray2">Time out (Today):</span>
                                <?php
                                $query = $pdo->prepare("SELECT * FROM attendances WHERE type = 'out' AND scholar_id = ? AND DATE(created_at) = ?");
                                $query->execute([$user['scholar_info_id'], date('Y-m-d')]);

                                $time_out = $query->fetch();
                                ?>
                                <?php if ($time_out) : ?>
                                    <span class="fw-medium text-green-accent ms-2"><?= date('h:i A', strtotime($time_out['time'])) ?> <i class="bx bxs-check-circle"></i></span>
                                <?php else : ?>
                                    <span class="text-gray2 fw-medium">None</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex">
                                    <p class="my-0 fs-5 fw-normal text-secondary">Select an action</p>
                                    <p class="ms-auto fw-semibold text-bg-dark-brown px-4 py-2 text-light rounded-3 ">
                                        <span id="text-time"><?= date('h:i A') ?> </span>
                                    </p>
                                </div>

                                <div class="mt-4 px-4">
                                    <form action="" method="post">
                                        <input type="hidden" name="time" id="input-time">
                                        <div class="form-check d-flex align-items-center gap-4 mb-4">
                                            <input <?= $time_in && $time_out ? 'disabled':'' ?> checked class="form-check-input form-check-input-lg" type="radio" name="type" id="time-in" value="in">
                                            <label class="form-check-label fw-medium fs-5 text-gray2" for="time-in">
                                                Time In
                                            </label>
                                        </div>
                                        <div class="form-check d-flex align-items-center gap-4">
                                            <input <?= $time_in && $time_out ? 'disabled':'' ?> class="form-check-input" type="radio" name="type" id="time-out" value="out">
                                            <label class="form-check-label fw-medium fs-5 text-gray2" for="time-out">
                                                Time Out
                                            </label>
                                        </div>
                                        <br>

                                        <div class="mt-5">
                                            <?php if ($time_in && $time_out) : ?>
                                                <p class="text-secondary fs-5 fw-medium">You already submitted your attendance for today.</p>
                                            <?php endif; ?>
                                            <button name="submit" type="submit" <?= $time_in && $time_out ? 'disabled' : '' ?> class="col-12 rounded-4 btn btn-green-accent btn-lg">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require '../includes/footer.php' ?>
    <?php require_once '../includes/scripts.php' ?>

    <script>
        $(function() {
            // live update of time
            const updateTime = () => {
                let timeTxt = $("#text-time");
                let timeInput = $("#input-time");
                let date = new Date();

                let H = date.getHours();
                let h = H > 12 ? H - 12 : H;
                h = h >= 10 ? h : '0' + h;
                let m = date.getMinutes() >= 10 ? date.getMinutes() : '0' + date.getMinutes();

                timeTxt.html(`${h}:${m} ${H >= 12 ? 'PM' : 'AM'}`)
                timeInput.val(`${H >= 10 ? H : '0' + H}:${m}`)
            }
            setInterval(updateTime, 1000)
        })
    </script>
</body>

</html>