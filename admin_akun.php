<?php
require "koneksi.php";
// Pagination setup
$halaman_sekarang = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$baris_per_halaman = 10;
$offset = ($halaman_sekarang - 1) * $baris_per_halaman;
// Query untuk mendapatkan total data
$query_total = "SELECT COUNT(*) as total FROM pengguna";
$total_result = mysqli_query($conn, $query_total);
$total_data = mysqli_fetch_assoc($total_result)['total'];
$total_halaman = ceil($total_data / $baris_per_halaman);
// Query statistik
$query_stats = "SELECT COUNT(*) as jumlah_pengguna FROM pengguna";
$stats_result = mysqli_query($conn, $query_stats);
$stats = mysqli_fetch_assoc($stats_result);
// Query untuk mendapatkan data dengan pagination
$query_pengguna = "SELECT * FROM pengguna ORDER BY nama_pengguna LIMIT $baris_per_halaman OFFSET $offset";
$pengguna_result = mysqli_query($conn, $query_pengguna);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pengguna - Koruko</title>
    <link rel="stylesheet" href="styles/admin_akun.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <main class="main-content">
        <h1>Lihat Akun</h1>

        <!-- Statistics -->
        <section class="statistics">
            <div class="stat-card">
                <div class="stat-label">Jumlah Akun</div>
                <div class="stat-value"><?php echo $stats['jumlah_pengguna']; ?></div>
            </div>
        </section>

        <!-- Search -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Cari...">
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>

         <!-- Users Table -->
         <div class="table-container">
            <table id="penggunaTable">
                <thead>
                    <tr>
                        <th>ID Akun</th>
                        <th>Nama Lengkap</th>
                        <th>Nama Pengguna</th>
                        <th>No. Telp</th>
                        <th>Jumlah Ruko</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1 + (($halaman_sekarang - 1) * $baris_per_halaman);
                    while ($row = mysqli_fetch_assoc($pengguna_result)) {
                        $query_ruko = "SELECT COUNT(*) as ruko_count FROM ruko WHERE nama_pengguna = '" . $row['nama_pengguna'] . "'";
                        $ruko_result = mysqli_query($conn, $query_ruko);
                        $ruko_count = mysqli_fetch_assoc($ruko_result)['ruko_count'];
                    ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo $row['nama_lengkap']; ?></td>
                            <td><?php echo $row['nama_pengguna']; ?></td>
                            <td><?php echo $row['telepon']; ?></td>
                            <td><?php echo $ruko_count; ?></td>
                            <td>
                                <button class="btn-hapus" onclick="deleteUser('<?php echo $row['nama_pengguna']; ?>')">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

       <!-- Pagination -->
       <div class="pagination">
            <button>&lt;</button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <button>999</button>
            <button>&gt;</button>
        </div>
    </main>
    
    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script src="scripts/admin_akun.js"></script>
</body>

</html>