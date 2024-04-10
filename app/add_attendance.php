<?php 
require_once '../conn/conn.php';

if(isset($_POST['submit'])){
    $type = $_POST['type'];
    $scholar_id = $user['scholar_info_id'];

    $query = $pdo->prepare('INSERT INTO attendances(type,scholar_id) VALUES(?,?)');
    $added = $query->execute([$type,$scholar_id]);
   
    if($added){
        Session::insertSuccess("Successfully submitted your attendance!");
    }else{
        Session::insertError();
    }

    Session::redirectTo('attendance.php');
    exit;
}
?>