<?php
include_once '../conn/conn.php';
include_once '../includes/session.php';

$id = $_GET['id'];
$bin_id = $_GET['sb'];
$query = $pdo->prepare("UPDATE submissions SET submitted = FALSE AND submitted_on=NULL WHERE id = ?");
$query->execute([$id]);

Session::redirectTo('../views/submission_bin.php?sb=' . $bin_id);
exit;
