<?php
require_once '../../conn/conn.php';

if (isset($_POST['reset'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password == $confirm_password) {
        $query = $pdo->prepare("UPDATE scholar_accounts SET password = ?  WHERE username = ?");
        $query->execute([password_hash($password, PASSWORD_BCRYPT), $_GET['username']]);

        Session::insertSuccess("Successfully reset account's password");
        Session::redirectTo("scholars.php");
        exit;
    }else{
        $error = "Passwords does not match!";
    }
}
