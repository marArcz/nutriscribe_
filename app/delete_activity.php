<?php
require_once '../conn/conn.php';
if (isset($_POST['submit'])) {
    $id = $_GET['id'];

    $query = $pdo->prepare("DELETE FROM scholar_activities WHERE id = ?");
    $deleted = $query->execute([$id]);

    if($deleted){
        Session::insertSuccess("Successfully deleted activity");
    }else{
        Session::insertError();
    }
    Session::redirectTo('activities.php');
    exit;
}
