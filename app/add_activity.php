<?php 
require_once '../conn/conn.php';

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $beneficiaries = $_POST['beneficiaries'];
    $date = $_POST['date'];

    $query = $pdo->prepare("INSERT INTO scholar_activities(title,type,location,beneficiaries,date,scholar_id) VALUES(?,?,?,?,?,?)");
    $query->execute([$title,$type,$location,$beneficiaries,$date,$user['scholar_info_id']]);

    Session::insertSuccess("Successfully added an activity!");
    Session::redirectTo("activities.php");

    exit;
}
?>