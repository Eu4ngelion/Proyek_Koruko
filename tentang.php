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

// Mengumpulkan data website
$sql = "SELECT deskripsi_tentang, visi, misi, gambar_tentang, logo_web FROM website";
$result = mysqli_query($conn, $sql);
$website = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: black;
        }

        .main-index {
            height: auto;
            min-height: 100vh;
            background-color: black;
            padding: 80px 10% 200px 10%
        }

        .tentang-big-title {
            font-size: 64px;
            font-weight: bold;
            text-align: center;
            margin-top: 30px;
            letter-spacing: -1px;
            color: white;
        }
        .tentang-big-title img {
            width: 100px;
            height: auto;
            margin-left: -5px;
        }

        .tentang-container-deskripsi {
            display: flex;
            margin-top: 10px;
            padding: 20px;
            border-radius: 10px;
        }

        .tentang-gambar {
            justify-content: center;
            align-items: center;
            width: 250px;
            height: 250px;
            background-color: white;
        }

        .tentang-gambar img {
            width: 250px;
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
        }

        .tentang-deskripsi {
            display: flex;
            width: 100%;
            padding: 20px;
            border-radius: 15px;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }

        .tentang-container-visi-misi {
            display: flex;
            flex-direction: column;
            margin-bottom: 30px;
            padding: 0 20px;
            border-radius: 10px;
        }

        .tentang-visi-misi-title {
            display: flex;
            font-size: 40px;
            font-weight: bold;
            margin-top: 30px;
            letter-spacing: -1px;
            color: white;
            align-items: center;
            gap: 15px;
        }

        .tentang-visi-misi-title img:nth-child(1) {
            width: 30px;
            height: auto;
        }
        .tentang-visi-misi-title img:nth-child(2) {
            width: 22px;
            height: auto;
        }
        .tentang-visi-misi-title img:nth-child(3) {
            width: 16px;
            height: auto;
        }


        .tentang-visi-misi-title img {
            width: 50px;
            height: auto;
            margin-left: -5px;
        }

        .tentang-visi-misi-text {
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
    </style>
</head>


<body class="body-index">
    <header><?php include "navbar.php"; ?></header>

    <main class="main-index">
        <div class="tentang-big-title">
            Tentang Kami
            <img src="images/website/<?php echo $website["logo_web"]; ?>" alt="logo">
        </div>

        <div class="tentang-container-deskripsi">
            <div class="tentang-gambar">
                <img src="images/website/<?= $website["gambar_tentang"]; ?>" alt="gambar-tentang">
            </div>
            <div class="tentang-deskripsi">
                <div class="tentang-deskripsi-text"><?= $website["deskripsi_tentang"]; ?></div>
            </div>
        </div>

        <div class="tentang-container-visi-misi">
            <div class="tentang-visi-misi-title">
                Visi
                <img src="images/assets/purple_star(2).png" alt="star">
                <img src="images/assets/purple_star(2).png" alt="star">
                <img src="images/assets/purple_star(2).png" alt="star">
            </div>
            <div class="tentang-visi-misi-text"><?= $website["visi"]; ?></div>
        </div>

        <div class="tentang-container-visi-misi">
            <div class="tentang-visi-misi-title">
                Misi
                <img src="images/assets/purple_star(2).png" alt="star">
                <img src="images/assets/purple_star(2).png" alt="star">
                <img src="images/assets/purple_star(2).png" alt="star">
            </div>
            <div class="tentang-visi-misi-text"><?= $website["misi"]; ?></div>
        </div>
    </main>

    <footer><?php include "footer.php"; ?></footer>
</body>


</html>