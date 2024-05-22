<?php
include '../conn/conn.php';
include '../includes/session.php';


$user = Session::getUser($pdo);
$time = $_POST['lastActiveTime'];
$datetimeString = date("Y-m-d H:i:s", $time);

if ($user) {
    $query = $pdo->prepare('UPDATE scholar_accounts SET last_activity = ? WHERE id = ?');
    $success = $query->execute([$datetimeString,$user['id']]);

    echo json_encode(['success' => $success,'lastActivetime'=>$datetimeString]);
    exit;
}

echo json_encode(['success' => false,'message'=>'not signed in']);