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
$idRuko = $_GET['id_ruko'];
$query = "SELECT * FROM ruko WHERE id_ruko = $idRuko";
$result = mysqli_query($conn, $query);
$ruko = mysqli_fetch_assoc($result);

$query_gambar = "SELECT * FROM gambar_ruko WHERE id_ruko = $idRuko";
$hasil = mysqli_query($conn, $query_gambar);
$num_rows = mysqli_num_rows($hasil);
$gambar = mysqli_fetch_assoc($hasil);

// mengambil data pengguna dari table pengguna
$query = "SELECT * FROM pengguna WHERE nama_pengguna = '{$ruko['nama_pengguna']}'";
$result = mysqli_query($conn, $query);
$pengguna = mysqli_fetch_assoc($result);

function formatPropertyPrice($price)
{
    // Convert price to string and count digits
    $priceString = (string)$price;
    $length = strlen($priceString);

    // Initialize variables
    $formattedPrice = '';

    if ($length >= 9) { // Billion (9 digits or more)
        $value = $price / 1000000000;
        $formattedPrice = number_format($value, 1) . ' Miliar/Tahun';
    } else if ($length >= 7) { // Million (7-8 digits)
        $value = $price / 1000000;
        $formattedPrice = number_format($value, 1) . ' Juta/Tahun';
    } else if ($length >= 6) { // Hundred thousand (6 digits)
        $value = $price / 100000;
        $formattedPrice = number_format($value, 1) . ' Ratus Ribu/Tahun';
    } else if ($length >= 4) { // Thousand (4-5 digits)
        $value = $price / 1000;
        $formattedPrice = number_format($value, 1) . ' Ribu/Tahun';
    } else { // Less than 1000
        $formattedPrice = number_format($price) . '/Tahun';
    }

    return $formattedPrice;
}


