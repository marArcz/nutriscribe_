<?php
include '../../conn/conn.php';

$scholars = [];

$query = $pdo->prepare("SELECT scholar_accounts.*, scholar_infos.firstname,scholar_infos.middlename,scholar_infos.lastname,scholar_infos.photo FROM scholar_accounts INNER JOIN scholar_infos ON scholar_accounts.id = scholar_account_id");
$query->execute();


while ($row = $query->fetch()) {
    $last_activity = $row['last_activity'];

    $query = $pdo->query("SELECT NOW()");
    $now = $query->fetch()[0];
    $currentTimestamp = date("Y-m-d H:i:s");

    $datetime1 = new DateTime($last_activity); // start time
    $datetime2 = new DateTime($now); // end time

    $interval = $datetime1->diff($datetime2);

    $is_online = $interval->format('%i') < 2;

    $row['online'] = $is_online;
    $scholars[] = $row;
}

echo json_encode($scholars);
