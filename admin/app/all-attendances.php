<?php
require_once '../../conn/conn.php';
require_once '../includes/session.php';


// $query = $pdo->prepare("SELECT attendances.*,scholar_infos.firstname,scholar_infos.middlename,scholar_infos.lastname FROM attendances INNER JOIN scholar_infos ON attendances.scholar_id = scholar_infos.id");
$year = $_POST['year'];
$query = $pdo->prepare("SELECT COUNT(id) FROM attendances WHERE MONTH(created_at) = ? AND YEAR(created_at) = ?");
$attendances = [];


for ($x = 1; $x <= 12; $x++) {
    $query->execute([$x,$year]);
    $attendances[] = $query->fetch()[0];
}


echo json_encode($attendances);
