<?php
require "koneksi.php";

// Memulai Sesion
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["login"])) {
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
    <style>
        body{
            margin: 0;
            padding: 0;
        }
        .main-index {
            height: auto;
            min-height: 100vh;
            padding-top: 80px;
            background-color: red;
        }

    </style>
</head>


<body class="body-index">
    <header><?php include "navbar.php";?></header>

    <main class="main-index">
        <h1>Beranda</h1>
    </main>

    <footer><?php include "footer.php"; ?></footer>
</body>


</html>