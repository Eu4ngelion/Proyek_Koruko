<?php
require "koneksi.php";

if (session_status() == PHP_SESSION_NONE) session_start();

// Jika sudah login, maka arahkan ke index.php
if (isset($_SESSION["user"])) {
    $_SESSION['login'] = true;
    header("Location: index.php");
    exit;
}

// Jika form disubmit
if (isset($_POST['register-submit'])) {
    // variabel data input
    $inp_nama_lengkap = $_POST['full-name'];
    $inp_nama_pengguna = $_POST['username'];
    $inp_email = $_POST['email'];
    $inp_telepon = $_POST['no_telp'];
    $inp_sandi = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Cek dengan data admin
    $sql = "SELECT nama_admin FROM admin WHERE nama_admin = '$inp_nama_pengguna' limit 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Nama pengguna sudah digunakan')</script>";
    } else {
        // Cek apakah data nama pengguna sudah ada
        $sql = "SELECT nama_pengguna FROM pengguna WHERE  nama_pengguna = '$inp_nama_pengguna' limit 1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Nama pengguna sudah digunakan')</script>";
        }
        // Cek apakah data email sudah ada
        else {
            $sql = "SELECT email FROM pengguna WHERE email = '$inp_email' limit 1";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<script>alert('Nama lengkap sudah digunakan')</script>";
            }
            // Cek apakah data telepon sudah ada
            else {
                $sql = "SELECT telepon FROM pengguna WHERE telepon = '$inp_telepon' limit 1";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    echo "<script>alert('Nomor telepon sudah digunakan')</script>";
                }
                // Data sudah valid
                else {
                    $sql = "INSERT INTO pengguna (nama_pengguna, nama_lengkap, email, telepon, sandi)
            VALUES ('$inp_nama_pengguna', '$inp_nama_lengkap', '$inp_email', '$inp_telepon', '$inp_sandi')";
                    if (mysqli_query($conn, $sql)) {
                        echo "
                        <script>
                        alert('Pendaftaran berhasil!')
                        window.location.href = 'masuk.php';
                        </script>";
                        exit;
                    } else {
                        echo "<script>alert('Pendaftaran gagal!')</script>";
                    }
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
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
            color: #703BF7;
            width: 60%;

            font-family: "Poppins", sans-serif;
            font-size: 12px;
            text-align: right;
        }

        .redirect-register a {
            color: #703BF7;
        }

        .form-control {
            width: 60%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }

        .error-konfirmasi {
            font-family: "Poppins", sans-serif;
            font-size: 12px;
            font-weight: bold;
            color: red;
            display: none;
        }

        .button-ungu {
            width: 100px;
            height: 40px;
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
            background-color: #703BF7;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            cursor: pointer;
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
    <?php include "navbar.php" ?>
    <section class="login-content">
        <div class="login-box">
            <div class="login-title">
                Register
            </div>
            <form class="form-group" action="daftar.php" method="POST">
                <input type="text" name="full-name" id="full-name" class="form-control" placeholder="Nama Lengkap" minlength="1" maxlength="30" pattern="[A-Za-z\s'-]+" required>
                <input type="text" name="username" id="username" class="form-control" placeholder="Nama Pengguna" minlength="5" maxlength="20" pattern="[A-Za-z0-9@._]+" required>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" minlength="1" maxlength="50" required>
                <input type="tel" name="no_telp" id="no_telp" class="form-control" placeholder="No. Telepon" minlength="10" maxlength="15" pattern="[0-9]+" required>

                <input type="password" name="password" id="password" class="form-control" placeholder="Kata Sandi"
                    minlength="8" maxlength="20"
                    pattern="^(?=.*[A-Z])([A-Za-z\d!@#\$%\^&\*\(\)]+)"
                    title="Password harus memiliki minimal 8 karakter dan satu huruf kapital." required>

                <input type="password" name="password2" id="password2" class="form-control" placeholder="Konfirmasi Kata Sandi"
                    minlength="8" maxlength="20"
                    pattern="^(?=.*[A-Z])([A-Za-z\d!@#\$%\^&\*\(\)]+)"
                    title="Password harus memiliki minimal 8 karakter dan satu huruf kapital." 
                    oninput = "checkPasswordMatch()"
                    required>

                <span class="error-konfirmasi" id="password-match-message" style="color: red; display: none;">Konfirmasi Gagal. Pastikan kedua kata sandi sama</span>
                <div class="redirect-register">
                    Sudah punya akun? <a href="masuk.php">Masuk</a>
                </div>
                <button name="register-submit" id="register-submit" class="button-ungu" type="submit">Masuk</button>
            </form>
        </div>
    </section>
    <div class="copyright" style="text-align: right; color: white; margin-top: 20px;">
        © 2024 Koruko . All rights reserved
    </div>


    <script>
        // Konfirmasi Pengulangan Sandi
        function checkPasswordMatch() {
            var password = document.getElementById("password").value;
            var password2 = document.getElementById("password2").value;
            var message = document.getElementById("password-match-message");
            var regist_submit = document.getElementById("register-submit")

            if (password !== password2) {
                message.style.display = "block";
                regist_submit.disabled = true;
            } else {
                message.style.display = "none";
                regist_submit.disabled = false;
            }
        }
    </script>
</body>

</html>