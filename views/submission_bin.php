<?php require_once '../includes/auth.php' ?>
<?php
if (!isset($_GET['sb'])) {
    Session::redirectTo('activities.php');
    exit;
}

$query = $pdo->prepare("SELECT * FROM submission_bins WHERE id = ?");
$query->execute([$_GET['sb']]);
$submission_bin = $query->fetch();

if (!$submission_bin) {
    Session::redirectTo('activities.php');
    exit;
}
include '../app/submit_submission.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BN Scholar</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php
    $current_page = 'activities';
    require_once '../includes/sidebar.php'
    ?>
    <?php require_once '../includes/navbar.php' ?>
    <main id="main" class="expanded bg-white">
        <?php $header_title = 'Activities'; ?>
        <div class="content">
            <header class="content-header">
                <div class="container-fluid d-flex align-items-center flex-wrap justify-content-between">
                    <div class="d-flex align-items-center me-auto">
                        <!-- <img src="../assets/images/clipboard-list.png" class="img-icon sm" alt=""> -->
                        <i class="bx bxs-note bx-md text-light-brown"></i>
                        <span class="text-gray2 ms-2 fw-medium fs-5">Activities</span>
                    </div>

                </div>
            </header>

            <div class="mt-4">
                <a class=" text-decoration-none link-secondary" href="activities.php">
                    <i class="bx bx-arrow-back"></i>
                    <span class="ms-2">Submission bins</span>
                </a>
                <!-- card -->
                <div class="card border shadow-sm mt-3">
                    <div class="card-body p-lg-4">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="circle-icon bg-green-accent">
                                <i class="bx bx-notepad"></i>
                            </div>
                            <p class="my-0 fs-5"><?= $submission_bin['title'] ?></p>
                        </div>
                        <?php if ($submission_bin['deadline']) : ?>
                            <p class="mb-0 text-danger mt-2">
                                Due on <?= date('M d, Y', strtotime($submission_bin['deadline'])) ?>, <?= date('h:i A', strtotime($submission_bin['deadline'])) ?>
                            </p>
                        <?php else : ?>
                            <p class="mb-0 text-secondary mt-2">
                                No due date.
                            </p>
                        <?php endif ?>
                        <hr>
                        <p class="text-secondary fw-light">
                            <?= $submission_bin['instructions'] != null && $submission_bin['instructions'] != '' ? $submission_bin['instructions'] : 'No instructions.' ?>
                        </p>
                    </div>
                </div>
                <!--  -->
                <div class="row mt-1 gy-2">
                    <div class="col-lg-8 order-1 order-lg-0">
                        <div class="card border shadow-sm">
                            <div class="card-body">
                                <p>Private Comments</p>
                                <div class="">
                                    <div class="comments-area px-3" id="comments-area">
                                        ...
                                    </div>
                                    <div class="mt-2">
                                        <form id="comment-form">
                                            <div class="d-flex">
                                                <textarea name="" id="comment-box" class="form-control flex-fill" placeholder="Enter your comment here..."></textarea>
                                                <button id="send-btn" class="btn text-btn-success" type="submit">
                                                    <i class="bx bxs-paper-plane"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 ms-auto order-0 order-lg-1">
                        <div class="card border shadow-sm">
                            <div class="card-body">
                                <form action="" enctype="multipart/form-data" method="post">
                                    <p class="text-green">Your work</p>
                                    <?php
                                    // get submitted report
                                    $query = $pdo->prepare("SELECT * FROM submissions WHERE submission_bin_id = ? AND scholar_id = ?");
                                    $query->execute([$submission_bin['id'], $user['id']]);
                                    $submission = $query->fetch(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="attachments-row" id="attachments-row">
                                        <?php if (!$submission) : ?>
                                            <p class="text-empty">No submission yet.</p>
                                        <?php else : ?>
                                            <?php
                                            // get attachments
                                            $query = $pdo->prepare("SELECT * FROM submission_attachments WHERE submission_id = ?");
                                            $query->execute([$submission['id']]);
                                            $attachments = $query->fetchAll();
                                            ?>
                                            <?php if ($submission['submitted']) : ?>
                                                <p class="text-green-accent">Submitted <i class="bx bxs-check-circle"></i></p>
                                            <?php endif ?>
                                            <?php foreach ($attachments as $key => $attachment) : ?>
                                                <a href="../submissions/<?= $attachment['uri'] ?>" class="link-secondary" target="_blank">
                                                    <div class="submission-attachment">
                                                        <div class="d-flex align-items-center">
                                                            <div class="file-icon">
                                                                <img src="../assets/images/file-icons/pdf.png" alt="">
                                                            </div>
                                                            <p class="my-0 ms-2"><?= $attachment['uri'] ?></p>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php endforeach ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mt-2">
                                        <input type="file" class="d-none" name='attachments[]' multiple id="file-input" accept="application/pdf">

                                        <div class="mt-1">
                                            <?php
                                            $query = $pdo->prepare("SELECT * FROM submissions WHERE scholar_id=? AND submission_bin_id = ?");
                                            $query->execute([$user['id'], $submission_bin['id']]);
                                            $submission = $query->fetch();
                                            ?>

                                            <?php if ($submission && $submission['submitted']) : ?>
                                                <a href="../app/unsubmit_submission.php?id=<?= $submission['id'] ?>&sb=<?= $submission_bin['id'] ?>" class="col-12 btn btn-secondary">
                                                    <span>Unsubmit</span>
                                                </a>
                                            <?php elseif ($submission && !$submission['submitted']) : ?>
                                                <button type="button" id="add-work-btn" class="col-12 btn bordered-btn-dark">
                                                    <span>Change Attachments</span>
                                                </button>
                                                <button name="submit" id="submit-btn" type="submit" class="col-12 mt-2 btn btn-green-accent">
                                                    <span>Submit Report</span>
                                                </button>
                                            <?php else : ?>
                                                <button type="button" id="add-work-btn" class="col-12 btn bordered-btn-dark">
                                                    <span>Add Attachments</span>
                                                </button>
                                                <button name="submit" disabled id="submit-btn" type="submit" class="col-12 mt-2 btn btn-green-accent">
                                                    <span>Submit Report</span>
                                                </button>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </main>
    <?php require '../includes/footer.php' ?>
    <?php require_once '../includes/scripts.php' ?>

    <script>
        const attachmentRow = (file) => {
            return `
                        <div class="submission-attachment">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center flex-fill">
                                    <div class="file-icon">
                                        <img src="../assets/images/file-icons/pdf.png" alt="">
                                    </div>
                                    <p class="my-0 text-truncate ms-2">${file.name}</p>
                                </div>
                            </div>
                        </div>
            `
        }

        var fileInputIndex = 0;

        $("#add-work-btn").on('click', function(e) {
            $("#file-input").trigger('click')
        })

        $("#file-input").change(function(e) {
            console.log(e.target.files)
            let container = $("#attachments-row")
            container.html('')

            if (e.target.files.length > 0) {
                $("#submit-btn").attr('disabled', false)
                $("#add-work-btn").html('Change Attachments')
            } else {
                $("#add-work-btn").html('Add File')
                $("#submit-btn").attr('disabled', true)
            }
            for (let file of e.target.files) {
                let item = attachmentRow(file);
                container.append(item)
            }
        })

        const commentRow = (comment) => {
            if (comment.is_admin) {
                return `
                        <div class="d-flex mt-3 comment-row">
                                        <div>
                                            ${comment.admin?.image?(
                                                `<div class="image-div sm" data-image="../assets/images/${comment.admin?.image}"></div>`
                                            ):(
                                                `
                                                <div class="text-profile-pic photo sm bg-secondary border-light border-2 border text-light shadow-sm">
                                                    <div class="text fw-normal">
                                                        ${comment.admin.firstname[0]}${comment.admin.lastname[0]}
                                                    </div>
                                                </div>
                                                `
                                            )}
                                        </div>
                                        <div class="ms-2">
                                            <p class="my-0">
                                                ${comment.admin.firstname} ${comment.admin.lastname} <span class="text-secondary text-sm ms-1">${comment.interval}</span>
                                            </p>
                                            <p class="text-secondary text-sm mb-0">Admin</p>

                                            <p class="mt-2 comment-message">
                                                ${comment.message}
                                            </p>
                                        </div>
                                    </div>
            `;
            } else {
                return `
                         <div class="d-flex mt-3 comment-row">
                                        <div>
                                            ${comment.scholar.photo?(
                                                `<div class="image-div" data-image="../assets/images/${comment.scholar.photo}"></div>`
                                            ):(
                                                `
                                                <div class="text-profile-pic photo sm bg-secondary border-light border-2 border text-light shadow-sm">
                                                    <div class="text fw-normal">
                                                        ${comment.scholar.firstname[0]}${comment.scholar.lastname[0]}
                                                    </div>
                                                </div>
                                                `
                                            )}
                                        </div>
                                        <div class="ms-2">
                                            <p class="my-0">
                                                ${comment.scholar.firstname} ${comment.scholar.lastname} <span class="text-secondary text-sm ms-1">${comment.interval}</span>
                                            </p>
                                            <p class="text-secondary text-sm mb-0">Scholar</p>

                                            <p class="mt-2 comment-message">
                                                ${comment.message}
                                            </p>
                                        </div>
                                    </div>
            `;
            }
        }
        var commentsData = '';
        var oldCommentAreaHeight = $("#comments-area").prop('scrollHeight');
        var commentsCount = 0;
        const getComments = () => {
            $.ajax({
                method: 'post',
                url: '../app/get-comments.php',
                data: {
                    submission_bin_id: "<?= $submission_bin['id'] ?>",
                },
                dataType: 'json',
                success: function(comments) {
                    if (JSON.stringify(commentsData) != JSON.stringify(comments)) {
                        console.log(comments)
                        $("#comments-area").html('');
                        if (comments.length > 0) {
                            for (let comment of comments) {
                                let row = commentRow(comment)
                                $("#comments-area").append(row);
                            }
                        } else {
                            $("#comments-area").html(`<p class='fw-light text-secondary'>No comments to show.</p>`);
                        }
                        if (comments.length != commentsCount) {
                            $("#comments-area").animate({
                                scrollTop: $("#comments-area").prop("scrollHeight")
                            }, 500);
                        }
                        commentsCount = comments.length
                        commentsData = comments

                        loadImageDivs();
                    }
                },
                error: (err => console.error(err))
            })
        }
        $(function() {
            getComments();

            setInterval(getComments, 1000)

            $("#comment-form").submit(function(e) {
                e.preventDefault();
                let message = $("#comment-box").val();
                $("#send-btn").attr('disabled', true)
                $("#send-btn").html(`<span class="spinner-border spinner-border-sm text-success"></span>`)

                $.ajax({
                    method: 'post',
                    url: '../app/post-comment.php',
                    data: {
                        submission_bin_id: "<?= $submission_bin['id'] ?>",
                        message
                    },
                    dataType: 'json',
                    success: function(res) {
                        console.log(res)
                        $("#send-btn").attr('disabled', false)
                        $("#send-btn").html('<i class="bx bxs-paper-plane"></i>')
                        $("#comment-box").val('')
                    },
                    error: (err => console.error(err))
                })
            })
        })
    </script>
</body>

</html>