<?php
require "koneksi.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (($_SESSION['login']) == false) {
    header("Location: kelola.php");
}

// Function untuk debugging
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

    // Begin transaction
    mysqli_begin_transaction($conn);

    try {
        // First insert the ruko data
        $sql = "INSERT INTO ruko (nama_pengguna, nama_ruko, harga_jual, luas_bangunan, harga_sewa, kota, luas_tanah, jmlh_kmr_tdr, jmlh_kmr_mandi, alamat, jmlh_lantai, jmlh_garasi, deskripsi, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssdddsdddsids",
            $username,
            $namaRuko,
            $hargaJual,
            $luasBangunan,
            $hargaSewa,
            $kota,
            $luasTanah,
            $kamarTidur,
            $kamarMandi,
            $alamat,
            $jumlahLantai,
            $garasi,
            $deskripsi
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to insert ruko data");
        }

        $id_ruko = mysqli_insert_id($conn);

        // Process each uploaded file
        foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['image']['error'][$key] === UPLOAD_ERR_OK) {
                $file_name = $_FILES['image']['name'][$key];
                $file_size = $_FILES['image']['size'][$key];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                // Validate extension
                if (!in_array($file_ext, $allowed_ext)) {
                    throw new Exception("Invalid file format for: " . $file_name);
                }

                // Validate size
                if ($file_size > 10000000) {
                    throw new Exception("File too large: " . $file_name);
                }

                // Generate unique filename
                $new_file_name = uniqid('ruko_' . $id_ruko . '_') . '.' . $file_ext;
                $target_file = $target_dir . $new_file_name;

                // Move the file
                if (!move_uploaded_file($tmp_name, $target_file)) {
                    throw new Exception("Failed to move uploaded file: " . $file_name);
                }

                // Insert image record
                $sql = "INSERT INTO gambar_ruko (id_ruko, gambar_properti) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "is", $id_ruko, $new_file_name);

                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Failed to insert image record for: " . $file_name);
                }

                $uploaded_files[] = $new_file_name;
            }
        }

        // If we got here, everything worked
        mysqli_commit($conn);


        echo "<script>
        alert('Ruko dan " . count($uploaded_files) . " gambar berhasil ditambahkan!');
        window.location.href = 'kelola.php';
        </script>";
    } catch (Exception $e) {
        // If anything went wrong, roll back the transaction
        mysqli_rollback($conn);

        // Clean up any files that were uploaded
        foreach ($uploaded_files as $file) {
            if (file_exists($target_dir . $file)) {
                unlink($target_dir . $file);
            }
        }


        echo "<script>
        alert('Error: " . addslashes($e->getMessage()) . "');
        window.location.href = 'tambah_ruko.php';
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
                    <a href="kelola.php">
                        <button class="btn btn-kembali-utama">Kembali</button>
                    </a>
                    <button type="submit" class="btn btn-tambah-utama" name="tambah" value="tambah">Tambah</button>
                </div>
            </div>

            <div class="form-container">
                <div class="form-grid">
                    <div class="form-input">
                        <label class="label-form">ID Ruko</label>
                        <!-- cari max id_ruko pada sql -->
                        <?php
                        $sql = "SELECT MAX(id_ruko) FROM ruko";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                        $id_ruko = $row[0] + 1;
                        ?>
                        <input name="idRuko" type="text" value="<?php echo $id_ruko ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Pemilik Ruko</label>
                        <input name="pemilikRuko" type="text" value="<?php echo $pemilik['nama_pengguna'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Nama Ruko</label>
                        <input name="namaRuko" type="text" required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Harga Jual</label>
                        <input name="hargaJual" type="number" required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Status</label>
                        <input name="status_palsu" type="text" value="Belum Diverifikasi" disabled>
                        <input name="status" type="hidden" value="0" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Luas Bangunan</label>
                        <input name="luasBangunan" type="text" required>
                    </div>

                    <div class="form-input price-group">
                        <label class="label-form">Harga Sewa</label>
                        <input name="hargaSewa" type="number" required>
                        <span class="price-suffix">per tahun</span>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kota</label>
                        <input name="kota" type="text" required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Luas Tanah</label>
                        <input name="luasTanah" type="text" required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kamar Tidur</label>
                        <input name="kamarTidur" type="number" required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kamar Mandi</label>
                        <input name="kamarMandi" type="number" required>
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
                                <input name="jumlahLantai" type="text" required>
                            </div>
                            <div class="form-input">
                                <label class="label-form">Garasi</label>
                                <input name="garasi" type="number" required>
                            </div>
                        </div>
                        <div class="form-input full-width">
                            <label class="label-form">Alamat</label>
                            <input name="alamat" type="text" required>
                        </div>
                        <div class="form-input full-width">
                            <label class="label-form">Deskripsi</label>
                            <textarea name="deskripsi" class="input-textarea" required></textarea>
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
            let fileList = new DataTransfer(); // Create a new DataTransfer object to manage files

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
                    img.src = images[currentImageIndex].preview;
                    previewContainer.appendChild(img);
                } else {
                    previewContainer.textContent = 'Tidak ada gambar.';
                }
                updateNavigationButtons();
                updateImageCounter();

                // Update the file input with current files
                fileList = new DataTransfer();
                images.forEach(img => {
                    fileList.items.add(img.file);
                });
                imageInput.files = fileList.files;
            }

            imageInput.addEventListener('change', (e) => {
                const files = Array.from(e.target.files);

                if (images.length + files.length > 3) {
                    alert('Maksimal 3 gambar yang diperbolehkan!');
                    return;
                }

                files.forEach(file => {
                    if (images.length < 3) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            images.push({
                                file: file,
                                preview: e.target.result
                            });
                            if (images.length === 1) {
                                currentImageIndex = 0;
                            }
                            displayCurrentImage();
                        };
                        reader.readAsDataURL(file);
                    }
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

            // Add form submit handler
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                if (images.length === 0) {
                    e.preventDefault();
                    alert('Silakan pilih minimal 1 gambar!');
                    return;
                }
                // No need to do anything else, the files are already in the input
            });
        });
    </script>
</body>

</html>