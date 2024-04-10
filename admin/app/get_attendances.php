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

    array_push($scholars, $scholar);
}

// get scholars with no time in yet
// $query = $pdo->prepare("SELECT * FROM scholar_infos WHERE id NOT IN (SELECT scholar_id FROM attendances WHERE DATE(created_at) = DATE(NOW()) AND type = 'in')");
// $query->execute();
// while ($row = $query->fetch()) {
//     $scholar['name'] = $row['firstname'] . ' ' . $row['lastname'];
//     $scholar['scholar_id'] = $row['id'];
//     $scholar['photo'] = $row['photo'];
//     $scholar['time_in'] = null;
//     $scholar['time_out'] = null;
//     array_push($scholars, $scholar);
// }


echo json_encode($scholars);
