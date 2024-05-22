<?php
include '../conn/conn.php';
include '../includes/session.php';

$scholar = Session::getUser($pdo);
$submission_bin_id = $_POST['submission_bin_id'];

$comments = [];

function timeAgo($datetime)
{
    global $pdo;
    $query = $pdo->query("SELECT NOW()");
    $data = $query->fetch()[0];
    $now = new DateTime($data);
    $sentTime = new DateTime($datetime);
    $interval = $now->diff($sentTime);

    if ($interval->y > 0) {
        return $interval->y . ' y';
    } elseif ($interval->m > 0) {
        return $interval->m . ' month';
    } elseif ($interval->d > 0) {
        return $interval->d . ' d';
    } elseif ($interval->h > 0) {
        return $interval->h . ' h';
    } elseif ($interval->i > 0) {
        return $interval->i . ' m';
    } else {
        return 'just now';
    }
}


$query = $pdo->prepare("SELECT * FROM comments WHERE submission_bin_id = ? AND scholar_id = ?");
$query->execute([$submission_bin_id, $scholar['id']]);

while ($row = $query->fetch()) {
    $comment = $row;
    if (!$comment['is_admin']) {
        $comment['scholar'] = $scholar;
        $comment['interval'] = timeAgo($comment['created_at']);
    } else {
        $q = $pdo->prepare('SELECT * FROM admins WHERE id = ?');
        $q->execute([$comment['admin_id']]);

        $admin = $q->fetch();

        $comment['admin'] = $admin;
        $comment['interval'] = timeAgo($comment['created_at']);
    }

    $comments[] = $comment;
}

echo json_encode($comments);
