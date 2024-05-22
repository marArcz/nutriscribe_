<?php 
    require_once '../conn/conn.php';
    require_once '../includes/session.php';


    date_default_timezone_set('Asia/Manila');
    $user = Session::getUser($pdo);

    if(!$user){
        Session::insertError('You need to login first!');
        Session::redirectTo('login.php');
        exit;
    }

    function substring($txt,$len=30){
        if(strlen($txt) > $len){
            return substr($txt,0,$len) . '...'; 
        }

        return $txt;
    }

    // update user's last activity
    $query = $pdo->prepare("UPDATE scholar_accounts SET last_activity = NOW() WHERE id = ?");
    $query->execute([$user['id']]);
    
?>
