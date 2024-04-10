<?php
require_once '../../conn/conn.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $query = $pdo->prepare("DELETE FROM scholar_accounts WHERE id = ?");
    $deleted = $query->execute([$id]);

    if($deleted){
        Session::insertSuccess("Successfully deleted scholar!");
    }else{
        Session::insertError();
    }

    Session::redirectTo("scholars.php");
    exit;
}
