<?php
require_once '../conn/conn.php';

// change profile pic
if (isset($_POST['change-photo'])) {
    $target_dir = '../assets/images';
    $photo = $_FILES['photo']['name'];
    $uploaded = move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir . '/' . $photo);

    if ($uploaded) {
        $query = $pdo->prepare("UPDATE scholar_infos SET photo = ? WHERE id = ?");
        $query->execute([$photo, $user['scholar_info_id']]);

        Session::insertSuccess('Successfully updated profile photo!');
    }
    Session::redirectTo("profile.php");
    exit;
}

if (isset($_POST['edit-info'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];

    $query = $pdo->prepare("UPDATE scholar_infos SET firstname = ?, middlename=?,lastname=? WHERE id = ?");
    $query->execute([$firstname, $middlename, $lastname, $user['scholar_info_id']]);

    $query = $pdo->prepare("UPDATE scholar_accounts SET username = ? WHERE id = ?");
    $query->execute([$username, $user['id']]);

    Session::insertSuccess("Successfully updated profile!");
    Session::redirectTo('profile.php');
    exit;
}


if (isset($_POST['change_pass'])) {
    $current_pass = $_POST['current_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    $user = Session::getUser($pdo);


    $query = $pdo->prepare("SELECT password FROM scholar_accounts WHERE id = ?");
    $query->execute([$user['id']]);
    $account = $query->fetch();

    if (password_verify($current_pass, $account['password'])) {
        if ($new_pass === $confirm_pass) {
            $query = $pdo->prepare("UPDATE scholar_accounts SET password = ? WHERE id = ?");
            $query->execute([$new_pass, $user['id']]);

            Session::insertSuccess("Successfully updated password!");
            Session::redirectTo("profile.php");
            exit;
        } else {
            $password_err['new'] = "The passwords does not match!";
        }
    } else {
        $password_err['current'] = "The password you entered is incorrect!";
    }
}
