<?php
require "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Tentang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        textarea {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    
    <link rel="stylesheet" href="styles/admin.css">
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container">
        <div class="page-title">
            <h1>Edit Tentang Kami</h1>
        </div>

        <div class="slice-up-admin-tentang">
            <div class="slice-up-left">
                <div class="preview-admin">
                    <div class="image-container">
                        <img alt="Preview Image" id="preview-image" style="max-width: 100%; height: auto;">
                    </div>
                    <button class="btn-upload-admin">Upload Gambar</button>
                </div>
            </div>
            <div class="slice-up-right">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group-admin">
                        <textarea id="deskripsi" class="form-field" name="deskripsi" rows="8" cols="50" placeholder=" Masukkan deskripsi"></textarea>
                    </div>
                </form>
            </div>
        </div>

        <div class="slice-down-admin-tentang">
            <form action="" method="post" enctype="multipart/form-data">
                <h2>Visi</h2>
                <div class="form-group-admin">
                    <textarea id="visi" class="form-field" name="visi" rows="6" cols="50" placeholder=" Masukkan visi"></textarea>
                </div>
                <h2>Misi</h2>
                <div class="form-group-admin">
                    <textarea id="misi" class="form-field" name="misi" rows="6" cols="50" placeholder=" Masukkan misi"></textarea>
                </div>
            </form>
        </div>

        <div class="btn-admin-tentang">
            <button class="btn-batal-admin">Batal</button>
            <button class="btn-simpan-admin">Simpan Perubahan</button>

        </div>
    </div>

    <footer>
        <?php include"footer.php"?>
    </footer>
</body>

</html>