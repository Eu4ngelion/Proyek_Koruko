<?php
require "koneksi.php";

// Memulai Sesion
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Nama halaman saat ini
$current_page = basename($_SERVER['PHP_SELF'], ".php");

if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = false;
}

// Jika belum login dan ada di halaman tertentu
if ($_SESSION["login"] == false) {
    if ($current_page == 'profil' || $current_page == 'kelola' || $current_page== 'tambah_ruko' || $current_page == 'admin_properti' || $current_page == 'admin_akun' || $current_page == 'admin_tentang' || $current_page == 'admin_pengaturan' || $current_page == 'admin_verif') {
        echo "
        <script>
        alert('Anda harus login terlebih dahulu!')
        window.location.href = 'masuk.php'
        </script>";
    }
}
// jika sudah login dan memilih masuk atau daftar
if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
    if ($current_page == 'masuk' || $current_page == 'daftar') {
        echo "
        <script>
        alert('Anda sudah login!')
        window.location.href = 'index.php'
        </script>";
    }
}


// Default User Kosong
$profil_user = null;
if (!isset($_SESSION["username"])) {
    $user = "";
} else {
    $user = $_SESSION["username"];
}



// Mengambil data admin, dan profil admin
$sql = "SELECT nama_admin, gambar_admin FROM admin";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama_admin = $row['nama_admin'];
    $profil_admin = $row['gambar_admin'];
}

// Jika yang sedang login adalah admin
if (isset($_SESSION['username'])) {
    if (
        $_SESSION['username'] == $nama_admin
        && $current_page != 'admin_properti' && $current_page != 'admin_akun' && $current_page != 'admin_tentang'
        && $current_page != 'admin_pengaturan' && $current_page != 'admin_verif'
    ) {
        header('Location: admin_properti.php');
    }
}


// Mengambil logo dan judul web
$sql = "SELECT judul, logo_web FROM website";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $judul_web = $row["judul"];
    $logo_web = $row["logo_web"];
    $logo_web_path = "images/website/" . $logo_web;
}

