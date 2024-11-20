<?php
require "koneksi.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (($_SESSION['login']) == false) {
    header("Location: kelola.php");
}

if (isset($_GET['id_ruko'])) {
    $id_ruko = $_GET['id_ruko'];
    $sql = "SELECT * FROM ruko WHERE id_ruko = $id_ruko";
    $result = mysqli_query($conn, $sql);
    $ruko = mysqli_fetch_assoc($result);
    if (!$ruko) {
        echo "<script>
        alert('Ruko tidak ditemukan!')
        window.location.href = 'kelola.php'
        </script>";
    }
} else {
    echo "<script>
    alert('ID Ruko tidak ditemukan!')
    window.location.href = 'kelola.php'
    </script>";
}



$username = $_SESSION['username'];
// Ambil data pemilik ruko saat ini saja
$sql = "SELECT * FROM pengguna WHERE nama_pengguna = '$username'";
$result = mysqli_query($conn, $sql);
$pemilik = mysqli_fetch_assoc($result);

if (isset($_POST['tambah'])) {
    $namaRuko = $_POST['namaRuko'];
    $hargaJual = $_POST['hargaJual'];
    $luasBangunan = $_POST['luasBangunan'];
    $hargaSewa = $_POST['hargaSewa'];
    $kota = $_POST['kota'];
    $luasTanah = $_POST['luasTanah'];
    $kamarTidur = $_POST['kamarTidur'];
    $kamarMandi = $_POST['kamarMandi'];
    $alamat = $_POST['alamat'];
    $jumlahLantai = $_POST['jumlahLantai'];
    $garasi = $_POST['garasi'];
    $deskripsi = $_POST['deskripsi'];



    // Upload Gambar
    $target_dir = "images/ruko/";
    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
    $uploaded_files = [];

    foreach ($_FILES['image']['name'] as $key => $name) {
        $file_ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $original_file_name = pathinfo($name, PATHINFO_FILENAME);
        $new_file_name = $original_file_name . '_' . time() . '.' . $file_ext;
        $target_file = $target_dir . $new_file_name;

        // Cek Validasi Gambar
        if (!in_array($file_ext, $allowed_ext)) {
            echo "<script>
            alert('Format gambar tidak valid!')
            window.location.href = 'tambah_ruko.php'
            </script>";
            return;
        }

        if ($_FILES['image']['size'][$key] > 10000000) {
            echo "<script>alert('Ukuran gambar terlalu besar (>10mb)!')
            window.location.href = 'tambah_ruko.php'
            </script>";
            return;
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $target_file)) {
            $uploaded_files[] = $new_file_name;
        } else {
            echo "<script>
            alert('Gagal mengupload gambar!')
            window.location.href = 'tambah_ruko.php'
            </script>";
            return;
        }
    }

    if (!empty($uploaded_files)) {
        echo "<script>
        alert(Gambar berhasil diupload!)
        </script>";
    }


    // Insert Database Ruko
    $sql = "INSERT INTO ruko (nama_pengguna, nama_ruko, harga_jual, luas_bangunan, harga_sewa, kota, luas_tanah, jmlh_kmr_tdr, jmlh_kmr_mandi, alamat, jmlh_lantai, jmlh_garasi, deskripsi, status) 
    VALUES ('$username', '$namaRuko', $hargaJual, $luasBangunan, $hargaSewa, '$kota', $luasTanah, $kamarTidur, $kamarMandi, '$alamat', $jumlahLantai, $garasi, '$deskripsi', 0)";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>
        alert('Ruko berhasil ditambahkan!')
        window.location.href = 'admin_properti.php'
        </script>";
    } else {
        echo "<script>
        alert('Gagal menambahkan ruko!')
        window.location.href = 'tambah_ruko.php'
        </script>";
    }

    // Insert Masing-masing Gambar
    $id_ruko = mysqli_insert_id($conn);
    foreach ($uploaded_files as $file_name) {
        $sql = "INSERT INTO gambar_ruko (id_ruko, gambar_properti) VALUES ('$id_ruko', '$file_name')";
        mysqli_query($conn, $sql);
    }


    $id_ruko = mysqli_insert_id($conn);
    $sql = "INSERT INTO gambar_ruko (id_ruko, gambar_properti) VALUES ('$id_ruko', '$new_file_name')";
    mysqli_query($conn, $sql);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Ruko</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/tambah_ruko.css">
</head>

