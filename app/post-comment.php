<?php
include '../conn/conn.php';
include '../includes/session.php';

$scholar = Session::getUser($pdo);
$submission_bin_id = $_POST['submission_bin_id'];
$message = $_POST['message'];

$query = $pdo->prepare("INSERT INTO comments(scholar_id,submission_bin_id,message,is_admin) VALUES(?,?,?,FALSE)");
$added = $query->execute([$scholar['id'], $submission_bin_id, $message]);

echo json_encode([
    'success' => $added
]);
