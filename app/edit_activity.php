<?php 
require_once '../conn/conn.php';

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $beneficiaries = $_POST['beneficiaries'];
    $date = $_POST['date'];
    $id = $_GET['id'];

    $query = $pdo->prepare("UPDATE scholar_activities SET title=?,type=?,location=?,beneficiaries=?,date=? WHERE id = ?");
    $query->execute([$title,$type,$location,$beneficiaries,$date,$id]);

    Session::insertSuccess("Successfully updated activity!");

    Session::redirectTo('activities.php');
    exit;
}

?>