function formatPropertySalePrice($price)
{
    // Convert price to string and count digits
    $priceString = (string)$price;
    $length = strlen($priceString);

    // Initialize variables
    $formattedPrice = '';

    if ($length >= 9) { // Billion (9 digits or more)
        $value = $price / 1000000000;
        $formattedPrice = 'IDR ' . number_format($value, 1) . ' Miliar';
    } else if ($length >= 7) { // Million (7-8 digits)
        $value = $price / 1000000;
        $formattedPrice = 'IDR ' . number_format($value, 1) . ' Juta';
    } else if ($length >= 4) { // Thousand (4-5 digits)
        $value = $price / 1000;
        $formattedPrice = 'IDR ' . number_format($value, 1) . ' Ribu';
    } else { // Less than 1000
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Reset dan Global styles */
        body {
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0F0F0F;
            color: white;
        }

        .container-main {
            padding: 20px 40px;
            margin: 0 7%;
        }

        /* Button Kembali */
        .button-back {
            margin: 10px 0 20px;
        }

        .btn-kembali {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            padding: 8px 24px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
        }

        .btn-kembali:hover {
            background: red;
        }

        /* Header Section */
        .upper-main {
            max-width: 100%;
        }

        .header-detail {
            display: flex;
            justify-content: space-between;
            align-items: end;
            margin-bottom: 24px;
            margin-top: 70px;
        }

        .header-kota {
            color: #8B5CF6;
            font-size: 36px;
            font-weight: 800;
        }

        .header-nama {
            font-size: 36px;
            font-weight: 600;
            color: white;
        }

        .header-alamat {
            font-size: 16px;
            color: #9CA3AF;
        }

        .header-right {
            display: flex;
            align-items: center;
            height: 100%;
        }

        .button-sewa-jual {
            display: flex;
            gap: 12px;
        }

        .btn-sewa {
            background: #8B5CF6;
            color: white;
            padding: 10px 28px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            font-size: 15px;
            cursor: pointer;
        }

        .btn-jual {
            background: #F59E0B;
            color: white;
            padding: 10px 28px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            font-size: 15px;
            cursor: pointer;
        }

        /* Image Gallery */
        .image-content {
            width: 100%;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .image-left {
            display: flex;
            flex: 2;
            flex-direction: column;
        }

        .image-left img {
            height: 500px;
            object-fit: cover;
            border-radius: 16px;
        }

        .image-right {
            display: flex;
            flex: 1;
            flex-direction: column;
        }

        .image-right>div {
            height: 160px;
            border-radius: 16px;
            overflow: hidden;
            background: #1F1F1F;
            position: relative;
            margin: 0 0 10px 0;
        }

        .image-right>div img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .image-right>div:last-child {
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
            background: rgba(31, 31, 31, 0.8);
            font-size: 16px;
        }

        /* Property Info */
        .properti-deskripsi {
            display: flex;
            flex-direction: column;
            align-items: start;
        }

        .properti-upper {
            width: 100%;
            display: flex;
            gap: 20px;
        }


        .deskripsi-kiri {
            flex: 2;
            object-fit: cover;
        }

        .deskripsi-kanan {
            flex: 1;
            object-fit: cover;
        }

        .diterbitkan {
            font-size: 13px;
            color: #9CA3AF;
            margin-bottom: 10px;
            border-bottom: 1px solid #fff;
            padding-bottom: 10px;
        }

        /* Property Info Section */
        .informasi-properti {
            margin-top: 15px;
            border-bottom: 1px solid #fff;
        }

        .title-informasi-properti {
            font-size: 27px;
            font-weight: 600;
            color: #8B5CF6;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .title-informasi-properti img:nth-child(1) {
            width: 24px;
            height: 24px;
        }

        .title-informasi-properti img:nth-child(2) {
            width: 20px;
            height: 20px;
        }

        .title-informasi-properti img:nth-child(3) {
            width: 16px;
            height: 16px;
        }

        .detail-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .detail-fasilitas {
            display: grid;
            grid-template-columns: 140px 1fr;
            padding: 12px 0;
            font-size: 15px;
        }

        .nama-fasilitas {
            color: white;
            width: 150px;
            font-size: 15px;
            font-weight: bold;

        }

        .fasilitas-value {
            color: black;
            font-size: 14px;
            font-weight: bold;
            padding-left: 5px;
            padding-right: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Description Section */
        .properti-bottom {
            margin-top: 15px;
            width: 100%;
        }

        .properti-title {
            font-size: 27px;
            font-weight: 600;
            color: #8B5CF6;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .properti-title img:nth-child(1) {
            width: 24px;
            height: 24px;
        }

        .properti-title img:nth-child(2) {
            width: 20px;
            height: 20px;
        }

        .properti-title img:nth-child(3) {
            width: 16px;
            height: 16px;
        }

        .deskripsi-main {
            color: #fff;
            line-height: 1.8;
            font-size: 20px;
            margin-bottom: 50px;
            font: 600;
        }

        /* User Card */
        .data-pengguna {
            background: #8B5CF6;
            border-radius: 16px;
            padding: 30px 24px;
            text-align: center;
            height: 83%;
        }

        .foto-pengguna {
            display: flex;
            width: 100px;
            height: 100px;
            margin: 0 auto 16px auto;
            background-color: white;
            border-radius: 100%;
            align-items: center;
        }

        .foto-pengguna img {
            width: 100px;
            height: 100px;
            border-radius: 100%;
            background-color: white;
            background-image: url(images/assets/default_user.png);
            background-size: 90%;
            background-position: center;
        }

        .nama-pengguna {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .no-telp,
        .email {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 6px;
        }

        .data-pengguna button {
            background: white;
            color: #8B5CF6;
            border: none;
            width: 100%;
            padding: 12px 0;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            margin-top: 20px;
            cursor: pointer;
        }

        /* Price Displays */
        .harga-jual {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .harga-sewa {
            font-size: 24px;
            font-weight: 500;
            color: #8B5CF6;
            margin-top: 16px;
        }

        .title-rekomendasi {
            font-size: 27px;
            font-weight: 600;
            color: #8B5CF6;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .title-rekomendasi img:nth-child(1) {
            width: 24px;
            height: 24px;
        }

        .title-rekomendasi img:nth-child(2) {
            width: 20px;
            height: 20px;
        }

        .title-rekomendasi img:nth-child(3) {
            width: 16px;
            height: 16px;
        }

        .main-rekomendasi-card {
            display: flex;
            background-color: white;
            flex-direction: column;
            align-items: center;
            margin: 20px 10px;
            padding: 0;
            border-radius: 10px;
            width: 275px;
            height: 315px;
            cursor: pointer;
            transition: all 0.1s;
        }

        .main-rekomendasi-card:hover {
            box-shadow: 0px 0px 30px #703BF7;
            transform: translateY(-20px);
            transition: all 0.3s;
        }

        .rekomendasi-card-image {
            display: flex;
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 150px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            align-items: flex-end;
        }

        .card-pop-sewa {
            background-color: #703BF7;
            color: white;
            width: 50px;
            height: 20px;
            padding: 3px 12px;
            margin-left: 5px;
            margin-bottom: 5px;
            border-radius: 10px;
            font-family: "Poppins", sans-serif;
            font-weight: bold;
            font-size: 12px;
            box-shadow: 0px 2px 4px black;
        }

        .card-pop-jual {
            background-color: #EFAE2D;
            color: white;
            width: 50px;
            height: 20px;
            padding: 3px 12px;
            margin-left: 5px;
            margin-bottom: 5px;
            border-radius: 10px;
            font-family: "Poppins", sans-serif;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0px 2px 4px black;
        }

        .rekomendasi-card-bottom {
            display: flex;
            flex-direction: column;
            width: 95%;
            padding: 1px 0 0 0;
        }

        .rekomendasi-card-harga {
            display: flex;
            width: 100%;
            justify-content: space-between;
        }

        .rekomendasi-card-harga-kiri {
            font-size: 36px;
            font-weight: bold;
            color: white;
        }

        .rekomendasi-card-harga-kanan {
            font-size: 36px;
            color: white;
            font-weight: bold;
        }

        .rekomendasi-card-harga-kiri-rekomendasi {
            font-size: 14px;
            font-weight: bold;
            color: #703BF7;
        }

        .rekomendasi-card-harga-kanan-rekomendasi {
            font-size: 14px;
            color: #703BF7;
            font-weight: bold;
        }

        .rekomendasi-card-deskripsi-atas {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .rekomendasi-card-kota {
            font-size: 16px;
            font-weight: bold;
            color: #703BF7;
            /* align kiri */
            text-align: left;
        }

        .rekomendasi-card-nama {
            font-size: 20px;
            font-weight: bold;
            text-align: left;
            margin: 0px 0px 5px 0px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rekomendasi-card-alamat {
            font-size: 12px;
            font-weight: bold;
            text-align: left;
            margin: -5px 0 0 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rekomendasi-card-deskripsi-bawah {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            width: 100%;
            border-top: 1px solid black;
        }

        .rekomendasi-card-fasilitas {
            display: flex;
            flex-direction: row;
            color: black;
        }

        .fasilitas-title {
            font-size: 14px;
            font-weight: bold;
            width: 60px;
            text-align: left;
            color: black;
        }

        .fasilitas-title-luas {
            font-size: 14px;
            font-weight: bold;
            width: 28px;
            text-align: left;
            margin: 0;
        }

        .card-rekomendasi {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-direction: row;
        }

        .rekomendasi-card-deskripsi-bawah {
            display: flex;
            flex-direction: column;
            width: 100%;
            margin-top: 10px;
            border-top: 1px solid black;
        }

        .rekomendasi-card-fasilitas-luas {
            display: flex;
            flex-direction: row;
        }

        .fasilitas-luas {
            font-size: 12px;
            font-weight: bold;
            width: auto;
            text-align: left;
            margin: 0 10px 0 0;
        }

        .rekomendasi-card-fasilitas-icon {
            display: flex;
            flex-direction: row;
            margin-top: 5px;
        }

        .fasilitas-icon {
            font-size: 12px;
            font-weight: bold;
            width: 50px;
            text-align: left;
        }

        .rekomendasi-card-fasilitas {
            display: flex;
            flex-direction: row;
        }

        .fasilitas-title {
            font-size: 12px;
            font-weight: bold;
            width: 60px;
            text-align: left;
        }

        .fasilitas-title-luas {
            font-size: 12px;
            font-weight: bold;
            width: 25px;
            text-align: left;
        }

        .fasilitas-value {
            font-size: 14px;
            font-weight: bold;
            padding-left: 5px;
            padding-right: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .main-link-card {
            display: block;
            margin: 0;
            width: 290px;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .container-main {
            padding: 10px 20px;
            margin: 0 5%;
            }

            .header-detail {
            flex-direction: column;
            align-items: flex-start;
            }

            .header-kota {
            font-size: 20px;
            }

            .header-nama {
            font-size: 28px;
            }

            .header-alamat {
            font-size: 14px;
            }

            .button-sewa-jual {
            margin-top: 10px;
            }

            .image-content {
            flex-direction: column;
            }

            .image-left img {
            height: auto;
            width: 100%;
            }

            .image-right {
            flex-direction: row;
            flex-wrap: wrap;
            gap: 10px;
            }

            .image-right>div {
            height: auto;
            width: 48%;
            margin-bottom: 10px;
            }

            .properti-upper {
            flex-direction: column;
            }

            .deskripsi-kiri,
            .deskripsi-kanan {
            width: 100%;
            }

            .data-pengguna {
            height: auto;
            }

            .rekomendasi-card-bottom {
            padding: 10px;
            }

            .rekomendasi-card-harga-kiri-rekomendasi,
            .rekomendasi-card-harga-kanan-rekomendasi {
            font-size: 18px;
            }

            .rekomendasi-card-kota,
            .rekomendasi-card-nama,
            .rekomendasi-card-alamat {
            font-size: 14px;
            }

            .rekomendasi-card-fasilitas-icon {
            flex-direction: column;
            }

            .fasilitas-icon {
            font-size: 12px;
            }

            .card-rekomendasi {
            overflow-x: scroll;
            display: flex;
            flex-wrap: nowrap;
            gap: 10px;
            }

            .main-rekomendasi-card {
            flex: 0 0 auto;
            width: 80%;
            }
        }
    </style>
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
                        <button class="btn btn-sewa">Sewa</button>
                        <button class="btn btn-jual">Jual</button>
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
                            <?php if ($ruko['harga_jual'] != 0 || $ruko['harga_jual'] != NULL) : ?>
                                <div class="rekomendasi-card-harga-kiri">
                                    <!-- function format subvalue harga -->
                                    <?php echo formatPropertySalePrice($ruko['harga_jual']); ?>
                                </div>
                                <?php if ($ruko['harga_sewa'] != 0 || $ruko['harga_sewa'] != NULL) : ?>
                                    <div class="rekomendasi-card-harga-kanan">
                                        <?php echo formatPropertyPrice($ruko['harga_sewa']); ?>
                                    </div>
                                <?php endif; ?>

                            <?php elseif ($ruko['harga_sewa'] != 0 || $ruko['harga_sewa'] != NULL) : ?>
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