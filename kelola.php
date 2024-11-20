<?php
require "koneksi.php";
session_start();
$nama_pengguna = $_SESSION['username'];
// Ambil data properti yang dimiliki oleh pengguna yang sedang login
$query_ruko = "SELECT ruko.*, pengguna.nama_pengguna FROM ruko 
                JOIN pengguna ON ruko.nama_pengguna = pengguna.nama_pengguna 
                WHERE ruko.nama_pengguna = '$nama_pengguna'
                ORDER BY ruko.id_ruko DESC";
$ruko_result = mysqli_query($conn, $query_ruko);

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< Updated upstream
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
=======
    <title>Kelola</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000;
            color: white;
            font-family: 'Poppins', sans-serif;
            text-align: center;
        }
        .main-index {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding-top: 80px;
        }
        .profile-item {
            margin: 15px 0;
            width: 100%;
            max-width: 400px;
            text-align: left;
        }
        .button-ganti {
            background-color: #703BF7;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
        }
        input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #703BF7;
            background-color: #191919;
            color: white;
            text-align: left;
>>>>>>> Stashed changes
        }
    </style>
</head>

<body>
<<<<<<< Updated upstream
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
                <button class="btn-verifikasi">Tambah Properti +</button>
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
    <script src="scripts/kelola.js"></script>
=======
    <?php
    include "navbar.php";
    require "koneksi.php"; // Tambahkan koneksi ke database

    // Ambil data dari database
    $sql = "SELECT * FROM properti"; // Ganti dengan query yang sesuai
    $result = mysqli_query($conn, $sql);
    ?>

    <div class="main-index">
        <h1>Kelola Properti</h1>
        <form method="POST" action="kelola.php">
            <div class="profile-item">
                <label>ID Ruko:</label>
                <input type="text" name="id_ruko" required>
            </div>
            <div class="profile-item">
                <label>Nama Ruko:</label>
                <input type="text" name="nama_ruko" required>
            </div>
            <div class="profile-item">
                <label>Kota:</label>
                <input type="text" name="kota" required>
            </div>
            <div class="profile-item">
                <label>Alamat:</label>
                <input type="text" name="alamat" required>
            </div>
            <div class="profile-item">
                <label>Harga Jual:</label>
                <input type="text" name="harga_jual" required>
            </div>
            <button class="button-ganti" type="submit" name="update">Tambah Properti</button>
        </form>

        <h2>Daftar Properti</h2>
        <table>
            <tr>
                <th>ID Ruko</th>
                <th>Nama Ruko</th>
                <th>Kota</th>
                <th>Alamat</th>
                <th>Harga Jual</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id_ruko']; ?></td>
                <td><?php echo $row['nama_ruko']; ?></td>
                <td><?php echo $row['kota']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['harga_jual']; ?></td>
                <td>
                    <button>Edit</button>
                    <button>Hapus</button>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
>>>>>>> Stashed changes
</body>

</html>