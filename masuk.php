<?php
require "koneksi.php";

// Memulai Sesion
if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = false;
} else if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
    header("Location: index.php");
    exit;
}

// Jika form disubmit
if (isset($_POST["login-submit"])) {
    $inp_username_email = $_POST["username_email"];
    $inp_password = $_POST["password"];

    // Cek Admin
    $sql = "SELECT * FROM admin WHERE nama_admin = '$inp_username_email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        if (password_verify($inp_password, $row["sandi"])) {
            $_SESSION["username"] = $row["nama_admin"];
            $_SESSION["login"] = true;
            header("Location: admin_properti.php");
            exit;
        } else {
            $_SESSION["login"] = false;
            echo "
            <script>
                alert('Password salah');
            </script>";
        }
    } else {
        // Cek User
        $sql = "SELECT * FROM pengguna WHERE nama_pengguna = '$inp_username_email' OR email = '$inp_username_email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            if (password_verify($inp_password, $row["sandi"])) {
                $_SESSION["username"] = $row["nama_pengguna"];
                $_SESSION["login"] = true;
                echo "
                <script>
                    alert('Berhasil masuk');
                    window.location.href = 'index.php';
                </script>";
                exit;
            } else {
                $_SESSION["login"] = false;
                echo "
                <script>
                    alert('Password salah');
                </script>";
            }
        } else {
            $_SESSION["login"] = false;
            echo "
            <script>
                alert('Username atau email tidak ditemukan');
            </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #3A2470;
        }

        .login-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            min-height: 100vh;
            padding-top: 60px;
            background-color: #3A2470;
        }

        .login-box {
            width: 50%;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px;
            background-color: #191919;
            border-radius: 20px;
            box-shadow: 0 0 100px #703BF7;
        }

        .login-title {
            text-align: center;
            padding: 0;
            margin: 0;
            color: white;
            font-size: 64px;
            font-weight: bold;
            letter-spacing: -2px;
        }

        .form-group {
            display: flex;
            align-items: center;
            flex-direction: column;
            margin: 20px 0;
        }

        .redirect-register {
            color: white;
            width: 60%;

            font-family: "Poppins", sans-serif;
            font-size: 12px;
            text-align: right;
        }

        .redirect-register a {
            color: #703BF7;
            font-weight: bold;
            text-decoration: none;
        }

        .redirect-register a:hover {
            text-decoration: underline;
        }

        .form-control {
            width: 60%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            /* placeholder font */
            font-family: 'Poppins', sans-serif;
        }

        .button-ungu {
            width: 100px;
            height: 40px;
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 10px;
            background-color: #703BF7;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .button-ungu:hover {
            background-color: #BBA0FF;
            scale: 1.1;
            transition: 0.3s;
        }

        .copyright {
            text-align: right;
            color: white;
            font-family: "Poppins", sans-serif;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <header>
        <?php include "navbar.php" ?>
    </header>

    <section class="login-content">
        <div class="login-box">
            <div class="login-title">
                Masuk
            </div>
            <form class="form-group" action="masuk.php" method="POST">
                <input type="text" name="username_email" id="username_email" class="form-control" placeholder="Nama Pengguna / Email" minlength="5" maxlength="20" pattern="[A-Za-z0-9@._]+" required>
                <input type="password" name="password" id="password" class="form-control" placeholder="Kata Sandi" minlength="8" pattern="(?=.*[A-Z])[A-Za-z0-9]+" title="Password is 8-20 characters long & contain at least one uppercase letter."
                    required>
                <div class="redirect-register">
                    Belum punya akun? <a href="daftar.php">Daftar</a>
                </div>
                <button name="login-submit" class="button-ungu" type="submit">Masuk</button>
            </form>
        </div>
    </section>

    <div class="copyright" style="text-align: right; color: white; margin-top: 20px;">
        © 2024 Koruko . All rights reserved
    </div>

</body>

</html>