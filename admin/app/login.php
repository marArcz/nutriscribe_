<?php 
    require_once '../../conn/conn.php';
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $query->execute([$email]);
        $admin = $query->fetch(PDO::FETCH_ASSOC);
        if($admin){
            if(password_verify($password, $admin["password"])){
                Session::saveUserSession($admin['id']);
                if($admin['email_verified_at'] == null){
                    Session::redirectTo('verify.php');
                }else{
                    // Session::insertSuccess("Welcome " . $admin['firstname'] . '!');
                    Session::redirectTo('dashboard.php');
                }
                exit;
            }else{
                $error['password'] = 'You entered an incorrect password!';
            }
        }else{
            $error['email'] = 'Sorry no matching account found!';
        }
    }
?>