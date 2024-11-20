<?php
require "koneksi.php";

$sql_admin = "SELECT * FROM admin LIMIT 1";
$result_admin = mysqli_query($conn, $sql_admin);
if (!$result_admin) {
    die("Query error: " . mysqli_error($conn));
}
$row_admin = mysqli_fetch_assoc($result_admin);

$sql_website = "SELECT * FROM website LIMIT 1";
$result_website = mysqli_query($conn, $sql_website);
if (!$result_website) {
    die("Query error: " . mysqli_error($conn));
}
$row_website = mysqli_fetch_assoc($result_website);

$nama_admin_current = $row_admin['nama_admin'];
$judul_current = $row_website['judul'];

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
    $instagram = $_POST['instagram'];
    $facebook = $_POST['facebook'];
    $youtube = $_POST['youtube'];
    $twitter = $_POST['twitter'];
    $deskripsi_footer = $_POST['deskripsi_footer'];
    $logo_web = $_FILES['logo_web'];

    $admin_upload_dir = 'images/admin/';
    $website_upload_dir = 'images/website/';

    // save old pict
    $old_gambar_admin = $row_admin['gambar_admin'];
    $old_logo_web = $row_website['logo_web'];

    // delete old pict
    if ($gambar_admin['tmp_name']) {
        if (file_exists($admin_upload_dir . $old_gambar_admin)) {
            unlink($admin_upload_dir . $old_gambar_admin);
        }
        if (!move_uploaded_file($gambar_admin['tmp_name'], $admin_upload_dir . $old_gambar_admin)) {
            die("Gagal upload admin image.");
        }
    }

    if ($logo_web['tmp_name']) {
        if (file_exists($website_upload_dir . $old_logo_web)) {
            unlink($website_upload_dir . $old_logo_web);
        }
        if (!move_uploaded_file($logo_web['tmp_name'], $website_upload_dir . $old_logo_web)) {
            die("Gagal upload website logo.");
        }
    }

    $query_admin = "UPDATE admin SET nama_admin='$nama_admin', sandi='$sandi_admin', gambar_admin='$old_gambar_admin' WHERE nama_admin = '$nama_admin_current'";
    if (!mysqli_query(mysql: $conn, query: $query_admin)) {
        die("Query error: " . mysqli_error($conn));
    }

    $query_website = "UPDATE website SET judul='$judul', deskripsi_footer='$deskripsi_footer', alamat='$alamat', email='$email', telepon='$telepon', instagram='$instagram', twitter='$twitter', facebook='$facebook', youtube='$youtube', logo_web='$old_logo_web' WHERE judul = '$judul_current'";
    if (!mysqli_query(mysql: $conn, query: $query_website)) {
        die("Query error: " . mysqli_error($conn));
    }

    echo "Data berhasil diperbarui!";
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

            <div class="container-pengaturan">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div style="display: flex; justify-content: space-between;">
                        <div style="flex: 1; margin-right: 20px;">
                            <table style="width: 100%;">
                                <tr>
                                    <h2>Website</h2>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="nama_admin">Nama Pengguna Admin</label>
                                            <input type="text" id="nama_admin" name="nama_admin" value="<?php echo $row_admin['nama_admin']; ?>" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="sandi">Sandi Admin</label>
                                            <input type="password" id="sandi" name="sandi" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="judul">Judul Website</label>
                                            <input type="text" id="judul" name="judul" value="<?php echo $row_website['judul']; ?>" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email" value="<?php echo $row_website['email']; ?>" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="telepon">No Telepon</label>
                                            <input type="text" id="telepon" name="telepon" value="<?php echo $row_website['telepon']; ?>" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" id="alamat" name="alamat" value="<?php echo $row_website['alamat']; ?>" required>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="flex: 1; margin-right: 10px;">
                            <table style="width: 100%;">
                                <tr>
                                    <h2>Footer</h2>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="deskripsi_footer">Deskripsi Footer</label>
                                            <textarea id="deskripsi_footer" name="deskripsi_footer" required><?php echo $row_website['deskripsi_footer']; ?></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="instagram">Link Instagram</label>
                                            <input type="url" id="instagram" name="instagram" value="<?php echo $row_website['instagram']; ?>" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="twitter">Link Twitter</label>
                                            <input type="url" id="twitter" name="twitter" value="<?php echo $row_website['twitter']; ?>" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="facebook">Link Facebook</label>
                                            <input type="url" id="facebook" name="facebook" value="<?php echo $row_website['facebook']; ?>" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td colspan="2">
                                        <div class="form-item">
                                            <label for="youtube">Link YouTube</label>
                                            <input type="url" id="youtube" name="youtube" value="<?php echo $row_website['youtube']; ?>" required>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group-picture">
                        <tr class="form-group">
                            <td colspan="2">
                                <div class="form-item">
                                    <label for="gambar_admin">Profil Admin</label>
                                    <input type="file" id="gambar_admin" name="gambar_admin">
                                </div>
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td colspan="2">
                                <div class="form-item">
                                    <label for="logo_web">Logo Website</label>
                                    <input type="file" id="logo_web" name="logo_web">
                                </div>
                            </td>
                        </tr>
                    </div>
                    <div class="btn-pengaturan">
                        <input class="btn-simpan" type="submit" value="Simpan">
                        <input class="btn-batal" type="reset" value="Batal">
                    </div>
                </form>
            </div>
    </main>

    <footer>
        <?php include "footer.php"; ?>
    </footer>

</body>

</html>