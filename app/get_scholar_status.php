<?php 
include '../conn/conn.php';

// scholar account id
$id = $_GET['id'];

$query = $pdo->prepare("SELECT last_activity FROM scholar_accounts WHERE id = ?");
$query->execute([$id]);

$record = $query->fetch();
$last_activity = $record['last_activity'];

$query = $pdo->query("SELECT NOW()");
$now = $query->fetch()[0];
$currentTimestamp = date("Y-m-d H:i:s");

$datetime1 = new DateTime($last_activity); // start time
$datetime2 = new DateTime($now); // end time

$interval = $datetime1->diff($datetime2);

$is_online = $interval->format('%i') < 5;

echo json_encode([
    'is_online' => $is_online
]);

?>