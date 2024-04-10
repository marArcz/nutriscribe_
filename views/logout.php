<?php
require_once '../conn/conn.php';
require_once '../includes/session.php';

if (Session::getUser($pdo)) {
    require '../app/logout.php';
}

Session::redirectTo('login.php');
