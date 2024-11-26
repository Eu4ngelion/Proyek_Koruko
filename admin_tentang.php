<?php
require "koneksi.php";

$sql_tim = "SELECT * FROM tim";
$result_tim = mysqli_query($conn, $sql_tim);
if (!$result_tim) {
    die("Query error: " . mysqli_error($conn));
}

$sql_website = "SELECT * FROM website LIMIT 1";
$result_website = mysqli_query($conn, $sql_website);
if (!$result_website) {
    die("Query error: " . mysqli_error($conn));
}
$row_website = mysqli_fetch_assoc($result_website);

$deskripsi_current = $row_website['deskripsi_tentang'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deskripsi_tentang = $_POST['deskripsi'];
    $visi = $_POST['visi'];
    $misi = $_POST['misi'];
    $gambar_tentang = $_FILES['gambar'];

    $gambar_tentang_dir = "images/website/";
    $gambar_tentang_name = "gambar_tentang.jpg";

    if ($gambar_tentang['tmp_name']) {
        if (file_exists($gambar_tentang_dir . $gambar_tentang_name)) {
            unlink($gambar_tentang_dir . $gambar_tentang_name);
        }
        if (!move_uploaded_file($gambar_tentang['tmp_name'], $gambar_tentang_dir . $gambar_tentang_name)) {
            die("Gagal mengupload gambar");
        }
    }

    $query_website = "UPDATE website SET gambar_tentang='$gambar_tentang_name', deskripsi_tentang='$deskripsi_tentang', visi='$visi', misi='$misi' WHERE deskripsi_tentang = '$deskripsi_current'";
    if (!mysqli_query($conn, $query_website)) {
        die("Query error: " . mysqli_error($conn));
    }

    echo "<script>alert('Data berhasil diperbarui!');</script>";
    header("Refresh:0");
}
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
    </style>
    <link rel="stylesheet" href="styles/admin.css">
</head>

<body>
    <header>
        <?php include "navbar.php"; ?>
    </header>

    <main>
        <div class="container-hero">
            <div class="main-title">Edit Tentang Kami</div>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="container-pengaturan">
                <div class="form-row-1">
                    <div class="form-group-1_1">
                        <?php if ($row_website['gambar_tentang']) { ?>
                            <img src="images/website/<?php echo $row_website['gambar_tentang']; ?>" alt="Gambar Tentang" class="gambar_tentang">
                        <?php } ?>
                        <br>
                        <label class="gambar-section" for="gambar">Upload Gambar</label>
                        <br>
                        <input type="file" id="gambar" name="gambar" accept="image/*" style="display: none;">
                    </div>
                    <div class="form-group-1_2">
                        <textarea id="deskripsi" name="deskripsi"><?php echo $row_website['deskripsi_tentang']; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="container-pengaturan">
                <div class="form-row-2">
                    <div class="form-group-2">
                        <label for="visi">Visi</label>
                        <br>
                        <textarea id="visi" name="visi" rows="4" cols="50"><?php echo $row_website['visi']; ?></textarea>
                    </div>
                    <div class="form-group-2">
                        <label for="misi">Misi</label>
                        <br>
                        <textarea id="misi" name="misi" rows="4" cols="50"><?php echo $row_website['misi']; ?></textarea>
                    </div>
                </div>
                <div class="btn-tentang">
                    <input class="btn-simpan" type="submit" value="Simpan">
                    <input class="btn-batal" type="reset" value="Batal">
                </div>
            </div>
        </form>

        <div class="container-hero-2">
            <div class="main-title-2">Anggota Tim</div>
        </div>

        <div class="container-tambah">
            <a href="form_anggota.php">
                <button class="perbarui">
                    Tambah
                </button>
            </a>
        </div>

        <form action="" method="POST">
            <div class="container-anggota">
                <table class="table-anggota">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Peran</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_tim)) { ?>
                            <tr>
                                <td><?php echo $row['nama_anggota']; ?></td>
                                <td><?php echo $row['peran']; ?></td>
                                <td>
                                    <?php
                                    $image_path = "images/anggota/" . $row['foto'];
                                    if (file_exists($image_path)) {
                                        echo '<img src="' . $image_path . '" alt="Gambar Anggota" class="gambar_anggota">';
                                    } else {
                                        echo 'Gambar tidak ditemukan' . $image_path;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="perbarui_anggota.php?id=<?php echo $row['id_anggota']; ?>">
                                        <button type="button" class="perbarui">Perbarui</button>
                                    </a>
                                    <a href="hapus_anggota.php?id=<?php echo $row['id_anggota']; ?>">
                                        <button type="button" class="hapus">Hapus</button>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>

    </main>

    <footer>
        <?php include "footer.php" ?>
    </footer>

    <script>
        // update preview image
        document.getElementById('gambar').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    document.querySelector('.gambar_tentang').src = reader.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>

</html>