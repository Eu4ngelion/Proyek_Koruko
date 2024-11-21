<?php
require "koneksi.php";

// Pagination setup
$halaman_sekarang = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$baris_per_halaman = 10;
$offset = ($halaman_sekarang - 1) * $baris_per_halaman;

// Query untuk mendapatkan total data
$query_total = "SELECT COUNT(*) as total FROM ruko";
$total_result = mysqli_query($conn, $query_total);
$total_data = mysqli_fetch_assoc($total_result)['total'];
$total_halaman = ceil($total_data / $baris_per_halaman);

$query_stats = "SELECT 
    COUNT(*) as jumlah_ruko,
    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as disewakan,
    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as dijual,
    SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as belum_verifikasi,
    SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as terjual
FROM ruko";
$stats_result = mysqli_query($conn, $query_stats);
$stats = mysqli_fetch_assoc($stats_result);

// Query untuk mendapatkan data dengan pagination
$query_ruko = "SELECT * FROM ruko ORDER BY id_ruko DESC LIMIT $baris_per_halaman OFFSET $offset";
$ruko_result = mysqli_query($conn, $query_ruko);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Properti - Koruko</title>
    <link rel="stylesheet" href="styles/admin_properti.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <h1>Admin Properti</h1>
    <main class="main-content">
        <h1>Lihat Properti</h1>

        <!-- Statistics -->
        <section class="statistics">
            <h2>Statistik</h2>
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-label">Jumlah Ruko</div>
                    <div class="stat-value"><?php echo $stats['jumlah_ruko']; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Disewakan</div>
                    <div class="stat-value"><?php echo $stats['disewakan']; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Dijual</div>
                    <div class="stat-value"><?php echo $stats['dijual']; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Belum Diverifikasi</div>
                    <div class="stat-value"><?php echo $stats['belum_verifikasi']; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Terjual</div>
                    <div class="stat-value"><?php echo $stats['terjual']; ?></div>
                </div>
            </div>
        </section>

        <!-- Search -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Cari...">
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <!-- Properties Table -->
        <div class="table-container">
            <table id="propertiTable">
                <thead>
                    <tr>
                        <th>ID Ruko</th>
                        <th>Nama Ruko</th>
                        <th>Kota</th>
                        <th>Alamat</th>
                        <th>Harga Jual (Harga Sewa)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($ruko_result)) { ?>
                        <tr>
                            <td><?php echo $row['id_ruko']; ?></td>
                            <td><?php echo $row['nama_ruko']; ?></td>
                            <td><?php echo $row['kota']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td>
                                <?php if ($row['harga_jual']) { ?>
                                    Rp <?php echo number_format($row['harga_jual'], 0, ',', '.'); ?>
                                <?php } ?>
                                <?php if ($row['harga_sewa']) { ?>
                                    <?php echo $row['harga_jual'] ? '<br>' : ''; ?>
                                    (<?php echo number_format($row['harga_sewa'], 0, ',', '.'); ?> juta/tahun)
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                switch ($row['status']) {
                                    case -1:
                                        echo '<span class="status ditolak">Ditolak</span>';
                                        break;
                                    case 0:
                                        echo '<span class="status pending">Belum Diverifikasi</span>';
                                        break;
                                    case 1:
                                        if ($row['harga_sewa'] && $row['harga_jual']) {
                                            echo '<span class="status active">Dijual + Disewa</span>';
                                        } elseif ($row['harga_sewa']) {
                                            echo '<span class="status active">Disewa</span>';
                                        } else {
                                            echo '<span class="status active">Dijual</span>';
                                        }
                                        break;
                                    case 2:
                                        echo '<span class="status sold">Terjual</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td class="action-buttons">
                                <?php if ($row['status'] == 0) { ?>
                                    <a href = "admin_verif.php?id_ruko=<?php echo $row['id_ruko']; ?>">
                                    <button class="btn-verifikasi">
                                        Verifikasi
                                    </button>
                                    </a>
                                <?php } ?>
                                    
                                <button class="btn-hapus" onclick="deleteProperty(<?php echo $row['id_ruko']; ?>)">
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

    <?php include 'footer.php'; ?>

    <script src="scripts/admin_properti.js"></script>
</body>

</html>