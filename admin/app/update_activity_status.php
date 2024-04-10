<?php 
require_once '../../conn/conn.php';
require_once '../includes/authenticated.php';

if(!isset($_GET['id'])){
    Session::redirectTo("../views/scholar_activities.php");
    exit;
}

$id = $_GET['id'];
$status = $_GET['status'];
$query = $pdo->prepare("UPDATE scholar_activities SET status = ? WHERE id = ?");
$query->execute([$status,$id]);

Session::insertSuccess('Successfully updated status!');
Session::redirectTo("../views/scholar_activities.php");
?>