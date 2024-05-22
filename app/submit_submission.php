<?php
include_once '../conn/conn.php';

if (isset($_POST['submit'])) {
    $targetDir = '../submissions';
    $user = Session::getUser($pdo);
    $submission_bin_id = $_GET['sb'];
    // check if user have submission record
    $query = $pdo->prepare("SELECT * FROM submissions WHERE scholar_id=? AND submission_bin_id = ?");
    $query->execute([$user['id'], $submission_bin_id]);
    $submission = $query->fetch();

    if ($submission) {
        $submission_id = $submission['id'];
    } else {
        // create submission
        $query = $pdo->prepare("INSERT INTO submissions(scholar_id,submission_bin_id) VALUES(?,?)");
        $query->execute([$user['id'], $submission_bin_id]);
        $submission_id = $pdo->lastInsertId();
    }

    if (!empty($_FILES['attachments']['name'][0])) {
        // remove previous attachments
        $query = $pdo->prepare("DELETE FROM submission_attachments WHERE submission_id = ?");
        $query->execute([$submission_id]);

        foreach ($_FILES['attachments']['name'] as $key => $name) {
            $attachment = $name;

            $uploaded = move_uploaded_file($_FILES['attachments']['tmp_name'][$key], $targetDir . '/' . $attachment);
            if ($uploaded) {
                $query = $pdo->prepare("INSERT INTO submission_attachments(uri,submission_id) VALUES(?,?)");
                $query->execute([$attachment, $submission_id]);
            }
        }
    }



    $query = $pdo->prepare("UPDATE submissions SET submitted = TRUE, submitted_on=NOW() WHERE id = ?");
    $query->execute([$submission_id]);

    Session::insertSuccess("Successfully submitted report!");
    Session::redirectTo('submission_bin.php?sb=' . $submission_bin_id);
    exit;
}
