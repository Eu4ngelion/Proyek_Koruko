
    <?php
    require "koneksi.php";
    session_start();

    // Ambil nama pengguna dari sesi
    $nama_pengguna = $_SESSION['username'];    

    // variabel untuk pagination
    $per_page = 5; // 
    $cur_page = isset($_GET['cur_page']) ? (int)$_GET['cur_page'] : 1; 
    $offset = ($cur_page - 1) * $per_page; 

    // Ambil data properti yang dimiliki oleh pengguna yang sedang login
    $query_ruko = "SELECT ruko.*, pengguna.nama_pengguna FROM ruko 
                JOIN pengguna ON ruko.nama_pengguna = pengguna.nama_pengguna 
                WHERE ruko.nama_pengguna = '$nama_pengguna'
                ORDER BY ruko.id_ruko DESC
                LIMIT $per_page OFFSET $offset"; 
    $ruko_result = mysqli_query($conn, $query_ruko);

    // Query untuk menghitung total jumlah ruko
    $count_query = "SELECT COUNT(*) AS count FROM ruko WHERE nama_pengguna = '$nama_pengguna'";
    $count_result = mysqli_query($conn, $count_query);
    $count_total_ruko = mysqli_fetch_assoc($count_result)['count']; 

    // Debug: Periksa apakah query berhasil
    if (!$ruko_result) {
        echo "Error: " . mysqli_error($conn);
    }
    
    if (isset($_POST['delete_id'])) {
        $id_ruko = $_POST['delete_id'];
        $delete_query = "DELETE FROM ruko WHERE id_ruko = '$id_ruko' AND nama_pengguna = '$nama_pengguna'";
        mysqli_query($conn, $delete_query);
        header("Location: kelola.php");
        exit;
    }

    if (isset($_POST['sold_id'])) {
        $id_ruko = $_POST['sold_id'];
        $update_query = "UPDATE ruko SET status = 2 WHERE id_ruko = '$id_ruko' AND nama_pengguna = '$nama_pengguna'";
        mysqli_query($conn, $update_query);
        header("Location: kelola.php");
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kelola Properti - Koruko</title>
        <link rel="stylesheet" href="styles/admin_properti.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <style>
            body {
                background-color: #000; 
                color: white; 
            }
            .main-content h1 {
                color: white; 
            }
            .add-property-container {
                text-align: right; 
                margin-bottom: 20px; 
            }
            
            /* Tambahkan CSS pagination dari pencarian.php */
            .pagination {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px 0;
            }

            .pagination a, .pagination button {
                width: 30px;
                height: 30px;
                background-color: white;
                margin: 0 5px;
                border-radius: 5px;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 16px;
                font-weight: bold;
                cursor: pointer;
                text-decoration: none;
            }

            .pagination button.active {
                color: white;
                background-color: #703BF7;
            }

            .pagination a:hover, .pagination button:hover {
                background-color: #703BF7;
                color: white;
                transition: 0.3s;
            }

            .btn-terjual,
            .btn-verifikasi,
            .btn-hapus {
                padding: 0.4rem 0.8rem;
                border-radius: 4px;
                font-size: 0.8rem;
                font-weight: 500;
                cursor: pointer;
                border: none;
                transition: opacity 0.2s;
            }

            .btn-terjual {
                background-color: #28a745;
                color: white;
            }

            .btn-verifikasi {
                background-color: #7C3AED;
                color: white;
            }

            .btn-hapus {
                background-color: #EF4444;
                color: white;
            }

            .btn-terjual:hover,
            .btn-verifikasi:hover,
            .btn-hapus:hover {
                opacity: 0.9;
            }
        </style>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <main class="main-content">
            <h1>Kelola Properti</h1>

            <!-- Search -->
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Cari...">
                <button class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <!-- Tambah Properti Button -->
            <div class="add-property-container">
                <a href="tambah_ruko.php">
                    <button class="btn-terjual">Tambah Properti +</button>
                </a>
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
                                    <a href="edit_ruko.php?id_ruko=<?php echo $row['id_ruko']; ?>">
                                        <button class="btn-verifikasi">Edit</button>
                                    </a>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['id_ruko']; ?>">
                                        <button type="submit" class="btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus properti ini?')">Hapus</button>
                                    </form>
                                    <?php if ($row['status'] == 1 || $row['status'] == 2) { ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="sold_id" value="<?php echo $row['id_ruko']; ?>">
                                            <button type="submit" class="btn-terjual" onclick="return confirm('Apakah Anda yakin ingin menandai properti ini sebagai terjual?')">Terjual</button>
                                        </form>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <?php
                $total_page = ceil($count_total_ruko / $per_page); // Total halaman
                if ($cur_page > 1) {
                    echo '<a href="kelola.php?cur_page=' . ($cur_page - 1) . '">&lt;</a>';
                }
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($i == $cur_page) {
                        echo '<button class="active">' . $i . '</button>';
                    } else {
                        echo '<a href="kelola.php?cur_page=' . $i . '">' . $i . '</a>';
                    }
                }
                if ($cur_page < $total_page) {
                    echo '<a href="kelola.php?cur_page=' . ($cur_page + 1) . '">&gt;</a>';
                }
                ?>
            </div>
        </main>

        <?php include 'footer.php'; ?>

        <script src="scripts/admin_properti.js"></script>
        <script src="scripts/kelola.js"></script>
    </body>

    </html>
