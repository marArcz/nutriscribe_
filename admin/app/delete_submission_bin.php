<?php 
include '../../conn/conn.php';
include '../includes/session.php';
$sb = $_GET['sb'];

$query = $pdo->prepare("DELETE FROM submission_bins WHERE id = ?");
$query->execute([$sb]);

Session::insertSuccess("Successfully deleted submission bin!");
Session::redirectTo('../views/scholar_activities.php');
?>