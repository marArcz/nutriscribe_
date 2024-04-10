<?php

$sql = file_get_contents('nutriscribe.sql');

$mysqli_no_db = new mysqli('localhost', 'root', '');
try {
    
    $mysqli_no_db->query('CREATE DATABASE nutriscribe;');

    $mysqli = new mysqli("localhost", "root", "", "nutriscribe");
    /* execute multi query */
    $mysqli->multi_query($sql);

    echo 'Successfully imported database';
} catch (\Throwable $th) {
    $mysqli_no_db->query('DROP DATABASE nutriscribe;');
    $mysqli_no_db->query('CREATE DATABASE nutriscribe;');

    $mysqli = new mysqli("localhost", "root", "", "nutriscribe");
    /* execute multi query */
    $mysqli->multi_query($sql);

    echo 'Successfully imported database';
}
