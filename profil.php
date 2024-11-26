<?php
require "koneksi.php";

// Ambil data pengguna dari database
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$username = $_SESSION['username']; // Ambil username dari session
$sql = "SELECT * FROM pengguna WHERE nama_pengguna='$username'";
$result = mysqli_query($conn, $sql);
$user_data = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $nama_pengguna = $_POST['nama_pengguna'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $sandi = $_POST['sandi'];


    
    // Cek Duplikat
    $sql = "SELECT * FROM pengguna WHERE nama_pengguna != '$username' AND( nama_pengguna='$nama_pengguna' OR telepon='$telepon' OR email='$email')";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['nama_pengguna'] == $nama_pengguna) {
            echo "<script>alert('Nama pengguna sudah digunakan');</script>";
        } else if ($row['telepon'] == $telepon) {
            echo "<script>alert('Nomor telepon sudah digunakan');</script>";
        } else if ($row['email'] == $email) {
            echo "<script>alert('Email sudah digunakan');</script>";
        }
    } else {
        // Jika Sandi Baru Diisi
        if (!empty($sandi)) {
            // Jika Sandi Tidak Sesuai Ketentuan
            if (!preg_match("/(?=.*[A-Z]).{8,}/", $sandi)) {
                echo "<script>alert('Kata sandi harus memiliki minimal 8 karakter dan satu huruf kapital.');</script>";
                exit;
            }
            $hashed_sandi = password_hash($sandi, PASSWORD_DEFAULT);
            $sql = "UPDATE pengguna SET 
                    nama_lengkap='$nama_lengkap', 
                    nama_pengguna='$nama_pengguna', 
                    telepon='$telepon', 
                    email='$email', 
                    sandi='$hashed_sandi' 
                    WHERE nama_pengguna='$username'";
        } else {
            // Jika Sandi Tidak Diisi
            $sql = "UPDATE pengguna SET 
                    nama_lengkap='$nama_lengkap', 
                    nama_pengguna='$nama_pengguna', 
                    telepon='$telepon', 
                    email='$email'
                    WHERE nama_pengguna='$username'";
        }

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Profil berhasil diperbarui');</script>";
            $_SESSION['username'] = $nama_pengguna;
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
    header("Refresh:0");
}

if (isset($_POST['upload'])) {
    // Proses upload foto
    if (isset($_FILES['uploadFoto']) && $_FILES['uploadFoto']['error'] == 0) {
        $target_dir = "images/user/";
        $target_file = $target_dir . basename($_FILES["uploadFoto"]["name"]);
        $new_file_name = $target_dir . $username . "_" . time() . "." . pathinfo($target_file, PATHINFO_EXTENSION);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar adalah gambar yang valid
        $check = getimagesize($_FILES["uploadFoto"]["tmp_name"]);
        if ($check !== false) {
            // Pindahkan file ke direktori tujuan
            if (move_uploaded_file($_FILES["uploadFoto"]
            ["tmp_name"], $new_file_name)) {
                // Hapus file lama jika sebelumnya sudah ada gambar
                if ($user_data['gambar_user']) {
                    unlink($target_dir . $user_data['gambar_user']);
                }
                // Update query untuk mengganti gambar_user
                $sql = "UPDATE pengguna SET gambar_user='" . basename($new_file_name) . "' WHERE nama_pengguna='$username'";
                if (mysqli_query($conn, $sql)) {
                    // Update session gambar_user
                    $_SESSION['gambar_user'] = $target_file;
                    echo "<script>alert('Foto profil berhasil diperbarui');</script>";
                } else {
                    echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                echo "<script>alert('Maaf, terjadi kesalahan saat mengupload file Anda.');</script>";
            }
        } else {
            echo "<script>alert('File yang diupload bukan gambar.');</script>";
        }
    }
    header("Refresh:0");
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
        .profil-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 400px;
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
        #fotoProfil {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }

        #fotoProfil {
            cursor: pointer;
            background-color: white;
        }
    </style>
</head>

<body class="body-index">
    <header><?php include "navbar.php"; ?></header>

    <main class="main-index">
        <h1>Profil Akun</h1>
        <form class="profil-form" method="POST" action="profil.php" enctype="multipart/form-data">
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
                    <input type="password" name="sandi" placeholder="Enter new password"
                        pattern="(?=.*[A-Z]).{8,}"
                        title="Password harus memiliki minimal 8 karakter dan satu huruf kapital.">
                    <button class="button-ganti" style="margin-left: 10px;" type="submit" name="update">Ganti</button>
                </div>
            </div>
            <div class="profile-item">
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <label>Foto Profil:</label>
                    <input type="file" id="uploadFoto" name="uploadFoto" style="display: none;" accept="image/*">
                    <img src="<?php echo $user_data['gambar_user'] ? "images/user/" . $user_data['gambar_user'] : 'images/user/default.png'; ?>" alt="Foto Profil" id="fotoProfil" onclick="document.getElementById('uploadFoto').click();">
                    <button class="button-ganti" style="margin-top: 10px;" type="submit" name="upload">Simpan Foto Profil</button>
                </div>
            </div>
        </form>
    </main>

    <footer><?php include "footer.php"; ?></footer>

    <script>
        // Preview Update Gambar Profil
        document.getElementById('uploadFoto').addEventListener('change', function(e) {
            var img = document.getElementById('fotoProfil');
            img.src = URL.createObjectURL(e.target.files[0]);
        });
    </script>
</body>

</html>