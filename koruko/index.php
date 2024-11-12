<?php
require "koneksi.php";

// Memulai Sesion
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION["login"])){
    $_SESSION["login"] = false;
}

// Mengambil data admin
$sql = "SELECT nama_admin FROM admin";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koruko</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    include "navbar.php";
    ?>
    <h1>Beranda</h1>
</body>
</html>