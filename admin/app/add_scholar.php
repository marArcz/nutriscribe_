<?php 
require_once '../../conn/conn.php';

if(isset($_POST['submit'])){
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = strtoupper($lastname);
    $hashed_password = password_hash($password,PASSWORD_BCRYPT);

    //check if email is already taken
    $query  = $pdo->prepare('SELECT * FROM scholar_infos WHERE email = ?');
    $query->execute([trim($email)]);

    $is_email_taken =  $query->rowCount() > 0;

    // check if username is already taken
    $query = $pdo->prepare('SELECT * FROM scholar_accounts WHERE username = ?');
    $query->execute([$username]);

    $is_username_taken = $query->rowCount() > 0;


    if(!$is_email_taken && !$is_username_taken){
        // create account
        $query = $pdo->prepare("INSERT INTO scholar_accounts(username,password) VALUES(?,?)");
        $query->execute([$username,$hashed_password]);
        $account_id = $pdo->lastInsertId();

        // create scholar info
        $query = $pdo->prepare('INSERT INTO scholar_infos(firstname,middlename,lastname,address,phone,email,scholar_account_id) VALUES(?,?,?,?,?,?,?)');
        $query->execute([$firstname,$middlename,$lastname,$address,$phone,$email,$account_id]);

        Session::insertSuccess("Successfully added a new BN Scholar!");
        Session::redirectTo('scholars.php');
        exit;
    }
}
?>