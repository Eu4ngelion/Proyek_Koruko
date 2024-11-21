<?php
    $server = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'koruko';

    $conn = mysqli_connect($server, $user, $password, $db);
    if(!$conn) {
        die("Gagal terhubung ke database: " . mysqli_connect_error());
    }