<?php
require_once '../../conn/conn.php';

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    $query = $pdo->prepare('UPDATE admins SET firstname=?,lastname=?,email=? WHERE id = ?');
    $query->execute([$firstname, $lastname, $email, $id]);

    Session::insertSuccess("Successfully updated account!");
    Session::redirectTo('profile.php');
    exit;
}

if (isset($_POST['change_pass'])) {
    $admin = Session::getUser($pdo);

    $current_pass = $_POST['current_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if (password_verify($current_pass, $admin['password'])) {
        if ($new_pass == $confirm_pass) {
            $query = $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?");
            $query->execute([password_hash($confirm_pass, PASSWORD_DEFAULT), $admin['id']]);

            Session::insertSuccess("Successfully changed password!");
            Session::redirectTo("profile.php");
            exit;
        } else {
            $error['confirm_pass'] = 'Passwords does not match';
        }
    } else {
        $error['current_pass'] = 'The password you entered is incorrect!';
    }
}

 // change profile pic
 if (isset($_POST['change_photo'])) {
    $target_dir = '../../assets/images';
    $photo = $_FILES['photo']['name'];
    $uploaded = move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir . '/' . $photo);

    if ($uploaded) {
        $query = $pdo->prepare("UPDATE admins SET image = ? WHERE id = ?");
        $query->execute([$photo, $admin['id']]);

        Session::insertSuccess('Successfully updated profile photo!');
    }
    Session::redirectTo("profile.php");
    exit;
}
