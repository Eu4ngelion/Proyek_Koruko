<?php
require "koneksi.php";

session_start();
if ($_SESSION['username'] != 'admin') {
    header('location: .php');
    exit();
}
$idRuko = $_GET['id_ruko'];

$result = mysqli_query($conn, "SELECT * FROM ruko WHERE id_ruko = $idRuko");

while ($row = mysqli_fetch_assoc($result)) {
    $ruko[] = $row;
}

if (isset($_POST["submit"])) {

    if ($_FILES['foto']['error'] === 4) { // cek apakah ada file yg diupload
        $file_name = $oldImg; // kalo tidak, akan mengambil gambar lama
    } else {
        $tmp_name = $_FILES['foto']['tmp_name']; // mengambil path temporary file
        $file_name = $_FILES['foto']['name']; // mengambil nama file

        // cek apakah yang diupload adalah file gambar
        $validExtensions = ['png', 'jpg', 'jpeg'];
        $fileExtension = explode('.', $file_name);
        $fileExtension = strtolower(end($fileExtension));
        if (!in_array($fileExtension, $validExtensions)) {
            echo "
                <script>
                    alert('Tolong upload file gambar!');
                </script>";
        } else {
            move_uploaded_file($tmp_name, 'imgRuko/' . $file_name);
            unlink('imgRuko/' . $oldImg); // menghapus gambar lama dari folder images
        }
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "
        <script>
            alert('Berhasil Mengubah data ruko!');
            document.location.href = ' edit_ruko.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Gagal Mengubah data ruko!');
            document.location.href = 'edit_ruko.php';
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Ruko</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/stylececel.css">
</head>

<body>
    <header class="header">
        <?php include "navbar.php"; ?>
    </header>

    <main class="container">
        <div class="header-content">
            <div class="title">Verifikasi Ruko</div>
            <div class="action-buttons">
                <button class="btn btn-kembali">Kembali</button>
                <button class="btn btn-verifikasi">Verifikasi</button>
                <button class="btn btn-tolak">Tolak</button>
            </div>
        </div>

        <div class="form-container">
            <form>
                <div class="form-grid">
                    <div class="form-input">
                        <label class="label-form">ID Ruko</label>
                        <input name="idRuko" type="text" value="<?php echo $idRuko ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Pemilik Ruko</label>
                        <input name="pemilikRuko" type="text" value="<?php echo $ruko[0]['nama_pengguna'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Nama Ruko</label>
                        <input name="namaRuko" type="text" value="<?php echo $ruko[0]['nama_ruko'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Harga Jual</label>
                        <input name="hargaJual" type="number" value="<?php echo $ruko[0]['harga_jual'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Status</label>
                        <input name="status" type="text" value="<?php echo $ruko[0]['status'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Luas Bangunan</label>
                        <input name="luasBangunan" type="text" value="<?php echo $ruko[0]['luas_bangunan'] ?>" disabled>
                    </div>

                    <div class="form-input price-group">
                        <label class="label-form">Harga Sewa</label>
                        <input name="hargaSewa" type="number" value="<?php echo $ruko[0]['harga_sewa'] ?>" disabled>
                        <span class="price-suffix">per tahun</span>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kota</label>
                        <input name="kota" type="text" value="<?php echo $ruko[0]['kota'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Luas Tanah</label>
                        <input name="luasTanah" type="text" value="<?php echo $ruko[0]['luas_tanah'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kamar Tidur</label>
                        <input name="kamarTidur" type="number" value="<?php echo $ruko[0]['jmlh_kmr_tdr'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kamar Mandi</label>
                        <input name="kamarMandi" type="number" value="<?php echo $ruko[0]['jmlh_kmr_mandi'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Alamat</label>
                        <input name="alamat" type="text" value="<?php echo $ruko[0]['alamat'] ?>" disabled>
                    </div>
                </div>
                <div class="lower-form">

                    <div class="lower-form-kiri">
                        <div class="lower-form-kiri-atas">
                            <div class="form-input">
                                <label class="label-form">Jumlah Lantai</label>
                                <input name="alamat" type="text" value="<?php echo $ruko[0]['jmlh_lantai'] ?>" disabled>
                            </div>
                            <div class="form-input">
                                <label class="label-form">Garasi</label>
                                <input name="garasi" type="number" value="<?php echo $ruko[0]['jmlh_garasi'] ?>" disabled>
                            </div>
                        </div>
                        <div class="form-input full-width">
                            <label class="label-form">Alamat</label>
                            <input name="alamat" type="text" value="<?php echo $ruko[0]['alamat'] ?>" disabled>
                        </div>
                        <div class="form-input full-width">
                            <label class="label-form">Deskripsi</label>
                            <textarea name="deskripsi" class="input-textarea" disabled><?php echo $ruko[0]['deskripsi'] ?></textarea>
                        </div>
                    </div>


                    <div class="preview-section">
                        <h3 class="preview-title">Preview</h3>
                        <div class="preview-container">
                            <img src="placeholder-image.svg" alt="Preview" id="previewImage">
                        </div>
                        <div class="preview-nav">
                            <button class="nav-prev">←</button>
                            <button class="nav-next">→</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <footer class="footer">
        <?php include "footer.php"; ?>
    </footer>
</body>

</html>