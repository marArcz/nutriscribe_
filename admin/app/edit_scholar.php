<?php 
require_once '../../conn/conn.php';

if(isset($_POST['submit'])){
    $id = $_GET['id'];
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
    $query  = $pdo->prepare('SELECT * FROM scholar_infos WHERE email = ? AND scholar_account_id != ?');
    $query->execute([trim($email),$id]);

    $is_email_taken =  $query->rowCount() > 0;

    // check if username is already taken
    $query = $pdo->prepare('SELECT * FROM scholar_accounts WHERE username = ? AND id != ?');
    $query->execute([$username,$id]);

    $is_username_taken = $query->rowCount() > 0;


    if(!$is_email_taken && !$is_username_taken){
        // update account
        $query = $pdo->prepare("UPDATE scholar_accounts SET username = ? WHERE id = ?");
        $query->execute([$username,$id]);

        // update scholar info
        $query = $pdo->prepare('UPDATE scholar_infos SET firstname = ?,middlename=?,lastname=?,address=?,phone=?,email=? WHERE scholar_account_id = ?');
        $query->execute([$firstname,$middlename,$lastname,$address,$phone,$email,$id]);

        Session::insertSuccess("Successfully update scholar!");
        Session::redirectTo('scholars.php');
        exit;
    }
}
?>