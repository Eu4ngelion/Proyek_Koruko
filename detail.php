<?php
require "koneksi.php";




// Mengambil data ruko berdasarkan id
$id = $_GET['id_ruko'];
$sql = "SELECT * FROM ruko WHERE id_ruko = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$nama_ruko = $row['nama_ruko'];
$harga_jual = $row['harga_jual'];
$harga_sewa = $row['harga_sewa'];
$kota = $row['kota'];
$alamat = $row['alamat'];
$luas_bangunan = $row['luas_bangunan'];
$luas_tanah = $row['luas_tanah'];
$jmlh_kmr_tdr = $row['jmlh_kmr_tdr'];
$jmlh_kmr_mandi = $row['jmlh_kmr_mandi'];
$jmlh_lantai = $row['jmlh_lantai'];
$jmlh_garasi = $row['jmlh_garasi'];
$tanggal = $row['tanggal'];
$status = $row['status'];
$deskripsi = $row['deskripsi'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    include "navbar.php";
    ?>

    <!-- tampilkan data ruko berdasarkan sql -->
    <div class="main-index">
        <h1>Detail Ruko</h1>
        <div class="ruko-detail"></div>
        <div class="ruko-detail">
        </div>


</body>

</html