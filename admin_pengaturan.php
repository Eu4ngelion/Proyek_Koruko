<?php
require "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // tabel admin
    $nama_admin = $_POST['nama_admin'];
    $sandi_admin = $_POST['sandi'];
    $gambar_admin = $_FILES['gambar_admin'];

    // tabel website
    $judul = $_POST['judul'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    // $deskripsi_tentang = $_POST['deskripsi_tentang'];
    // $visi
    // $misi
    $instagram = $_POST['instagram'];
    $facebook = $_POST['facebook'];
    $youtube = $_POST['youtube'];
    $twitter = $_POST['twitter'];
    $deskripsi_footer = $_POST['deskripsi_footer'];
    $logo_web = $_FILES['logo_web'];

    $admin_upload_dir = 'images/admin/';
    $website_upload_dir = 'images/website/';

    move_uploaded_file($gambar_admin['tmp_name'], $admin_upload_dir . basename($gambar_admin['name']));
    move_uploaded_file($logo_web['tmp_name'], $website_upload_dir . basename($logo_web['name']));

    $query_admin = "UPDATE admin SET nama_admin='$nama_admin', sandi='$sandi_admin', gambar_admin='{$gambar_admin['name']}' WHERE id=1";
    mysqli_query($conn, $query_admin);

    $query_website = "UPDATE website SET judul='$judul', deskripsi_footer='$deskripsi_footer', instagram='$instagram', twitter='$twitter', facebook='$facebook', youtube='$youtube', logo_web='{$logo_web['name']}' WHERE id=1";
    mysqli_query($conn, $query_website);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pengaturan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <link rel="stylesheet" href="styles/admin.css">
</head>

<body>
    <header>
        <?php include "navbar.php"; ?>
    </header>

    <main>
        <div class="container-hero">
            <h1>Pengaturan</h1>
        </div>

        <div class="container-pengaturan">
            <div class="header-pengaturan">
                <div class="test-warna">
                    <h2>Website</h2>
                </div>
                <div class="test-warna">
                    <h2>Footer</h2>
                </div>
            </div>
        </div>

        <div>
            <form action="" method="POST" enctype="multipart/form-data">


                <div>
                    <label for="nama_admin">Nama Admin</label>
                    <input type="text" id="nama_admin" name="nama_admin" required><br>

                    <label for="sandi">Sandi Admin</label>
                    <input type="password" id="sandi" name="sandi" required><br>

                    <label for="judul">Judul Website</label>
                    <input type="text" id="judul" name="judul" required><br>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required><br>

                    <label for="telepon">No Telepon</label>
                    <input type="text" id="telepon" name="telepon" required><br>

                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" required><br>
                </div>

                <div>
                    <label for="deskripsi_footer">Deskripsi Footer</label>
                    <textarea id="deskripsi_footer" name="deskripsi_footer" required></textarea><br>
                    
                    <label for="instagram">Link Instagram</label>
                    <input type="url" id="instagram" name="instagram" required><br>
                    
                    <label for="twitter">Link Twitter</label>
                    <input type="url" id="twitter" name="twitter" required><br>
                    
                    <label for="facebook">Link Facebook</label>
                    <input type="url" id="facebook" name="facebook" required><br>
                    
                    <label for="youtube">Link YouTube</label>
                    <input type="url" id="youtube" name="youtube" required><br>
                </div>
                
                <label for="gambar_admin">Gambar Admin</label>
                <input type="file" id="gambar_admin" name="gambar_admin" required><br>

                <label for="logo_web">Logo Website</label>
                <input type="file" id="logo_web" name="logo_web" required><br>

                <input type="submit" value="Submit">
            </form>
        </div>
    </main>


    <footer>
        <!-- <?php include "footer.php"; ?> -->
    </footer>

</body>

</html>