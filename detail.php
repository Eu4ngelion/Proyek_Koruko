    <?php
    require "koneksi.php";

    // Memulai Sesion
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION["login"])) {
        $_SESSION["login"] = false;
    }


    if (!isset($_GET['id_ruko'])) {
        echo "script>alert('Ruko tidak ditemukan!')
            window.location.href = 'index.php';
            </script>";
        exit();
    }

    $id_ruko = isset($_GET['id_ruko']) ? intval($_GET['id_ruko']) : 0;

    $query = "SELECT * FROM ruko WHERE id_ruko = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_ruko);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Ruko tidak ditemukan!');
            window.location.href = 'index.php';
            </script>";
        exit();
    }

    $ruko = $result->fetch_assoc();

    $idRuko = $_GET['id_ruko'];
    $query = "SELECT * FROM ruko WHERE id_ruko = $idRuko";
    $result = mysqli_query($conn, $query);
    $ruko = mysqli_fetch_assoc($result);

    $query_gambar = "SELECT * FROM gambar_ruko WHERE id_ruko = $idRuko";
    $hasil = mysqli_query($conn, $query_gambar);
    $num_rows = mysqli_num_rows($hasil);
    $gambar = mysqli_fetch_assoc($hasil);

    $query = "SELECT * FROM pengguna WHERE nama_pengguna = '{$ruko['nama_pengguna']}'";
    $result = mysqli_query($conn, $query);
    $pengguna = mysqli_fetch_assoc($result);

    function formatPropertyPrice($price)
    {
        $priceString = (string)$price;
        $length = strlen($priceString);

        $formattedPrice = '';

        if ($length >= 9) {
            $value = $price / 1000000000;
            $formattedPrice = number_format($value, 1) . ' Miliar/Tahun';
        } else if ($length >= 7) {
            $value = $price / 1000000;
            $formattedPrice = number_format($value, 1) . ' Juta/Tahun';
        } else if ($length >= 6) {
            $value = $price / 100000;
            $formattedPrice = number_format($value, 1) . ' Ratus Ribu/Tahun';
        } else if ($length >= 4) {
            $value = $price / 1000;
            $formattedPrice = number_format($value, 1) . ' Ribu/Tahun';
        } else {
            $formattedPrice = number_format($price) . '/Tahun';
        }

        return $formattedPrice;
    }


    function formatPropertySalePrice($price)
    {
        $priceString = (string)$price;
        $length = strlen($priceString);

        // Initialize variables
        $formattedPrice = '';

        if ($length >= 9) {
            $value = $price / 1000000000;
            $formattedPrice = 'IDR ' . number_format($value, 1) . ' Miliar';
        } else if ($length >= 7) {
            $value = $price / 1000000;
            $formattedPrice = 'IDR ' . number_format($value, 1) . ' Juta';
        } else if ($length >= 4) {
            $value = $price / 1000;
            $formattedPrice = 'IDR ' . number_format($value, 1) . ' Ribu';
        } else {
            $formattedPrice = 'IDR ' . number_format($price);
        }
        return $formattedPrice;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail</title>
        <link rel="icon" href="images/assets/icon_navbar.png">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles/detail_ruko.css">

    </head>

    <body>
        <?php include "navbar.php"; ?>
        <main class="container-main">
            <div class="button-back">
                <a href="index.php">
                    <button class="btn btn-kembali">Kembali</button>
                </a>
            </div>
            <div class="upper-main">
                <div class="header-detail">
                    <div class="header-left">
                        <div class="header-kota">
                            <?php echo $ruko['kota'] ?>
                        </div>
                        <div class="header-nama">
                            <?php echo $ruko['nama_ruko'] ?>
                        </div>
                        <div class="header-alamat">
                            <?php echo $ruko['alamat'] ?>
                        </div>
                    </div>
                    <div class="header-right">
                        <div class="button-sewa-jual">
                            <?php if ($ruko['harga_sewa'] > 0) : ?>
                                <button class="btn btn-sewa">Sewa</button>
                            <?php endif; ?>

                            <?php if ($ruko['harga_jual'] > 0) : ?>
                                <button class="btn btn-jual">Jual</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="image-content">
                    <div class="image-left">
                        <img src="images/ruko/<?php echo $gambar['gambar_properti'] ?>" alt="gambar ruko">
                    </div>
                    <div class="image-right">
                        <div class="image-atas">
                            <?php if ($num_rows > 1) : ?>
                                <?php $gambar = mysqli_fetch_assoc($hasil); ?>
                                <img src="images/ruko/<?php echo $gambar['gambar_properti'] ?>" alt="gambar ruko">
                            <?php else: ?>
                                <img src="images/assets/imgnotfound.jpg" alt="Image Gk Ada">
                            <?php endif; ?>
                        </div>
                        <div class="image-tengah">
                            <?php if ($num_rows > 2) : ?>
                                <?php $gambar = mysqli_fetch_assoc($hasil); ?>
                                <img src="images/ruko/<?php echo $gambar['gambar_properti'] ?>" alt="gambar ruko">
                            <?php else: ?>
                                <img src="images/assets/imgnotfound.jpg" alt="Image Gk Ada">
                            <?php endif; ?>
                        </div>
                        <div class="image-bawah">
                            <?php if ($num_rows > 3) : ?>
                                <?php $gambar = mysqli_fetch_assoc($hasil); ?>
                                <img src="images/ruko/<?php echo $gambar['gambar_properti'] ?>" alt="gambar ruko">
                            <?php else: ?>
                                <img src="images/assets/imgnotfound.jpg" alt="Image Gk Ada">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="properti-deskripsi">
                    <div class="properti-upper">
                        <div class="deskripsi-kiri">
                            <div class="rekomendasi-card-harga">
                                <!-- Harga Jual, Harga Sewa -->
                                <?php if ($ruko['harga_jual'] > 0) : ?>
                                    <div class="rekomendasi-card-harga-kiri">
                                        <!-- function format subvalue harga -->
                                        <?php echo formatPropertySalePrice($ruko['harga_jual']); ?>
                                    </div>
                                    <?php if ($ruko['harga_sewa'] > 0) : ?>
                                        <div class="rekomendasi-card-harga-kanan">
                                            <?php echo formatPropertyPrice($ruko['harga_sewa']); ?>
                                        </div>
                                    <?php endif; ?>

                                <?php elseif ($ruko['harga_sewa'] > 0) : ?>
                                    <div class="rekomendasi-card-harga-kiri">
                                        <!-- per bulan -->
                                        <?php echo formatPropertyPrice($ruko['harga_sewa']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="diterbitkan">
                                diterbitkan
                                <?php echo $ruko['tanggal'] ?>
                            </div>
                            <div class="informasi-properti">
                                <div class="title-informasi-properti">
                                    Informasi Properti
                                    <img src="images/assets/purple_star(2).png" alt="icon">
                                    <img src="images/assets/purple_star(2).png" alt="icon">
                                    <img src="images/assets/purple_star(2).png" alt="icon">
                                </div>
                                <div class="detail-container">
                                    <div class="detail-fasilitas">
                                        <div class="nama-fasilitas"> Luas Tanah </div>
                                        <div class="fasilitas-values"> :<?php echo $ruko['luas_tanah'] ?> m<sup>2</sup> </div>
                                    </div>
                                    <div class="detail-fasilitas">
                                        <div class="nama-fasilitas"> Luas Bangunan </div>
                                        <div class="fasilitas-values"> :<?php echo $ruko['luas_bangunan'] ?> m<sup>2</sup> </div>
                                    </div>
                                    <div class="detail-fasilitas">
                                        <div class="nama-fasilitas"> Kamar Tidur </div>
                                        <div class="fasilitas-values"> :<?php echo $ruko['jmlh_kmr_tdr'] ?> </div>
                                    </div>
                                    <div class="detail-fasilitas">
                                        <div class="nama-fasilitas"> Kamar Mandi </div>
                                        <div class="fasilitas-values"> :<?php echo $ruko['jmlh_kmr_mandi'] ?> </div>
                                    </div>
                                    <div class="detail-fasilitas">
                                        <div class="nama-fasilitas"> Garasi </div>
                                        <div class="fasilitas-values"> :<?php echo $ruko['jmlh_garasi'] ?> </div>
                                    </div>
                                    <div class="detail-fasilitas">
                                        <div class="nama-fasilitas"> Lantai </div>
                                        <div class="fasilitas-values"> :<?php echo $ruko['jmlh_lantai'] ?> </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="deskripsi-kanan">
                            <!-- menampilkan data pengguna -->
                            <div class="data-pengguna">
                                <div class="foto-pengguna">
                                    <img class="img-foto-pengguna" src="images/user/<?php echo $pengguna['gambar_user'] ?>" alt="">
                                </div>
                                <div class="nama-pengguna">
                                    <?php echo $pengguna['nama_pengguna'] ?>
                                </div>
                                <div class="no-telp">
                                    <?php echo $pengguna['telepon'] ?>
                                </div>
                                <div class="email">
                                    <?php echo $pengguna['email'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="properti-bottom">
                        <div class="properti-title">
                            Deskripsi
                            <img src="images/assets/purple_star(2).png" alt="icon">
                            <img src="images/assets/purple_star(2).png" alt="icon">
                            <img src="images/assets/purple_star(2).png" alt="icon">
                        </div>
                        <div class="deskripsi-main">
                            <?php echo $ruko['deskripsi'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lower-main">
                <div class="judul-rekomendasi">
                    <div class="title-rekomendasi">
                        Ruko Lainnya
                        <img src="images/assets/purple_star(2).png" alt="icon">
                        <img src="images/assets/purple_star(2).png" alt="icon">
                        <img src="images/assets/purple_star(2).png" alt="icon">
                    </div>
                </div>
                <div class="card-rekomendasi">
                    <?php
                    $query = "SELECT * FROM ruko WHERE id_ruko != $idRuko ORDER BY RAND() LIMIT 4";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sql = "SELECT gambar_properti FROM gambar_ruko WHERE id_ruko = " . $row['id_ruko'] . " LIMIT 1";
                        $gambarResult = mysqli_query($conn, $sql);
                        $gambar = mysqli_fetch_assoc($gambarResult);
                    ?>
                        <a class="main-link-card" href="detail.php?id_ruko=<?php echo $row['id_ruko']; ?>">
                            <div class="main-rekomendasi-card">
                                <div class="rekomendasi-card-image" style="background-image: url('images/ruko/<?php echo $gambar['gambar_properti']; ?>')">
                                    <!-- Jika Dijual -->
                                    <?php if ($row['harga_jual'] != 0 || $row['harga_jual'] != NULL) : ?>
                                        <div class="card-pop-jual">
                                            Dijual
                                        </div>
                                    <?php endif; ?>

                                    <!-- Jika Disewa -->
                                    <?php if ($row['harga_sewa'] != 0 || $row['harga_sewa'] != NULL) : ?>
                                        <div class="card-pop-sewa">
                                            Disewa
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="rekomendasi-card-bottom">
                                    <div class="rekomendasi-card-harga">
                                        <!-- Harga Jual, Harga Sewa -->
                                        <?php if ($row['harga_jual'] != 0 || $row['harga_jual'] != NULL) : ?>
                                            <div class="rekomendasi-card-harga-kiri-rekomendasi">
                                                <!-- function format subvalue harga -->
                                                <?php echo formatPropertySalePrice($row['harga_jual']); ?>
                                            </div>
                                            <?php if ($row['harga_sewa'] != 0 || $row['harga_sewa'] != NULL) : ?>
                                                <div class="rekomendasi-card-harga-kanan-rekomendasi">
                                                    <?php echo formatPropertyPrice($row['harga_sewa']); ?>
                                                </div>
                                            <?php endif; ?>

                                        <?php elseif ($row['harga_sewa'] != 0 || $row['harga_sewa'] != NULL) : ?>
                                            <div class="rekomendasi-card-harga-kiri-rekomendasi">
                                                <!-- per bulan -->
                                                <?php echo formatPropertyPrice($row['harga_sewa']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Deskripsi Atas -->
                                    <div class="rekomendasi-card-deskripsi-atas">
                                        <div class="rekomendasi-card-kota">
                                            <?php echo $row['kota']; ?>
                                        </div>
                                        <div class="rekomendasi-card-nama">
                                            <?php echo $row['nama_ruko']; ?>
                                        </div>
                                        <div class="rekomendasi-card-alamat">
                                            <?php echo $row['alamat']; ?>
                                        </div>
                                    </div>

                                    <!-- deskripsi bawah -->
                                    <div class="rekomendasi-card-deskripsi-bawah">
                                        <div class="rekomendasi-card-fasilitas-luas">
                                            <div class="fasilitas-luas">LT : <?php echo $ruko["luas_tanah"] ?> m2 </div>
                                            <div class="fasilitas-luas">LB : <?php echo $ruko["luas_tanah"] ?> m2</div>
                                        </div>

                                        <div class="rekomendasi-card-fasilitas-icon">
                                            <div class="fasilitas-icon">
                                                <image src="images/assets/bed_icon.png" alt="bed" style="width: 17px; height: auto;"> :
                                                    <?php echo $ruko['jmlh_kmr_tdr']; ?>
                                            </div>
                                            <div class="fasilitas-icon">
                                                <image src="images/assets/bath_icon.png" alt="bath" style="width: 20px; height: auto;"> :
                                                    <?php echo $ruko['jmlh_kmr_mandi']; ?>
                                            </div>
                                            <div class="fasilitas-icon">
                                                <image src="images/assets/garage_icon.png" alt="garage" style="width: 20px; height: auto;"> :
                                                    <?php echo $ruko['jmlh_garasi']; ?>
                                            </div>
                                            <div class="fasilitas-icon">
                                                <image src="images/assets/floor_icon.png" alt="floor" style="width: 20px; height: auto;"> :
                                                    <?php echo $ruko['jmlh_lantai']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            </div>
            </div>
        </main>
        <?php include "footer.php"; ?>

    </body>

    </html>