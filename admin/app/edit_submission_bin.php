<?php
include_once '../../conn/conn.php';
include_once '../includes/session.php';

if (isset($_POST['edit'])) {
    $title = $_POST['title'];
    $instructions = $_POST['instructions'];
    $deadline_date = $_POST['deadline_date'];
    $deadline_time = $_POST['deadline_time'];

    $dateTimeString = $deadline_date . ' ' . $deadline_time;
    $dateTime = new DateTime($dateTimeString);

    $deadline = $dateTime->format('Y-m-d H:i:s');

    $query = $pdo->prepare("UPDATE submission_bins SET title=?,instructions=?,deadline=? WHERE id = ?");
    $updated = $query->execute([
        $title,
        $instructions,
        $deadline,
        $submission_bin_id
    ]);

    if($updated){
        Session::insertSuccess('Successfully updated submission bin!');
        Session::redirectTo('scholar_activities.php'); 
        exit;
    }
}

?>