// Mengambil nama & profil user
if (isset($_SESSION["username"])) {
    if ($_SESSION["username"] != $nama_admin) {
        $sql = "SELECT nama_pengguna, gambar_user FROM pengguna WHERE nama_pengguna = '$user'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $profil_user = $row['gambar_user'];
        }
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <style>
        .navbar {
            background-color: black;
            padding: 5px 0;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 80px #703BF7;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 10%;
            padding: 0;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-logo-link {
            display: flex;
            text-decoration: none;
            color: white;
            font-family: "Poppins";
            font-size: 24px;
            font-weight: bold;
            justify-content: center;
        }

        .logo-text {
            text-shadow:
                -1px -1px 0 #703BF7,
                1px -1px 0 #703BF7,
                -1px 1px 0 #703BF7,
                1px 1px 0 #703BF7;
        }

        .navbar-logo-img {
            width: auto;
            height: 30px;
        }

        .navbar-middle {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar-item {
            font-family: "Poppins";
            font-size: 16px;
            font-weight: bold;
            list-style: none;
            margin: 0 10px;
            background-color: transparent;
            border: none;
            border-radius: 15px;
            transition: all 0.3s;
        }

        .navbar-item:hover {
            background-color: #BBA0FF;
            border: 1px solid white;
            border-radius: 15px;
            padding: 2px 10px;
            text-shadow:
                0 4px 4px black;
            transition: all 0.3s;
        }

        .navbar-item-current {
            list-style: none;
            font-family: "Poppins";
            font-size: 16px;
            font-weight: bold;
            background-color: #703BF7;
            border: 1px solid white;
            border-radius: 15px;
            padding: 2px 15px;
            transition: all 0.3s;
            margin: 0 10px;
        }

        .navbar-item-current:hover {
            background-color: #BBA0FF;
            border: 1px solid white;
            border-radius: 15px;
            padding: 2px 15px;
            text-shadow: 0 4px 4px black;
            transition: all 0.3s;
            margin: 0 10px;
        }

        .navbar-link {
            text-decoration: none;
            color: white;
        }

        .navbar-right {
            display: flex;
            align-items: center;
        }

        .navbar-right .navbar-item {
            display: flex;
            font-family: "Poppins";
            font-size: 16px;
            font-weight: bold;
            list-style: none;
            margin: 0 10px;
            background-color: transparent;
            border: 1px solid white;
            padding: 2px 15px;
            border-radius: 15px;
            transition: all 0.3s;
            justify-content: center;
            align-items: center;
        }

        .navbar-right .navbar-item:hover {
            background-color: #BBA0FF;
            border: 1px solid white;
            border-radius: 15px;
            padding: 2px 15px;
            text-shadow: 0 4px 4px black;
            transition: all 0.3s;
        }

        .profil-admin {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-left: 10px;
            background-color: white;
        }

        .profil-user {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-left: 10px;
            background-color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <!-- Navbar kiri -->
            <div class="navbar-logo">
                <a href="index.php" class="navbar-logo-link">
                    <img src="<?php echo $logo_web_path; ?>" alt="logo" class="navbar-logo-img">
                    <div class="logo-text"> <?php echo $judul_web; ?> </div>
                </a>
            </div>
            <ul class="navbar-middle">
                <!-- Signed Out User -->
                <?php if ($user != $nama_admin): ?>
                    <li class="<?php echo ($current_page == 'index') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <a href="index.php" class="navbar-link">Beranda</a>
                    </li>
                    <li class="<?php echo ($current_page == 'tentang') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <a href="tentang.php" class="navbar-link">Tentang</a>
                    </li>
                    <li class="<?php echo ($current_page == 'pencarian' || $current_page == 'detail') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <a href="pencarian.php" class="navbar-link">Cari</a>
                    </li>

                    <!-- Signed In User-->
                <?php endif; ?>
                <?php if (($_SESSION["login"] == true) && $user != $nama_admin): ?>
                    <li class="<?php echo ($current_page == 'kelola') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <a href="kelola.php" class="navbar-link">Kelola</a>

                    <?php endif; ?>
                    <!-- Signed In Admin-->
                    <?php if (($_SESSION["login"] == true) && $user == $nama_admin): ?>
                    <li class="<?php echo ($current_page == 'admin_properti' || $current_page == 'admin_verif') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <a href="admin_properti.php" class="navbar-link">Properti</a>
                    </li>
                    <li class="<?php echo ($current_page == 'admin_akun') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <a href="admin_akun.php" class="navbar-link">Pengguna</a>
                    </li>
                    <li class="<?php echo ($current_page == 'admin_tentang') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <a href="admin_tentang.php" class="navbar-link">Tentang</a>
                    </li>
                    <li class="<?php echo ($current_page == 'admin_pengaturan') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <a href="admin_pengaturan.php" class="navbar-link">Pengaturan</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-right">
                <!-- Signed Out -->
                <?php if (($_SESSION["login"] == false) || $_SESSION["username"] == ""): ?>
                    <li class="<?php echo ($current_page == 'masuk') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <a href="masuk.php" class="navbar-link">Masuk</a>
                    </li>
                    <li class="<?php echo ($current_page == 'daftar') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <a href="daftar.php" class="navbar-link">Daftar</a>
                    </li>
                <?php else: ?>
                    <!-- Signed In -->
                    <li class="<?php echo ($current_page == 'profil') ? 'navbar-item-current' : 'navbar-item'; ?>">
                        <?php if ($user == $nama_admin): ?>
                            <a href="admin_pengaturan.php" class="navbar-link"><?php echo $nama_admin ?></a>
                            <img class="profil-admin" src="images/admin/<?php echo $profil_admin; ?>" alt="admin">
                        <?php else: ?>
                            <a href="profil.php" class="navbar-link"><?php echo $user ?></a>
                            <img class="profil-user"
                                src="images/user/<?php echo ($profil_user != null) ? $profil_user : "default_user.png"; ?>"
                                alt="profil">
                        <?php endif; ?>

                    </li>
                    <li class="navbar-item">
                        <a href="keluar.php" class="navbar-link">Keluar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

</body>

</html>