<body>
    <header class="header">
        <?php include "navbar.php"; ?>
    </header>

    <form method="POST" action="" enctype="multipart/form-data">
        <main class="container">
            <div class="header-content">
                <div class="title">Tambah Ruko</div>
                <div class="action-buttons">
                    <a href="admin_properti.php">
                        <button class="btn btn-kembali-utama">Kembali</button>
                    </a>
                    <button type="submit" class="btn btn-tambah-utama" name="tambah" value="tambah">Tambah</button>
                </div>
            </div>

            <div class="form-container">
                <div class="form-grid">
                    <div class="form-input">
                        <label class="label-form">ID Ruko</label>
                        <input name="idRuko" type="text" value="<?php echo $id_ruko ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Pemilik Ruko</label>
                        <input name="pemilikRuko" type="text" value="<?php echo $pemilik['nama_pengguna'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Nama Ruko</label>
                        <input name="namaRuko" type="text" value = "<?php echo $ruko['nama_ruko'] ?>"required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Harga Jual</label>
                        <input name="hargaJual" type="number" value = "<?php echo $ruko['harga_jual'] ?>"required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Status</label>
                        <input name="status_palsu" type="text" value="Belum Diverifikasi" disabled>
                        <input name="status" type="hidden" value="0" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Luas Bangunan</label>
                        <input name="luasBangunan" type="text" value = "<?php echo $ruko['luas_bangunan'] ?>"required>
                    </div>

                    <div class="form-input price-group">
                        <label class="label-form">Harga Sewa</label>
                        <input name="hargaSewa" type="number" value = "<?php echo $ruko['harga_sewa'] ?>"required>
                        <span class="price-suffix">per tahun</span>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kota</label>
                        <input name="kota" type="text" value = "<?php echo $ruko['kota'] ?>"required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Luas Tanah</label>
                        <input name="luasTanah" type="text" value = "<?php echo $ruko['luas_tanah'] ?>"required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kamar Tidur</label>
                        <input name="kamarTidur" type="number" value = "<?php echo $ruko['jmlh_kmr_tdr'] ?>"required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kamar Mandi</label>
                        <input name="kamarMandi" type="number" value = "<?php echo $ruko['jmlh_kmr_mandi'] ?>"required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Tanggal</label>
                        <input name="tanggal" type="date" value="<?php echo date('Y-m-d'); ?>" disabled>
                    </div>
                </div>
                <div class="lower-form">

                    <div class="lower-form-kiri">
                        <div class="lower-form-kiri-atas">
                            <div class="form-input">
                                <label class="label-form">Jumlah Lantai</label>
                                <input name="jumlahLantai" type="text" value = "<?php echo $ruko['jmlh_lantai'] ?>"required>
                            </div>
                            <div class="form-input">
                                <label class="label-form">Garasi</label>
                                <input name="garasi" type="number" value = "<?php echo $ruko['jmlh_garasi'] ?>"required>
                            </div>
                        </div>
                        <div class="form-input full-width">
                            <label class="label-form">Alamat</label>
                            <input name="alamat" type="text" value = "<?php echo $ruko['alamat'] ?>"required>
                        </div>
                        <div class="form-input full-width">
                            <label class="label-form">Deskripsi</label>
                            <textarea name="deskripsi" class="input-textarea" value = "<?php echo $ruko['deskripsi'] ?>"required></textarea>
                        </div>
                    </div>

                    <div class="preview-section">
                        <h3 class="preview-title">Preview</h3>
                        <div class="big-preview-container">
                            <button type="button" class="nav-prev" id="nav-prev" disabled>
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <div class="preview-container">
                                <!-- Preview image will be displayed here -->
                            </div>
                            <button type="button" class="nav-next" id="nav-next" disabled>
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                        <div class="btn tambah-hapus-image">
                            <label for="image" class="btn-tambah">Tambah</label>
                            <input type="file" id="image" name="image[]" accept="image/*" multiple style="display: none;" required>
                            <label class="btn-hapus" id="btn-hapus">Hapus</label>
                        </div>
                        <div class="image-counter">0/3 gambar</div>
                        <!-- Hidden input to store image data for form submission -->
                        <input type="hidden" name="imageData" id="imageData">
                    </div>
                </div>
            </div>
        </main>
    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const previewContainer = document.querySelector('.preview-container');
            const prevButton = document.getElementById('nav-prev');
            const nextButton = document.getElementById('nav-next');
            const deleteButton = document.getElementById('btn-hapus');
            const imageCounter = document.querySelector('.image-counter');
            const imageDataInput = document.getElementById('imageData');

            let images = [];
            let currentImageIndex = 0;

            function updateImageCounter() {
                imageCounter.textContent = `${images.length}/3 gambar`;
            }

            function updateNavigationButtons() {
                prevButton.disabled = currentImageIndex === 0 || images.length === 0;
                nextButton.disabled = currentImageIndex >= images.length - 1 || images.length === 0;
                deleteButton.disabled = images.length === 0;
            }

            function displayCurrentImage() {
                previewContainer.innerHTML = '';
                if (images.length > 0) {
                    const img = document.createElement('img');
                    img.src = images[currentImageIndex];
                    previewContainer.appendChild(img);
                } else {
                    previewContainer.textContent = 'Tidak ada gambar.';
                }
                updateNavigationButtons();
                updateImageCounter();
                // Update hidden input with current images data
                imageDataInput.value = JSON.stringify(images);
            }

            imageInput.addEventListener('change', (e) => {
                const files = Array.from(e.target.files);

                if (images.length + files.length > 3) {
                    alert('Maksimal 3 gambar yang diperbolehkan!');
                    return;
                }

                const promises = files.map(file => {
                    return new Promise((resolve) => {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            resolve(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    });
                });

                Promise.all(promises).then(results => {
                    results.forEach(result => {
                        if (images.length < 3) {
                            images.push(result);
                        }
                    });
                    displayCurrentImage();
                });
            });

            prevButton.addEventListener('click', () => {
                if (currentImageIndex > 0) {
                    currentImageIndex--;
                    displayCurrentImage();
                }
            });

            nextButton.addEventListener('click', () => {
                if (currentImageIndex < images.length - 1) {
                    currentImageIndex++;
                    displayCurrentImage();
                }
            });

            deleteButton.addEventListener('click', () => {
                if (images.length > 0) {
                    images.splice(currentImageIndex, 1);
                    if (currentImageIndex >= images.length && images.length > 0) {
                        currentImageIndex = images.length - 1;
                    }
                    displayCurrentImage();
                }
            });
        });
    </script>
</body>

</html>