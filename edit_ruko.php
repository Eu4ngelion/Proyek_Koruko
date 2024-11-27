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
$sql = "SELECT * FROM pengguna WHERE nama_pengguna = '$username'";
$result = mysqli_query($conn, $sql);
$pemilik = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM gambar_ruko WHERE id_ruko = $id_ruko";
$result = mysqli_query($conn, $sql);
$gambar_ruko = [];
while ($row = mysqli_fetch_assoc($result)) {
    $gambar_ruko[] = $row['gambar_properti'];
}

if (isset($_POST['edit'])) {
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

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Update ruko data
        $sql = "UPDATE ruko SET 
            nama_ruko = ?, 
            harga_jual = ?, 
            luas_bangunan = ?, 
            harga_sewa = ?, 
            kota = ?, 
            luas_tanah = ?, 
            jmlh_kmr_tdr = ?, 
            jmlh_kmr_mandi = ?, 
            alamat = ?, 
            jmlh_lantai = ?, 
            jmlh_garasi = ?, 
            deskripsi = ?, 
            status = 0
            WHERE id_ruko = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sdddsdddsidsi",
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
            $deskripsi,
            $id_ruko
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to update ruko data");
        }

        // Handle image uploads if any new images were uploaded
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'][0])) {
            $target_dir = "images/ruko/";
            $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
            $uploaded_files = [];

            // Delete existing images
            $sql = "DELETE FROM gambar_ruko WHERE id_ruko = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id_ruko);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to delete existing images");
            }

            // Process each new image
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
        }

        // If we got here, everything worked
        mysqli_commit($conn);

        echo "<script>
        alert('Ruko berhasil diupdate!');
        window.location.href = 'kelola.php';
        </script>";
    } catch (Exception $e) {
        // If anything went wrong, roll back the transaction
        mysqli_rollback($conn);

        echo "<script>
        alert('Error: " . addslashes($e->getMessage()) . "');
        window.location.href = 'edit_ruko.php?id_ruko=" . $id_ruko . "';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/assets/icon_navbar.png">
    <title>Edit Ruko</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/edit_ruko.css">
</head>

<body>
    <header class="header">
        <?php include "navbar.php"; ?>
    </header>

    <form method="POST" action="" enctype="multipart/form-data">
        <main class="container">
            <div class="header-content">
                <div class="title-header">Edit Ruko</div>
                <div class="action-buttons">
                    <a href="kelola.php">
                        <button type="button" class="btn btn-kembali-utama">Kembali</button>
                    </a>
                    <button type="submit" class="btn btn-edit-utama" name="edit" value="edit">Edit</button>
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
                        <label class="label-form">Status</label>
                        <input name="status_palsu" type="text" value="Belum Diverifikasi" disabled>
                        <input name="status" type="hidden" value="0" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Nama Ruko</label>
                        <input name="namaRuko" type="text" value="<?php echo $ruko['nama_ruko'] ?>" minlength="1" maxlength="30" required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Harga Jual</label>
                        <input name="hargaJual" type="number" value="<?php echo $ruko['harga_jual'] ?>" min="0" step="1" >
                    </div>

                    <div class="form-input">
                        <label class="label-form">Luas Bangunan</label>
                        <input name="luasBangunan" type="text" value="<?php echo $ruko['luas_bangunan'] ?>" min="0" step="1"  required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kota</label>
                        <input name="kota" type="text" value="<?php echo $ruko['kota'] ?>" minlength="1" maxlength="30" required>
                    </div>

                    <div class="form-input price-group">
                        <label class="label-form">Harga Sewa</label>
                        <input name="hargaSewa" type="number" value="<?php echo $ruko['harga_sewa'] ?>" min="0" step="1" >
                        <span class="price-suffix">per tahun</span>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Luas Tanah</label>
                        <input name="luasTanah" type="text" value="<?php echo $ruko['luas_tanah'] ?>" min="0" step="1" required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kamar Tidur</label>
                        <input name="kamarTidur" type="number" value="<?php echo $ruko['jmlh_kmr_tdr'] ?>" min="0" step="1" required>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kamar Mandi</label>
                        <input name="kamarMandi" type="number" value="<?php echo $ruko['jmlh_kmr_mandi'] ?>" min="0" step="1" required>
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
                                <input name="jumlahLantai" type="text" value="<?php echo $ruko['jmlh_lantai'] ?>" min="0" step="1" required>
                            </div>
                            <div class="form-input">
                                <label class="label-form">Garasi</label>
                                <input name="garasi" type="number" value="<?php echo $ruko['jmlh_garasi'] ?>" min="0" step="1" required>
                            </div>
                        </div>
                        <div class="form-input full-width">
                            <label class="label-form">Alamat</label>
                            <input name="alamat" type="text" value="<?php echo $ruko['alamat'] ?>" minlength="1" maxlength="100" required>
                        </div>
                        <div class="form-input full-width">
                            <label class="label-form">Deskripsi</label>
                            <textarea name="deskripsi" class="input-textarea" minlength="1" maxlength="500" required><?php echo $ruko['deskripsi'] ?>"</textarea>
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
            let fileList = new DataTransfer();

            // Function to initialize existing images
            function initializeExistingImages() {
                const existingImages = <?php echo json_encode($gambar_ruko ?? []); ?>;

                if (existingImages && existingImages.length > 0) {
                    existingImages.forEach(image => {
                        // Create a fetch request for each image to convert to File object
                        fetch(`images/ruko/${image}`)
                            .then(response => response.blob())
                            .then(blob => {
                                const file = new File([blob], image, {
                                    type: blob.type
                                });
                                images.push({
                                    file: file,
                                    preview: `images/ruko/${image}`
                                });
                                fileList.items.add(file);
                                if (images.length === 1) {
                                    currentImageIndex = 0;
                                }
                                displayCurrentImage();
                            });
                    });
                }
            }

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
                    img.style.maxWidth = '100%';
                    img.style.height = 'auto';
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
            });

            // Initialize existing images when page loads
            initializeExistingImages();
        });
    </script>
</body>

</html>