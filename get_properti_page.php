<?php
require "koneksi.php";

$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$baris_per_halaman = 10;
$offset = ($halaman - 1) * $baris_per_halaman;

$query = "SELECT * FROM ruko ORDER BY id_ruko DESC LIMIT $baris_per_halaman OFFSET $offset";
$result = mysqli_query($conn, $query);

$properti = [];
while($row = mysqli_fetch_assoc($result)) {
    $properti[] = $row;
}

$query_total = "SELECT COUNT(*) as total FROM ruko";
$total_result = mysqli_query($conn, $query_total);
$total_data = mysqli_fetch_assoc($total_result)['total'];
$total_halaman = ceil($total_data / $baris_per_halaman);

echo json_encode([
    'properti' => $properti,
    'halaman_sekarang' => $halaman,
    'total_halaman' => $total_halaman
]);