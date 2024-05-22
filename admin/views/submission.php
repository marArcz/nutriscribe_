<?php require_once '../includes/authenticated.php' ?>
<?php
if (!isset($_GET['sb']) && !isset($_GET['s'])) {
    Session::redirectTo('scholar_activities.php');
    exit;
}

$submission_bin_id = $_GET['sb'];
$submission_id = $_GET['s'];

// get submission
$query = $pdo->prepare("SELECT * FROM submissions WHERE id = ?");
$query->execute([$submission_id]);
$submission = $query->fetch();
// get attachments
$query = $pdo->prepare("SELECT * FROM submission_attachments WHERE submission_id = ?");
$query->execute([$submission_id]);
$attachments = $query->fetchAll();
// get submission bin
$query = $pdo->prepare("SELECT * FROM submission_bins WHERE id = ?");
$query->execute([$submission_bin_id]);
$submission_bin = $query->fetch();

// get scholar
$query = $pdo->prepare("SELECT * FROM scholar_infos WHERE scholar_account_id = ?");
$query->execute([$submission['scholar_id']]);
$scholar = $query->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submissions | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php
    $current_page = 'scholar_activities';
    require_once '../includes/sidebar.php'
    ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'Dashboard'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid-sm">
                <div class="mb-4">
                    <h5 class="text-dark fs-4 fw-medium">Scholar Activities / <?= $submission_bin['title'] ?></h5>
                </div>
                <a href="view-submissions.php?sb=<?= $submission_bin['id'] ?>" class="link-secondary text-decoration-none">
                    <i class="bx bx-arrow-back"></i>
                    <span class="ms-1">Submissions</span>
                </a>
                <div class="row mt-3 gy-2">
                    <div class="col-lg">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-lg-4">
                                <div class="row gy-3">
                                    <div class="col-md">
                                        <p class="my-0 fs-6">Submitted By</p>
                                        <div class="d-flex align-items-center mt-3">
                                            <?php if ($scholar['photo']) : ?>
                                                <div class="image-div md" data-image="../../assets/images/<?= $scholar['photo'] ?>"></div>
                                            <?php else : ?>
                                                <div class="text-profile-pic photo md bg-secondary border-light border-2 border text-light shadow-sm">
                                                    <div class="text fw-normal">
                                                        <?= $scholar['firstname'][0] .  $scholar['lastname'][0] ?>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                            <div class="ms-3">
                                                <p class="my-0 fs-5">
                                                    <?= $scholar['firstname'] ?> <?= $scholar['lastname'] ?>
                                                </p>
                                                <p class="text-secondary mb-0">Scholar</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ms-auto col-md text-end">
                                        <?php if ($submission['submitted']) : ?>
                                            <?php
                                            if ($submission_bin['deadline']) {
                                                $dateSubmitted = new DateTime($submission['submitted_on']);
                                                $dueDate = new DateTime($submission_bin['deadline']);
                                                $late = $dateSubmitted > $dueDate;
                                            ?>
                                                <p class="my-0 <?= !$late ? 'text-green' : 'text-secondary' ?>">
                                                    <?php if ($late) : ?>
                                                        <span>Submitted late</span>
                                                    <?php else : ?>
                                                        <span>Submitted on time</span>
                                                        <i class="ms-1 bx bxs-check-circle"></i>
                                                    <?php endif ?>
                                                </p>
                                                <p><?= date('M d, Y, h:i A', strtotime($submission['submitted_on'])) ?></p>
                                            <?php
                                            } else {
                                            ?>
                                                <p class="my-0">Submitted on</p>
                                                <p><?= date('M d, Y, h:i A', strtotime($submission['submitted_on'])) ?></p>
                                            <?php
                                            }
                                            ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3 border shadow-sm">
                            <div class="card-body">
                                <p>Attachments</p>
                                <hr>
                                <div class="row">
                                    <?php
                                    foreach ($attachments as $key => $attachment) {
                                    ?>
                                        <div class="col-md-2">
                                            <a href="../../submissions/<?= $attachment['uri'] ?>" target="_blank">
                                                <div class="text-center">
                                                    <div class="">
                                                        <img width="40px" src="../../assets/images/file-icons/pdf.png" class="img-fluid" alt="">
                                                    </div>
                                                    <p class="mt-2 text-sm px-2"><?= $attachment['uri'] ?></p>
                                                </div>
                                            </a>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p>Private Comments</p>
                                <hr>
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
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>


    <script>
        const commentRow = (comment) => {
            if (comment.is_admin) {
                return `
                        <div class="d-flex mt-3 comment-row">
                                        <div>
                                            ${comment.admin?.image?(
                                                `<div class="image-div sm" data-image="../../assets/images/${comment.admin?.image}"></div>`
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
                                                `<div class="image-div sm" data-image="../assets/images/${comment.scholar.photo}"></div>`
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
                    scholar_id: "<?= $submission['scholar_id'] ?>",
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
                        scholar_id: "<?= $submission['scholar_id'] ?>",
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