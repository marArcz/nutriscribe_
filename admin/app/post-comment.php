<?php
include '../../conn/conn.php';
include '../includes/session.php';

$admin = Session::getUser($pdo);

$scholar_id = $_POST['scholar_id'];
$submission_bin_id = $_POST['submission_bin_id'];
$message = $_POST['message'];

$query = $pdo->prepare("INSERT INTO comments(scholar_id,submission_bin_id,message,admin_id,is_admin) VALUES(?,?,?,?,TRUE)");
$added = $query->execute([$scholar_id, $submission_bin_id, $message,$admin['id']]);

echo json_encode([
    'success' => $added
]);
