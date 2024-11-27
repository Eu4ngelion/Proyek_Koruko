<?php
require "koneksi.php";

// Pagination and Search Setup
$itemsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Sanitize search term
$searchTerm = isset($_GET['search']) ? trim($conn->real_escape_string($_GET['search'])) : '';

// Build base query
$baseQuery = "FROM ruko WHERE 1=1";
if (!empty($searchTerm)) {
    $baseQuery .= " AND (
        nama_ruko LIKE '%$searchTerm%' OR 
        kota LIKE '%$searchTerm%' OR 
        alamat LIKE '%$searchTerm%'
    )";
}

// Count total items
$countQuery = "SELECT COUNT(*) AS total $baseQuery";
$countResult = $conn->query($countQuery);
$totalItems = $countResult->fetch_assoc()['total'];

// Calculate pagination
$totalPages = ceil($totalItems / $itemsPerPage);
$offset = ($page - 1) * $itemsPerPage;

// Query for stats (modify to consider search results)
$query_stats = "SELECT 
    COUNT(*) as jumlah_ruko,
    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as disewakan,
    SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as dijual,
    SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as belum_verifikasi,
    SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as terjual
$baseQuery";
$stats_result = $conn->query($query_stats);
$stats = $stats_result->fetch_assoc();

// Fetch paginated data
$query_ruko = "SELECT * $baseQuery ORDER BY id_ruko DESC LIMIT $offset, $itemsPerPage";
$ruko_result = $conn->query($query_ruko);
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
   <header> <?php include "navbar.php"; ?>
</header>
    <h1>Admin Properti</h1>
    <main class="main-content">
        <h1>Lihat Properti</h1>

       <!-- Statistics -->
<section class="statistics">
    <h2>Statistik</h2>
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-label">Jumlah Ruko</div>
            <div class="stat-value">
                <?php echo $stats['jumlah_ruko']; ?>
                <img src="images/ruko.png" alt="Ruko Icon" class="stat-icon">
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Disewakan</div>
            <div class="stat-value">
                <?php echo $stats['disewakan']; ?>
                <img src="images/disewakan.png" alt="Disewakan Icon" class="stat-icon">
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Dijual</div>
            <div class="stat-value">
                <?php echo $stats['dijual']; ?>
                <img src="images/dijual.png" alt="Dijual Icon" class="stat-icon">
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Belum Diverifikasi</div>
            <div class="stat-value">
                <?php echo $stats['belum_verifikasi']; ?>
                <img src="images/pending.png" alt="Pending Icon" class="stat-icon">
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Terjual</div>
            <div class="stat-value">
                <?php echo $stats['terjual']; ?>
                <img src="images/terjual.png" alt="Terjual Icon" class="stat-icon">
            </div>
        </div>
    </div>
</section>
        <!-- Search -->
        <div class="search-container">
            <form action="" method="GET">
                <input 
                    type="text" 
                    name="search" 
                    class="search-input" 
                    placeholder="Cari..." 
                    value="<?php echo htmlspecialchars($searchTerm); ?>"
                >
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Properties Table -->
        <div class="table-container">
            <?php if ($ruko_result->num_rows > 0): ?>
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
                        <?php while ($row = $ruko_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_ruko']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_ruko']); ?></td>
                                <td><?php echo htmlspecialchars($row['kota']); ?></td>
                                <td><?php echo htmlspecialchars($row['alamat']); ?></td>
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
                                        <a href="admin_verif.php?id_ruko=<?php echo $row['id_ruko']; ?>">
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
                <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <!-- Previous Button -->
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">&laquo;</a>
                        <?php else: ?>
                            <span class="disabled">&laquo;</span>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>" 
                            class="<?php echo $i == $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <!-- Next Button -->
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?php echo $page + 1; ?><?php echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">&raquo;</a>
                        <?php else: ?>
                            <span class="disabled">&raquo;</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p>Tidak ada data ruko ditemukan.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="scripts/admin_properti.js"></script>
</body>
</html>
