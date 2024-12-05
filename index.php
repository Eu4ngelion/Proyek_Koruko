<?php
require "koneksi.php";

// Memulai Sesion
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = false;
}

$sql_rekomendasi = "SELECT * FROM ruko WHERE status = '1' ORDER BY RAND() LIMIT 10 ";
$result = mysqli_query($conn, $sql_rekomendasi);
$ruko_rekomendasi = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql_terbaru = "SELECT * FROM ruko WHERE status = '1' ORDER BY tanggal DESC LIMIT 10";
$result = mysqli_query($conn, $sql_terbaru);
$ruko_terbaru = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql_website = "SELECT judul FROM website";
$result = mysqli_query($conn, $sql_website);
$website = mysqli_fetch_assoc($result);
$judul = $website['judul'];

// Function format subvalue
function formatSubvalue($value)
{
    $num = intval(preg_replace('/[^0-9]/', '', $value));
    if ($num >= 1000000000) {
        return number_format($num / 1000000000, 1, ',', '.') . ' miliar';
    } elseif ($num >= 1000000) {
        return number_format($num / 1000000, 1, ',', '.') . ' juta';
    } elseif ($num >= 1000) {
        return number_format($num / 1000, 0, ',', '.') . ' ribu';
    } else {
        return number_format($num, 0, ',', '.');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koruko</title>
    <link rel="icon" href="images/assets/icon_navbar.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: black;
        }

        .main-index {
            height: auto;
            min-height: 100vh;
            padding: 60px 0 50px 0;
            font-family: 'Poppins', sans-serif;
            z-index: -2;
            width: 100%;
        }

        /* Hero */
        .main-hero-image {
            height: 95vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            z-index: -1;
            filter: blur(7px) brightness(0.5);
        }

        .hero-text {
            text-align: center;
            color: white;
        }

        .main-hero-title {
            font-size: 80px;
            font-weight: bolder;
            letter-spacing: -2px;
            color: white;
        }

        .main-hero-subtitle {
            font-size: 42px;
            font-weight: bold;
            color: white;
        }

        .main-hero-search {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .main-search-lokasi,
        .main-search-tipe,
        .main-search-harga {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }

        .main-dropdown-lokasi-box,
        .main-dropdown-tipe-box,
        .main-dropdown-harga-box {
            display: none;
            flex-direction: column;
            position: absolute;
            z-index: 1;
            background-color: #ffffff;
            border: 1px solid #703BF7;
            border-radius: 10px;
            box-shadow: 0px 8px 16px 0px #703BF7;
            padding: 12px 0px;
            margin-top: 5px;
            width: auto;
            min-width: 200px;
        }

        .main-dropdown-lokasi-search {
            padding: 10px 80px 10px 10px;
            margin: 5px 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
        }

        .main-dropdown-harga-min,
        .main-dropdown-harga-max {
            padding: 10px 80px 10px 10px;
            margin: 5px 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
        }

        .main-dropdown-tipe-radio {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            padding: 10px 20px;

        }

        .main-dropdown-tipe-radio label {
            display: flex;
            margin-right: 10px;
            font-family: "Poppins", sans-serif;
            font-size: 16px;
        }

        .main-dropdown-tipe-radio input[type="radio"] {
            margin-right: 5px;
            width: 20px;
            height: 16px;
        }


        .main-lokasi-search-box,
        .main-tipe-search-box,
        .main-harga-search-box {
            background-color: white;
            color: black;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            width: 200px;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
        }

        .main-lokasi-search-category-title,
        .main-tipe-search-category-title,
        .main-harga-search-category-title {
            font-weight: bold;
        }

        .main-search-submit {
            background-color: #703BF7;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 30px;
            font-weight: bold;
            width: 180px;
            height: 100%;
        }

        .main-search-submit:hover{
            background-color: #BBA0FF;
            scale: 1.05;
            transition: all 0.5s;
        }

        .main-input-lokasi {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
        }

        .main-dropdown-lokasi-terapkan,
        .main-dropdown-tipe-terapkan,
        .main-dropdown-harga-terapkan {
            display: flex;
            width: 80%;
            justify-content: center;
            border-top: 2px solid #703BF7;
            margin: 10px auto;
            padding-top: 10px;
        }

        .main-dropdown-lokasi-terapkan-button,
        .main-dropdown-tipe-terapkan-button,
        .main-dropdown-harga-terapkan-button {
            background-color: #703BF7;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100px;
        }

        /* Section Rekomendasi & Card*/
        .main-section-rekomendasi {
            margin-top: 20px;
            padding: 20px 10%;
            font-family: "Poppins", sans-serif;
        }

        .main-rekomendasi-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .main-rekomendasi-title-left {
            font-size: 40px;
            font-weight: bold;
            align-items: center;
            color: #703BF7;
        }

        .main-rekomendasi-title-left img {
            vertical-align: middle;
        }

        .lihat-semua button {
            background-color: #703BF7;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.2s;
        }

        .lihat-semua button:hover {
            background-color: #BBA0FF;
            transition: all 0.5s;
        }

        .main-rekomendasi-content {
            display: flex;
            align-items: center;
            margin: 0 0 50px 0;
            justify-content: space-between;
            flex-wrap: wrap;
            overflow: hidden;
            height: 350px;
            padding-top: 18px;
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
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #703BF7;
            color: white;
            width: 40px;
            height: 15px;
            padding: 3px 12px;
            margin-left: 5px;
            margin-bottom: 8px;
            border-radius: 10px;
            font-family: "Poppins", sans-serif;
            font-weight: bold;
            font-size: 12px;
            box-shadow: 0px 2px px black;
        }

        .card-pop-jual {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #EFAE2D;
            color: white;
            width: 40px;
            height: 15px;
            padding: 3px 12px;
            margin-left: 5px;
            margin-bottom: 8px;
            border-radius: 10px;
            font-family: "Poppins", sans-serif;
            font-weight: bold;
            font-size: 12px;
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
            font-size: 14px;
            font-weight: bold;
            color: #703BF7;
        }

        .rekomendasi-card-harga-kanan {
            font-size: 12px;
            color: #703BF7;
        }

        .rekomendasi-card-deskripsi-atas {
            display: flex;
            margin: 10px 0 0 0;
            flex-direction: column;
            width: 100%;
        }

        .rekomendasi-card-kota {
            font-size: 16px;
            font-weight: bold;
            color: #703BF7;
            /* align kiri */
            text-align: left;
            margin: -5px 0 0 0;
        }

        .rekomendasi-card-nama {
            font-size: 20px;
            font-weight: bold;
            text-align: left;
            margin: -5px 0 0 0;
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


        /* Mengapa Koruko */
        .main-section-mengapa {
            padding: 50px 10%;
            font-family: "Poppins", sans-serif;
        }

        .main-mengapa-title {
            font-size: 40px;
            font-weight: bold;
            color: #703BF7;
            text-align: center;
            margin-bottom: 40px;
        }

        .main-mengapa-content {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
        }

        .main-mengapa-card {
            background-color: #320276;
            border-radius: 10px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 300px;
            margin: 20px;
        }

        .main-mengapa-card-title {
            font-size: 24px;
            font-weight: bold;
            color: #FECE0E;
            margin-top: 20px;
            cursor: pointer;
        }

        .main-mengapa-card-title:hover {
            transform: scale(1.05);

            transition: all 0.5s;
        }


        .main-mengapa-card-content {
            display: none;
            font-size: 16px;
            color: white;
            margin-top: 10px;
        }

        .main-mengapa-card-content-shown {
            display: block;
            font-size: 16px;
            color: white;
            margin-top: 10px;
        }

        /* Media Queries */
        @media (max-width: 900px) {

            .main-hero-image{
                height: 350px;
                width: 100%;
            }
            .hero-image{
                height: 350px;
                width: 100%;
            }

            .main-hero-search {
                flex-direction: row;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
                width: 100%;
            }

            .main-search-lokasi,
            .main-search-tipe,
            .main-search-harga{
                width: 25%;
                margin-bottom: 10px;
            }

            .main-search-lokasi{
                margin-left: 2%;
            }

            .main-search-harga{
                margin-right: 2%;
            }

            .main-lokasi-search-box,
            .main-tipe-search-box,
            .main-harga-search-box {
                width: 100%;
            }

            .main-lokasi-search-category-title,
            .main-tipe-search-category-title,
            .main-harga-search-category-title {
                font-size: 14px;
            }

            .main-lokasi-search-category-value,
            .main-tipe-search-category-value,
            .main-harga-search-category-value {
                font-size: 12px;
            }

            .main-search-submit {
                font-size: 14px;
                width: 30vh;
                margin: 0 5vh;
            }

            .main-hero-title {
                font-size: 40px;
            }

            .main-hero-subtitle {
                font-size: 24px;
            }

            .main-rekomendasi-content {
                height: 580px;
                align-items: center;
                justify-content: center;
            }

            .main-link-card{
                width: 200px;
            }

            .main-rekomendasi-card {
                width: 180px;
                height: 250px;
            }

            .rekomendasi-card-image {
                height: 200px;
            }

            .rekomendasi-card-bottom {
                padding: 10px;
            }

            .rekomendasi-card-harga-kiri,
            .rekomendasi-card-harga-kanan {
                font-size: 12px;
            }

            .rekomendasi-card-kota,
            .rekomendasi-card-nama,
            .rekomendasi-card-alamat {
                font-size: 14px;
            }

            .rekomendasi-card-fasilitas-icon {
                margin-top: 10px;
            }

            .rekomendasi-card-fasilitas-icon img {
                width: 15px;
            }

            .main-mengapa-title{
                font-size: 30px;
            }

            .main-mengapa-content {
                flex-direction: column;
                align-items: center;
            }

            .main-mengapa-card {
                width: 90%;
                margin: 10px 0;
            }

            .main-rekomendasi-title{
                flex-direction: column;
                align-items: center;
                margin-bottom: 0;
            }

            .main-rekomendasi-title-left{
                font-size: 30px;
            }

            .lihat-semua button {
                background-color: #703BF7;
                color: white;
                border: none;
                border-radius: 20px;
                cursor: pointer;
                font-size: 12px;
                font-weight: bold;
                transition: all 0.2s;
                width: 120px;
            }

            .lihat-semua button:hover {
                background-color: #BBA0FF;
                transition: all 0.5s;
            }


            .main-rekomendasi-title-left img{
                display: none;
            }
            
            .main-dropdown-lokasi-box,
            .main-dropdown-tipe-box,
            .main-dropdown-harga-box {
                width: 100%;
                min-width: 0;
                left: 0;
                right: 0;
                margin: 0 auto;
            }

            .main-dropdown-lokasi-search,
            .main-dropdown-harga-min,
            .main-dropdown-harga-max {
                width: 80%;
                padding: 10px 0 10px 5px;
                font-size: 14px;
            }

            .main-dropdown-tipe-radio {
                
                padding: 10px 5%;
            }

            .main-dropdown-tipe-radio label {
                margin-right: 5px;
            }

            .main-dropdown-lokasi-terapkan,
            .main-dropdown-tipe-terapkan,
            .main-dropdown-harga-terapkan {
                width: 90%;
                margin: 10px;
            }

            .main-dropdown-lokasi-terapkan-button,
            .main-dropdown-tipe-terapkan-button,
            .main-dropdown-harga-terapkan-button {
                width: 100%;
            }

            .main-dropdown-lokasi-terapkan-button{
                font-size: 14px;
            }

            .main-dropdown-tipe-terapkan-button{
                font-size: 14px;
            }

            .main-dropdown-harga-terapkan-button{
                font-size: 14px;
            }

            .main-lokasi-search-category-title,
            .main-tipe-search-category-title,
            .main-harga-search-category-title {
                font-size: 12px;
            }


            .main-lokasi-search-category-value,
            .main-tipe-search-category-value,
            .main-harga-search-category-value {
                font-size: 10px;
            }
        }



    </style>
</head>


<body class="body-index">
    <header><?php include "navbar.php" ?></header>

    <main class="main-index">
        <div class="main-hero-image">
            <img class="hero-image" src="images/assets/hero_bg2.png" alt="hero image">

            <div class="hero-text">
                <div class="main-hero-title">Selamat Datang di Koruko</div>
                <div class="main-hero-subtitle">Mencari Ruko Jadi Lebih Mudah</div>
            </div>

            <div class="main-hero-search">
                <!-- kategori lokasi -->
                <div class="main-search-lokasi">
                    <button type="button" class="main-lokasi-search-box">
                        <div class="main-lokasi-search-category">
                            <!-- the title of the category -->
                            <div class="main-lokasi-search-category-title">
                                Lokasi
                                <img id="lokasi-arrow" src="images/assets/dropdown_arrow_icon.png" alt="arrow down" style="width: 20px; float: right;">
                            </div>
                            <!-- the value it picked -->
                            <div id="subvalue-lokasi" class="main-lokasi-search-category-value">
                                Pilih Lokasi
                            </div>
                        </div>
                    </button>
                    <!-- drop down -->
                    <div class="main-dropdown-lokasi-box">
                        <!-- search bar lokasi-->
                        <input id="main-input-lokasi" name="lokasi" type="text" class="main-dropdown-lokasi-search" placeholder="Cari Kota atau Alamat">
                        <!-- tombol terapkan -->
                        <div class="main-dropdown-lokasi-terapkan">
                            <button type="button" id="terapkan-lokasi" class="main-dropdown-lokasi-terapkan-button">Terapkan</button>
                        </div>
                    </div>
                </div>

                <!-- kategori tipe disewa/dijual -->
                <div class="main-search-tipe">
                    <button type="button" class="main-tipe-search-box">
                        <div class="main-tipe-search-category">
                            <!-- the title of the category -->
                            <div class="main-tipe-search-category-title">
                                Tipe
                                <img id="tipe-arrow" src="images/assets/dropdown_arrow_icon.png" alt="arrow down" style="width: 20px; float: right;">
                            </div>
                            <!-- the value it picked -->
                            <div id="subvalue-tipe" class="main-tipe-search-category-value">
                                Pilih Tipe
                            </div>
                        </div>
                    </button>
                    <!-- drop down -->
                    <div class="main-dropdown-tipe-box">
                        <div class="main-dropdown-tipe">
                            <!-- hidden input -->
                            <input id="main-input-tipe" type="hidden" name="tipe" value="">

                            <!-- radio -->
                            <div class="main-dropdown-tipe-radio">
                                <label>
                                    <input type="radio" name="tipe" value="Semua"> Semua
                                </label>
                                <label>
                                    <input type="radio" name="tipe" value="Dijual"> Dijual
                                </label>
                                <label>
                                    <input type="radio" name="tipe" value="Disewa"> Disewa
                                </label>
                            </div>

                            <!-- terapkan tipe -->
                            <div class="main-dropdown-tipe-terapkan">
                                <button type="button" id="terapkan-tipe" class="main-dropdown-tipe-terapkan-button">Terapkan</button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- kategori harga -->
                <div class="main-search-harga">
                    <button type="button" class="main-harga-search-box">
                        <div class="main-harga-search-category">
                            <!-- the title of the category -->
                            <div class="main-harga-search-category-title">
                                Harga
                                <img id="harga-arrow" src="images/assets/dropdown_arrow_icon.png" alt="arrow down" style="width: 20px; float: right;">
                            </div>
                            <!-- the value it picked -->
                            <div id="subvalue-harga" class="main-harga-search-category-value">Pilih Rentang Harga</div>

                        </div>
                    </button>

                    <!-- drop down -->
                    <div class="main-dropdown-harga-box">
                        <input id="main-input-harga-min" name="harga_min" type="text" class="main-dropdown-harga-min" placeholder="Minimum">
                        <input id="main-input-harga-max" name="harga_max" type="text" class="main-dropdown-harga-max" placeholder="Maksimum">

                        <!-- terapkan harga -->
                        <div class="main-dropdown-harga-terapkan">
                            <button type="button" id="terapkan-harga" class="main-dropdown-harga-terapkan-button">Terapkan</button>
                        </div>
                    </div>
                </div>

                <!-- Submit, Pencarian -->
                <form action="pencarian.php" method="GET">
                    <!-- Hidden Form -->
                    <input id="hidden_lokasi" type="hidden" name="lokasi" value="">
                    <input id="hidden_tipe" type="hidden" name="tipe" value="">
                    <input id="hidden_min" type="hidden" name="harga_min" value="">
                    <input id="hidden_max" type="hidden" name="harga_max" value="">

                    <button class="main-search-submit" name="submit-search-block" type="submit" value="submitted">Cari</button>
                </form>
            </div>
        </div>

        <section class="main-section-rekomendasi">
            <div class="main-rekomendasi">
                <div class="main-rekomendasi-title">
                    <div class="main-rekomendasi-title-left">
                        Rekomendasi
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 25px; height: auto;">
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 20px; height: auto;">
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 15px; height: auto;">
                    </div>
                    <div class="main-rekomendasi-title-right">
                        <a class="lihat-semua" href="pencarian.php">
                            <button>
                                Lihat Semua
                            </button>
                        </a>
                    </div>
                </div>

                <div class="main-rekomendasi-content">
                    <?php foreach ($ruko_rekomendasi as $ruko) : ?>
                        <?php
                        $sql = "SELECT gambar_properti FROM gambar_ruko WHERE id_ruko = " . $ruko['id_ruko'] . " LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        $gambar = mysqli_fetch_assoc($result);
                        ?>
                        <a class="main-link-card" href="detail.php?id_ruko=<?php echo $ruko['id_ruko']; ?>">
                            <button class="main-rekomendasi-card">
                                <div class="rekomendasi-card-image" style="background-image: url('images/ruko/<?php echo $gambar['gambar_properti']; ?>')">
                                    <!-- Jika Disewa -->
                                    <?php if ($ruko['harga_sewa'] > 0) : ?>
                                        <div class="card-pop-sewa">
                                            Disewa
                                        </div>
                                    <?php endif; ?>

                                    <!-- Jika Dijual -->
                                    <?php if ($ruko['harga_jual'] > 0) : ?>
                                        <div class="card-pop-jual">
                                            Dijual
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="rekomendasi-card-bottom">
                                    <div class="rekomendasi-card-harga">
                                        <!-- Harga Jual, Harga Sewa -->
                                        <?php if ($ruko['harga_jual'] > 0) : ?>
                                            <div class="rekomendasi-card-harga-kiri">
                                                <!-- function format subvalue harga -->
                                                IDR <?php echo formatSubvalue($ruko['harga_jual']); ?>
                                            </div>
                                            <?php if ($ruko['harga_sewa'] > 0) : ?>
                                                <div class="rekomendasi-card-harga-kanan">
                                                    IDR <?php echo formatSubvalue($ruko['harga_sewa']); ?> / Tahun
                                                </div>
                                            <?php endif; ?>

                                        <?php elseif ($ruko['harga_sewa'] > 0) : ?>
                                            <div class="rekomendasi-card-harga-kiri">
                                                <!-- per bulan -->
                                                IDR <?php echo formatSubvalue($ruko['harga_sewa']); ?> / Tahun
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                    <!-- deskripsi atas -->
                                    <div class="rekomendasi-card-deskripsi-atas">
                                        <div class="rekomendasi-card-kota">
                                            <?php echo $ruko['kota']; ?>
                                        </div>
                                        <div class="rekomendasi-card-nama">
                                            <?php echo $ruko['nama_ruko']; ?>
                                        </div>
                                        <div class="rekomendasi-card-alamat">
                                            <?php echo $ruko['alamat']; ?>
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
                            </button>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Rekomendasi Ruko Baru -->
            <div class="main-rekomendasi">
                <div class="main-rekomendasi-title">
                    <div class="main-rekomendasi-title-left">
                        Ruko Baru
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 25px; height: auto;">
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 20px; height: auto;">
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 15px; height: auto;">
                    </div>

                    <div class="main-rekomendasi-title-right">
                        <a class="lihat-semua" href="pencarian.php">
                            <button>
                                Lihat Semua
                            </button>
                        </a>
                    </div>
                </div>

                <div class="main-rekomendasi-content">
                    <?php foreach ($ruko_terbaru as $ruko) : ?>
                        <?php
                        $sql = "SELECT gambar_properti FROM gambar_ruko WHERE id_ruko = " . $ruko['id_ruko'] . " LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        $gambar = mysqli_fetch_assoc($result);
                        ?>
                        <a class="main-link-card" href="detail.php?id_ruko=<?php echo $ruko['id_ruko']; ?>">
                            <button class="main-rekomendasi-card">
                                <div class="rekomendasi-card-image" style="background-image: url('images/ruko/<?php echo $gambar['gambar_properti']; ?>')">
                                    <!-- Jika Disewa -->
                                    <?php if ($ruko['harga_sewa'] > 0) : ?>
                                        <div class="card-pop-sewa">
                                            Disewa
                                        </div>
                                    <?php endif; ?>

                                    <!-- Jika Dijual -->
                                    <?php if ($ruko['harga_jual'] > 0) : ?>
                                        <div class="card-pop-jual">
                                            Dijual
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="rekomendasi-card-bottom">
                                    <div class="rekomendasi-card-harga">
                                        <!-- Harga Jual, Harga Sewa -->
                                        <?php if ($ruko['harga_jual'] > 0) : ?>
                                            <div class="rekomendasi-card-harga-kiri">
                                                <!-- function format subvalue harga -->
                                                IDR <?php echo formatSubvalue($ruko['harga_jual']); ?>
                                            </div>
                                            <?php if ($ruko['harga_sewa'] > 0) : ?>
                                                <div class="rekomendasi-card-harga-kanan">
                                                    IDR <?php echo formatSubvalue($ruko['harga_sewa']); ?>
                                                </div>
                                            <?php endif; ?>

                                        <?php elseif ($ruko['harga_sewa'] > 0) : ?>
                                            <div class="rekomendasi-card-harga-kiri">
                                                <!-- per bulan -->
                                                IDR <?php echo formatSubvalue($ruko['harga_sewa']); ?> / bulan
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Deskrpisi Atas -->
                                    <div class="rekomendasi-card-deskripsi-atas">
                                        <div class="rekomendasi-card-kota">
                                            <?php echo $ruko['kota']; ?>
                                        </div>
                                        <div class="rekomendasi-card-nama">
                                            <?php echo $ruko['nama_ruko']; ?>
                                        </div>
                                        <div class="rekomendasi-card-alamat">
                                            <?php echo $ruko['alamat']; ?>
                                        </div>
                                    </div>

                                    <!-- Deskripsi Bawah -->
                                    <div class="rekomendasi-card-deskripsi-bawah">
                                        <div class="rekomendasi-card-fasilitas-luas">
                                            <div class="fasilitas-luas">LT : <?php echo $ruko["luas_tanah"] ?> m2</div>
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
                            </button>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
        </section>

        <!-- Mengapa Koruko -->
        <section class="main-section-mengapa">
            <div class="main-mengapa">
                <div class="main-mengapa-title">
                    Mengapa <?php echo $judul?>?
                </div>
                <div class="main-mengapa-content">
                    <div class="main-mengapa-card">
                        <img src="images/assets/mengapa_icon1.png" alt="icon" style="width: 100px; height: auto;">
                        <div id="title-mengapa1" class="main-mengapa-card-title">
                            Pilihan Terbaik
                            <img src="images/assets/arrow_down_icon.png" alt="arrow down" style="width: 20px; height: auto;">
                        </div>
                        <div id="mengapa1" class="main-mengapa-card-content">
                            Kami menyediakan berbagai pilihan ruko yang sesuai dengan kebutuhan Anda, mulai dari ruko untuk disewa hingga ruko untuk dijual.
                        </div>  
                    </div>
                    <div class="main-mengapa-card">
                        <img src="images/assets/mengapa_icon2.png" alt="icon" style="width: 100px; height: auto;">
                        <div id="title-mengapa2" class="main-mengapa-card-title">
                            Informasi Lengkap
                            <img src="images/assets/arrow_down_icon.png" alt="arrow down" style="width: 20px; height: auto;">
                        </div>
                        <div id="mengapa2" class="main-mengapa-card-content">
                            Kami menyediakan detil lengkap mengenai setiap properti, termasuk spesifikasi, foto, dan rincian lokasi.
                        </div>  
                    </div>
                    <div class="main-mengapa-card">
                        <img src="images/assets/mengapa_icon3.png" alt="icon" style="width: 100px; height: auto;">
                        <div id="title-mengapa3" class="main-mengapa-card-title">
                            Sudah Terverifikasi
                            <img src="images/assets/arrow_down_icon.png" alt="arrow down" style="width: 20px; height: auto;">
                        </div>
                        <div id="mengapa3" class="main-mengapa-card-content">
                            Semua properti yang kami tampilkan sudah terverifikasi oleh tim kami, sehingga Anda tidak perlu khawatir.
                        </div>  
                    </div>

                </div>
            </div>
        </section>
    </main>

    <footer><?php include "footer.php"; ?></footer>


    <script>
        // Dropdown Lokasi
        let lokasiSearchBox = document.querySelector(".main-lokasi-search-box");
        let lokasiDropdownBox = document.querySelector(".main-dropdown-lokasi-box");
        let lokasiRekomendasi = document.querySelector(".main-dropdown-lokasi-rekomendasi");

        // Dropdown Tipe
        let tipeSearchBox = document.querySelector(".main-tipe-search-box");
        let tipeDropdownBox = document.querySelector(".main-dropdown-tipe-box");
        let tipeRekomendasi = document.querySelector(".main-dropdown-tipe-rekomendasi");
        let tipeInput = document.querySelector("#main-input-tipe");

        // Dropdown Harga
        let hargaSearchBox = document.querySelector(".main-harga-search-box");
        let hargaDropdownBox = document.querySelector(".main-dropdown-harga-box");

        // Ketika hover - unhover
        lokasiSearchBox.addEventListener("mouseover", function() {
            if (lokasiDropdownBox.style.display != "flex") {
                lokasiSearchBox.style.backgroundColor = "lightgrey";
            }
        });
        lokasiSearchBox.addEventListener("mouseout", function() {
            if (lokasiDropdownBox.style.display != "flex") {
                lokasiSearchBox.style.backgroundColor = "white";
            }
        });

        tipeSearchBox.addEventListener("mouseover", function() {
            if (tipeDropdownBox.style.display != "flex") {
                tipeSearchBox.style.backgroundColor = "lightgrey";
            }
        });
        tipeSearchBox.addEventListener("mouseout", function() {
            if (tipeDropdownBox.style.display != "flex") {
                tipeSearchBox.style.backgroundColor = "white";
            }
        });

        hargaSearchBox.addEventListener("mouseover", function() {
            if (hargaDropdownBox.style.display != "flex") {
                hargaSearchBox.style.backgroundColor = "lightgrey";
            }
        });
        hargaSearchBox.addEventListener("mouseout", function() {
            if (hargaDropdownBox.style.display != "flex") {
                hargaSearchBox.style.backgroundColor = "white";
            }
        });


        // Ketika diklik display dropdown
        lokasiSearchBox.addEventListener("click", function() {
            lokasiDropdownBox.style.display = "flex";
            // main lokasi search box clicked berubah warna ungu yang cocok
            lokasiSearchBox.style.backgroundColor = "#703BF7";
            // rotate arrow
            document.getElementById("lokasi-arrow").style.transform = "rotate(180deg)";

        });
        tipeSearchBox.addEventListener("click", function() {
            tipeDropdownBox.style.display = "flex";
            tipeSearchBox.style.backgroundColor = "#703BF7";
            // rotate arrow
            document.getElementById("tipe-arrow").style.transform = "rotate(180deg)";
        });
        hargaSearchBox.addEventListener("click", function() {
            hargaDropdownBox.style.display = "flex";
            hargaSearchBox.style.backgroundColor = "#703BF7";
            // rotate arrow
            document.getElementById("harga-arrow").style.transform = "rotate(180deg)";
        });


        // Ketika diklik di luar dropdown
        window.addEventListener("click", function(e) {
            if (!lokasiSearchBox.contains(e.target) && !lokasiDropdownBox.contains(e.target)) {
                lokasiDropdownBox.style.display = "none";
                lokasiSearchBox.style.backgroundColor = "white";
                // reset arrow
                document.getElementById("lokasi-arrow").style.transform = "rotate(0deg)";
            }
            if (!tipeSearchBox.contains(e.target) && !tipeDropdownBox.contains(e.target)) {
                tipeDropdownBox.style.display = "none";
                tipeSearchBox.style.backgroundColor = "white";
                // reset arrow
                document.getElementById("tipe-arrow").style.transform = "rotate(0deg)";
            }
            if (!hargaSearchBox.contains(e.target) && !hargaDropdownBox.contains(e.target)) {
                hargaDropdownBox.style.display = "none";
                hargaSearchBox.style.backgroundColor = "white";
                // reset arrow
                document.getElementById("harga-arrow").style.transform = "rotate(0deg)";
            }
        });

        // Ketika diklik terapkan update subvalue kategori
        let subvalueLokasi = document.querySelector("#subvalue-lokasi");
        let subvalueTipe = document.querySelector("#subvalue-tipe");
        let subvalueHarga = document.querySelector("#subvalue-harga");

        let terapkanLokasi = document.querySelector("#terapkan-lokasi");
        let terapkanTipe = document.querySelector("#terapkan-tipe");
        let terapkanHarga = document.querySelector("#terapkan-harga");

        let hiddenLokasi = document.querySelector("#hidden_lokasi");
        let hiddenTipe = document.querySelector("#hidden_tipe");
        let hiddenMin = document.querySelector("#hidden_min");
        let hiddenMax = document.querySelector("#hidden_max");


        terapkanLokasi.addEventListener("click", function() {
            let inputLokasi = document.querySelector("#main-input-lokasi").value;

            if (inputLokasi != "") {
                subvalueLokasi.innerHTML = inputLokasi;
                lokasiDropdownBox.style.display = "none";
            } else {
                subvalueLokasi.innerHTML = "Pilih Lokasi";
                lokasiDropdownBox.style.display = "none";
            }
            lokasiSearchBox.style.backgroundColor = "white";


            hiddenLokasi.value = inputLokasi;

        });

        terapkanTipe.addEventListener("click", function() {
            let inputTipe = document.querySelector('input[name="tipe"]:checked').value;
            subvalueTipe.innerHTML = inputTipe;
            tipeDropdownBox.style.display = "none";

            hiddenTipe.value = inputTipe;
        });

        // Ketika diklik terapkan update hidden input
        let terapkanLokasiHidden = document.querySelector("#terapkan-lokasi");
        let terapkanTipeHidden = document.querySelector("#terapkan-tipe");
        let terapkanHargaHidden = document.querySelector("#terapkan-harga");

        terapkanLokasiHidden.addEventListener("click", function() {
            let inputLokasi = document.querySelector("#main-input-lokasi").value;
            document.querySelector('input[name="lokasi"]').value = inputLokasi;
        });

        terapkanTipeHidden.addEventListener("click", function() {
            let inputTipe = document.querySelector('input[name="tipe"]:checked').value;
            document.querySelector('input[name="tipe"]').value = inputTipe;
        });

        // Harga
        terapkanHargaHidden.addEventListener("click", function() {
            let inputHargaMin = document.querySelector("#main-input-harga-min").value;
            let inputHargaMax = document.querySelector("#main-input-harga-max").value;
            document.querySelector('input[name="harga_min"]').value = inputHargaMin;
            document.querySelector('input[name="harga_max"]').value = inputHargaMax;
        });

        // Harga Min > Max dan sebaliknya
        let inputHargaMin = document.querySelector("#main-input-harga-min");
        let inputHargaMax = document.querySelector("#main-input-harga-max");

        inputHargaMin.addEventListener("input", function() {
            // jika max masih kosong, isi dengan min
            if (inputHargaMax.value == "") {
                inputHargaMax.value = inputHargaMin.value;
            }
            if (parseInt(inputHargaMin.value.replace(/[^0-9]/g, '')) > parseInt(inputHargaMax.value.replace(/[^0-9]/g, ''))) {
                inputHargaMax.value = inputHargaMin.value;
            }
        });

        inputHargaMax.addEventListener("input", function() {
            // jika min masih kosong, isi dengan 0
            if (inputHargaMin.value == "") {
                inputHargaMin.value = "0";
            }


            if (parseInt(inputHargaMax.value.replace(/[^0-9]/g, '')) < parseInt(inputHargaMin.value.replace(/[^0-9]/g, ''))) {
                inputHargaMin.value = inputHargaMax.value;
            }
        });


        // Format subvalue harga ribu, juta, m, dst ketika
        terapkanHarga.addEventListener("click", function() {
            let inputHargaMinValue = formatSubvalueHarga(inputHargaMin.value);
            let inputHargaMaxValue = formatSubvalueHarga(inputHargaMax.value);
            if (inputHargaMin.value == "" || inputHargaMax.value == "") {
                subvalueHarga.innerHTML = "Pilih Rentang Harga"
            } else {
                subvalueHarga.innerHTML = "IDR " + inputHargaMinValue + " - IDR " + inputHargaMaxValue;
                hiddenMin.value = inputHargaMin.value;
                hiddenMax.value = inputHargaMax.value;
            }
        });

        function formatSubvalueHarga(value) {
            let num = parseInt(value.replace(/[^0-9]/g, ''));
            if (num >= 1000000000) {
                return (num / 1000000000).toFixed(1) + ' miliar';
            } else if (num >= 1000000) {
                return (num / 1000000).toFixed(1) + ' juta';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(1) + ' ribu';
            } else {
                return num;
            }
        }

        // Mengapa Koruko
        let mengapa1 = document.querySelector("#mengapa1");
        let mengapa2 = document.querySelector("#mengapa2");
        let mengapa3 = document.querySelector("#mengapa3");

        let mainMengapaCard1 = document.querySelector("#title-mengapa1");
        let mainMengapaCard2 = document.querySelector("#title-mengapa2");
        let mainMengapaCard3 = document.querySelector("#title-mengapa3");

        let arrow1 = mainMengapaCard1.querySelector("img");
        let arrow2 = mainMengapaCard2.querySelector("img");
        let arrow3 = mainMengapaCard3.querySelector("img");

        mainMengapaCard1.addEventListener("click", function() {
            mengapa1.classList.toggle("main-mengapa-card-content-shown");
            arrow1.style.transform = arrow1.style.transform === "rotate(180deg)" ? "rotate(0deg)" : "rotate(180deg)";
        });

        mainMengapaCard2.addEventListener("click", function() {
            mengapa2.classList.toggle("main-mengapa-card-content-shown");
            arrow2.style.transform = arrow2.style.transform === "rotate(180deg)" ? "rotate(0deg)" : "rotate(180deg)";
        });

        mainMengapaCard3.addEventListener("click", function() {
            mengapa3.classList.toggle("main-mengapa-card-content-shown");
            arrow3.style.transform = arrow3.style.transform === "rotate(180deg)" ? "rotate(0deg)" : "rotate(180deg)";
        });
        
        

    </script>
</body>


</html>