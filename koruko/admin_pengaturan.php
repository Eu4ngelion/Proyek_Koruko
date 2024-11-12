<?php
require "koneksi.php";
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
        <div class="container-admin-pengaturan">
            <div class="page-title">
                <h1>Pengaturan</h1>
            </div>
            <div class="slice-container">
                <div class="admin-pengaturan-slice-left">
                    <div class="page-title-2">
                        <h2>Website</h2>
                    </div>
                    <div>
                        <form action="proses-adminpengaturan.php" method="post" enctype="multipart/form-data">
                            <div>
                                <label for="deskripsi-footer-admin">Nama Pengguna Admin</label>
                                <input class="form-field" type="text" id="deskripsi-footer-admin" name="deskripsi-footer-admin" required></input>
                            </div>
                            <div>
                                <label for="link-instagram-admin">Sandi Admin</label>
                                <input class="form-field" id="link-instagram-admin" name="link-instagram-admin" required></input>
                            </div>
                            <div>
                                <label for="judul-website-admin">Judul Website</label>
                                <input class="form-field" type="email" id="judul-website-admin" name="judul-website-admin" required></input>
                            </div>
                            <div>
                                <label for="email-admin">Email</label>
                                <input class="form-field" type="text" id="email-admin" name="email-admin" required></input>
                            </div>
                            <div>
                                <label for="nomor-admin">No Telepon</label>
                                <input class="form-field" id="nomor-admin" name="nomor-admin" required></input>
                            </div>
                            <div>
                                <label for="profil-admin">Profil Admin</label>
                                <input class="form-field" type="file" id="profil-admin" name="profil-admin" accept="image/*" required></input>
                            </div>
                            <div>
                                <label for="logo-website-admin">Logo Website</label>
                                <input class="form-field" type="file" id="logo-website-admin" name="logo-website-admin" accept="image/*" required></input>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="admin-pengaturan-slice-right">
                    <div class="page-title-2">
                        <h2>Footer</h2>
                    </div>
                    <div>
                        <form action="proses-adminpengaturan.php" method="post" enctype="multipart/form-data">
                            <div>
                                <label for="deskripsi-footer-admin">Deskripsi Footer<Footer></Footer></label>
                                <textarea class="form-field" type="text" id="deskripsi-footer-admin" name="deskripsi-footer-admin" required></textarea>
                            </div>
                            <div>
                                <label for="link-instagram-admin">Link Instagram</label>
                                <input class="form-field" id="link-instagram-admin" name="link-instagram-admin" required></input>
                            </div>
                            <div>
                                <label for="link-twitter-admin">Link Twitter</label>
                                <input class="form-field" type="email" id="link-twitter-admin" name="link-twitter-admin" required></input>
                            </div>
                            <div>
                                <label for="link-facebook-admin">Link Facebook</label>
                                <input class="form-field" type="text" id="link-facebook-admin" name="link-facebook-admin" required></input>
                            </div>
                            <div>
                                <label for="link-youtube-admin">Link Youtube</label>
                                <input class="form-field" id="link-youtube-admin" name="link-youtube-admin" required></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="btn-admin-tentang">
                <button class="btn-batal-admin">Batal</button>
                <button class="btn-simpan-admin">Simpan</button>
            </div>
        </div>
    </main>

    <footer>
        <?php include "navbar.php"; ?>
    </footer>

</body>

</html>