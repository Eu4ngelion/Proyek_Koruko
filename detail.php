<?php
    require "koneksi.php";
    if(!isset($_GET['id_ruko'])) {
        echo "script>alert('Ruko tidak ditemukan!')
        window.location.href = 'index.php';
        </script>";
        exit();
    }
    $idRuko = $_GET['id_ruko'];
    $query = "SELECT * FROM ruko WHERE id_ruko = $idRuko";
    $result = mysqli_query($conn, $query);
    $ruko = mysqli_fetch_assoc($result);

    $query = "SELECT * FROM gambar_ruko WHERE id_ruko = $idRuko";
    $result = mysqli_query($conn, $query);
    $gambar = mysqli_fetch_assoc($result);

    function formatPropertyPrice($price) {
        // Convert price to string and count digits
        $priceString = (string)$price;
        $length = strlen($priceString);
        
        // Initialize variables
        $formattedPrice = '';
        
        if ($length >= 9) { // Billion (9 digits or more)
            $value = $price / 1000000000;
            $formattedPrice = number_format($value, 1) . ' Miliar/Tahun';
        }
        else if ($length >= 7) { // Million (7-8 digits)
            $value = $price / 1000000;
            $formattedPrice = number_format($value, 1) . ' Juta/Tahun';
        }
        else if ($length >= 6) { // Hundred thousand (6 digits)
            $value = $price / 100000;
            $formattedPrice = number_format($value, 1) . ' Ratus Ribu/Tahun';
        }
        else if ($length >= 4) { // Thousand (4-5 digits)
            $value = $price / 1000;
            $formattedPrice = number_format($value, 1) . ' Ribu/Tahun';
        }
        else { // Less than 1000
            $formattedPrice = number_format($price) . '/Tahun';
        }
        
        return $formattedPrice;
    }


    function formatPropertySalePrice($price) {
        // Convert price to string and count digits
        $priceString = (string)$price;
        $length = strlen($priceString);
        
        // Initialize variables
        $formattedPrice = '';
        
        if ($length >= 9) { // Billion (9 digits or more)
            $value = $price / 1000000000;
            $formattedPrice = 'IDR ' . number_format($value, 1) . ' Miliar';
        }
        else if ($length >= 7) { // Million (7-8 digits)
            $value = $price / 1000000;
            $formattedPrice = 'IDR ' . number_format($value, 1) . ' Juta';
        }
        else if ($length >= 4) { // Thousand (4-5 digits)
            $value = $price / 1000;
            $formattedPrice = 'IDR ' . number_format($value, 1) . ' Ribu';
        }
        else { // Less than 1000
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
        body {
            font-family: "Poppins", sans-serif;
            background-color: black;

        }

        .button-back {
            margin-top: 80px;
        }

        .btn-kembali {
            background: white;
            border-radius: 10px;
        }

        .btn-kembali:hover {
            background: red;
            color: red;
        }

        .container-main {
            background: black;
        }
    </style>
</head>

<body>
    <?php
    include "navbar.php";
    ?>
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
                        <?php echo $ruko['kota']?>
                    </div>
                    <div class="header-nama">
                        <?php echo $ruko['nama_ruko']?>
                    </div>
                    <div class="header-alamat">
                        <?php echo $ruko['alamat']?>
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
                <div class="image-right">
                    <image src="<?php echo $gambar['gambar_properti']?>" alt="gambar1">
                </div>
                <div class="image-left">
                    <div class="image-atas">

                    </div>
                    <div class="iamge-tengah">

                    </div>
                    <div class="image-bawah">

                    </div>
                </div>
            </div>
            <div class="properti-deskripsi">
                <div class="properti-upper">
                    <div class="deskripsi-kiri">
                        <?php echo formatPropertySalePrice($ruko['harga_jual'])?>
                        <div class="diterbitkan">
                            diterbitkan 
                            <?php echo $ruko['tanggal']?>
                        </div>
                        <?php echo formatPropertyPrice($ruko['harga_sewa'])?> 
                        <div class="informasi-properti">
                            <div class="title-informasi-properti">
                                informasi properti


                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="deskripsi-kanan">

                    </div>
                </div>
                <div class="properti-bottom">

                </div>
            </div>
        </div>
        <div class="lower-main">
            <div class="judul-rekomendasi">

            </div>
            <div class="card-rekomendasi">

            </div>
        </div>
    </main>
</body>

</html>