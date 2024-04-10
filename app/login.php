<?php 
require_once '../conn/conn.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $pdo->prepare('SELECT * FROM scholar_accounts WHERE username = ? AND disabled = 0');
    $query->execute([$username]);

    $account = $query->fetch();

    if($account){
        if(password_verify($password,$account['password'])){
            Session::saveUserSession($account['id']);
            Session::redirectTo("home.php");
            exit;
        }else{
            $error = "Sorry you entered an incorrect password!";
        }
    }else{
        $error = "Invalid username and password!";
    }
}

?>