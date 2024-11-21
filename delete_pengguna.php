<?php
require "koneksi.php";

header('Content-Type: application/json');

if (!isset($_POST['username'])) {
    echo json_encode(['success' => false, 'message' => 'Username tidak ditemukan']);
    exit;
}

$username = mysqli_real_escape_string($conn, $_POST['username']);

$query = "DELETE FROM pengguna WHERE nama_pengguna = '$username'";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus pengguna: ' . mysqli_error($conn)]);
}

mysqli_close($conn);
?>