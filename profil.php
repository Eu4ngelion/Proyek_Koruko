<?php
require "koneksi.php";

// Ambil data pengguna dari database
session_start();
$username = $_SESSION['username']; // Ambil username dari session
$sql = "SELECT * FROM pengguna WHERE nama_pengguna='$username'";
$result = mysqli_query($conn, $sql);
$user_data = mysqli_fetch_assoc($result);

// Proses pembaruan data
if (isset($_POST['update'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $nama_pengguna = $_POST['nama_pengguna'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $sandi = $_POST['sandi']; 
    $hashed_sandi = password_hash($sandi, PASSWORD_DEFAULT);

    // Update query
    $sql = "UPDATE pengguna SET nama_lengkap='$nama_lengkap', nama_pengguna='$nama_pengguna', telepon='$telepon', email='$email', sandi='$hashed_sandi' WHERE nama_pengguna='$username'"; // Ganti 'User 123' dengan username yang sesuai

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Profil berhasil diperbarui');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000;
            color: white;
            font-family: 'Poppins', sans-serif;
            text-align: center;
        }
        .main-index {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            height: auto;
            min-height: 100vh;
            padding-top: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-item {
            margin: 15px 0;
            width: 100%;
            max-width: 400px;
            text-align: left;
        }
        .profile-item label {
            display: block;
            margin-bottom: 5px;
            font-size: 18px;
        }
        .button-ganti {
            background-color: #703BF7;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
        }
        input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #703BF7;
            background-color: #191919;
            color: white;
            text-align: left;
        }
        img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body class="body-index">
    <header><?php include "navbar.php"; ?></header>

    <main class="main-index">
        <h1>Profil Akun</h1>
        <form method="POST" action="profil.php">
            <div class="profile-item">
                <label>Nama Lengkap:</label>
                <div style="display: flex; align-items: center;">
                    <input type="text" name="nama_lengkap" value="<?php echo $user_data['nama_lengkap']; ?>" required>
                    <button class="button-ganti" style="margin-left: 10px;" type="submit" name="update">Ganti</button>
                </div>
            </div>
            <div class="profile-item">
                <label>Nama Pengguna:</label>
                <div style="display: flex; align-items: center;">
                    <input type="text" name="nama_pengguna" value="<?php echo $user_data['nama_pengguna']; ?>" required>
                    <button class="button-ganti" style="margin-left: 10px;" type="submit" name="update">Ganti</button>
                </div>
            </div>
            <div class="profile-item">
                <label>No Telepon:</label>
                <div style="display: flex; align-items: center;">
                    <input type="text" name="telepon" value="<?php echo $user_data['telepon']; ?>" required>
                    <button class="button-ganti" style="margin-left: 10px;" type="submit" name="update">Ganti</button>
                </div>
            </div>
            <div class="profile-item">
                <label>Email:</label>
                <div style="display: flex; align-items: center;">
                    <input type="email" name="email" value="<?php echo $user_data['email']; ?>" required>
                    <button class="button-ganti" style="margin-left: 10px;" type="submit" name="update">Ganti</button>
                </div>
            </div>
            <div class="profile-item">
                <label>Kata Sandi:</label>
                <div style="display: flex; align-items: center;">
                    <input type="password" name="sandi" value="" required
                        title="Password harus memiliki minimal 8 karakter dan satu huruf kapital.">
                    <button class="button-ganti" style="margin-left: 10px;" type="submit" name="update">Ganti</button>
                </div>
            </div>
            <div class="profile-item">
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <label>Foto Profil:</label>
                    <img src="images/user/profil_user_1.png" alt="Foto Profil">
                    <button class="button-ganti" style="margin-top: 10px;">Ganti</button>
                </div>
            </div>
        </form>
    </main>

    <footer><?php include "footer.php"; ?></footer>
</body>
</html>