<?php
require "koneksi.php";

session_start();
if ($_SESSION['username'] != 'admin') {
    header('location: index.php');
    exit();
}
if (!isset($_GET['id_ruko'])) {
    echo "
        <script>
            alert('ID ruko tidak ditemukan!');
            document.location.href = 'admin_properti.php';
        </script>";
    exit();
}
$idRuko = $_GET['id_ruko'];

$result = mysqli_query($conn, "SELECT * FROM ruko WHERE id_ruko = $idRuko");

while ($row = mysqli_fetch_assoc($result)) {
    $ruko[] = $row;
}
if (isset($_POST['verifikasi'])) {
    $sql = "UPDATE ruko SET status = 1 WHERE id_ruko = $idRuko";
    $hasil = mysqli_query($conn, $sql);
    if ($hasil) {
        echo "
            <script>
                alert('Berhasil memverifikasi ruko!');
                document.location.href = 'admin_properti.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Gagal memverifikasi ruko!');
                document.location.href = 'admin_properti.php';
            </script>";
    }
}

if (isset($_POST['tolak'])) {
    $sql = "UPDATE ruko SET status = -1 WHERE id_ruko = $idRuko";
    $hasil = mysqli_query($conn, $sql);
    if ($hasil) {
        echo "
            <script>
            alert('Berhasil menolak ruko!');
            document.location.href = 'admin_properti.php';
            </script>";
    } else {
        echo "
            <script>
            alert('Gagal menolak ruko!');
            document.location.href = 'admin_properti.php';
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
    <link rel="stylesheet" href="styles/admin_verif.css">
</head>

<body>
    <header class="header">
        <?php include "navbar.php"; ?>
    </header>

    <main class="container">
        <div class="header-content">
            <div class="title">Verifikasi Ruko</div>
            <div class="action-buttons">
                <a href="admin_properti.php">
                    <button class="btn btn-kembali">Kembali</button>
                </a>
                <form class="form-verif-tolak" method="POST" action="">
                    <button type="submit" class="btn btn-verifikasi" name="verifikasi" value="verifikasi">Verifikasi</button>
                    <button type="submit" class="btn btn-tolak" name="tolak" value="tolak">Tolak</button>
                </form>
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
                        <label class="label-form">Status</label>
                        <input name="status" type="text" value="<?php echo $ruko[0]['status'] ?>" disabled>
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
                        <label class="label-form">Luas Bangunan</label>
                        <input name="luasBangunan" type="text" value="<?php echo $ruko[0]['luas_bangunan'] ?>" disabled>
                    </div>

                    <div class="form-input">
                        <label class="label-form">Kota</label>
                        <input name="kota" type="text" value="<?php echo $ruko[0]['kota'] ?>" disabled>
                    </div>
                    
                    <div class="form-input price-group">
                        <label class="label-form">Harga Sewa</label>
                        <input name="hargaSewa" type="number" value="<?php echo $ruko[0]['harga_sewa'] ?>" disabled>
                        <span class="price-suffix">per tahun</span>
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
                        <div class="big-preview-container">
                            <button class="nav-prev" id="nav-prev">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <div class="preview-container">
                                <?php 
                                    // menampilkan gambar ruko
                                    $sql = "SELECT * FROM gambar_ruko WHERE id_ruko = $idRuko";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<img class="preview-img" src="images/ruko/' . $row['gambar_properti'] . '" style="display:none">';
                                    }
                                ?>
                            </div>
                            <button class="nav-next" id="nav-next">
                                <i class="fa-solid fa-chevron-right"></i>   
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <footer class="footer">
        <?php include "footer.php"; ?>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const previewContainer = document.querySelector('.preview-container');
            const previewImages = document.querySelectorAll('.preview-container img');
            const navPrev = document.querySelector('.nav-prev');
            const navNext = document.querySelector('.nav-next');
            let currentImageIndex = 0;

            // Function to show image at given index
            function showImage(index) {
                // Hide all images first
                previewImages.forEach(img => {
                    img.style.display = 'none';
                });

                // Show the current image
                previewImages[index].style.display = 'block';

                // Update navigation button states
                updateNavigationState();
            }

            // Function to update navigation button states
            function updateNavigationState() {
                // Update prev button state
                navPrev.disabled = currentImageIndex === 0;
                navPrev.style.opacity = currentImageIndex === 0 ? '0.5' : '1';

                // Update next button state
                navNext.disabled = currentImageIndex === previewImages.length - 1;
                navNext.style.opacity = currentImageIndex === previewImages.length - 1 ? '0.5' : '1';
            }

            // Previous button click handler
            navPrev.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default button behavior
                if (currentImageIndex > 0) {
                    currentImageIndex--;
                    showImage(currentImageIndex);
                }
            });

            // Next button click handler
            navNext.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default button behavior
                if (currentImageIndex < previewImages.length - 1) {
                    currentImageIndex++;
                    showImage(currentImageIndex);
                }
            });

            // Optional: Add keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft' && currentImageIndex > 0) {
                    currentImageIndex--;
                    showImage(currentImageIndex);
                } else if (e.key === 'ArrowRight' && currentImageIndex < previewImages.length - 1) {
                    currentImageIndex++;
                    showImage(currentImageIndex);
                }
            });

            // Add touch swipe support for mobile devices
            let touchStartX = 0;
            let touchEndX = 0;

            previewContainer.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });

            previewContainer.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                const swipeThreshold = 50; // Minimum swipe distance
                const swipeDistance = touchEndX - touchStartX;

                if (Math.abs(swipeDistance) > swipeThreshold) {
                    if (swipeDistance > 0 && currentImageIndex > 0) {
                        // Swipe right - show previous image
                        currentImageIndex--;
                        showImage(currentImageIndex);
                    } else if (swipeDistance < 0 && currentImageIndex < previewImages.length - 1) {
                        // Swipe left - show next image
                        currentImageIndex++;
                        showImage(currentImageIndex);
                    }
                }
            }

            // Initialize the first image
            showImage(currentImageIndex);
        });
    </script>
</body>

</html>