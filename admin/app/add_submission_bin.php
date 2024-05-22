<?php
include_once '../../conn/conn.php';
include_once '../includes/session.php';

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $instructions = $_POST['instructions'];
    $deadline_date = $_POST['deadline_date'];
    $deadline_time = $_POST['deadline_time'];

    $dateTimeString = $deadline_date . ' ' . $deadline_time;
    $dateTime = new DateTime($dateTimeString);

    $deadline = $dateTime->format('Y-m-d H:i:s');

    $query = $pdo->prepare("INSERT INTO submission_bins(title,instructions, deadline) VALUE(?,?,?)");
    $added = $query->execute([
        $title,
        $instructions,
        $deadline,
    ]);

    if($added){
        Session::insertSuccess('Successfully create a submission bin!');
        Session::redirectTo('scholar_activities.php'); 
    }
}

?>