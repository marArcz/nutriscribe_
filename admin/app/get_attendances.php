<?php
require_once '../../conn/conn.php';

// get time in
$query = $pdo->prepare("SELECT scholar_infos.*,attendances.time FROM scholar_infos INNER JOIN attendances ON scholar_infos.id = attendances.scholar_id WHERE DATE(attendances.created_at) = DATE(NOW()) AND type = 'in' ORDER BY attendances.id ASC");
$query->execute();
$time_ins = $query->fetchAll();


// get time out
$query = $pdo->prepare("SELECT * FROM scholar_infos INNER JOIN attendances ON scholar_infos.id = attendances.scholar_id WHERE DATE(attendances.created_at) = DATE(NOW()) AND type = 'out' ORDER BY attendances.id ASC");
$query->execute();
$time_outs = $query->fetchAll();



$scholars = [];

foreach ($time_ins as $key => $time_in) {
    $scholar['scholar_id'] = $time_in['id'];
    $scholar['name'] = $time_in['firstname'] . ' ' . $time_in['lastname'];
    $scholar['photo'] = $time_in['photo'];
    $scholar['time_in'] = date('h:i A', strtotime($time_in['time']));

    $query = $pdo->prepare("SELECT time FROM attendances WHERE scholar_id = ? AND type = 'out' AND DATE(created_at) = DATE(NOW())");
    $query->execute([$time_in['id']]);
    $time_out = $query->fetch();

    $scholar['time_out'] = $time_out ? date('h:i A', strtotime($time_out['time'])) : null;

    // get scholar status
    $query = $pdo->prepare("SELECT last_activity FROM scholar_accounts WHERE id = ?");
    $query->execute([$time_in['scholar_account_id']]);

    $record = $query->fetch();
    $last_activity = $record['last_activity'];

    $query = $pdo->query("SELECT NOW()");
    $now = $query->fetch()[0];
    $currentTimestamp = date("Y-m-d H:i:s");

    $datetime1 = new DateTime($last_activity); // start time
    $datetime2 = new DateTime($now); // end time

    $interval = $datetime1->diff($datetime2);

    $scholar['online'] = $interval->format('%i') < 2;


    array_push($scholars, $scholar);
}


echo json_encode($scholars);
