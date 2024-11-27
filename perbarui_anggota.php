<?php
require 'koneksi.php';
// Fetch the existing data for the member
if (isset($_GET['id'])) {
    $id_anggota = $_GET['id'];
    $query = "SELECT * FROM tim WHERE id_anggota = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id_anggota);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
    }
}
// Update the member's information
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota = $_POST['id_anggota'];
    $nama_anggota = $_POST['nama_anggota'];
    $peran = $_POST['peran'];
    $foto = $_FILES['foto']['name'];
    $target_dir = "images/anggota/";
    $target_file = $target_dir . basename($foto);
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    if ($foto) {
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $sql = "UPDATE tim SET nama_anggota = ?, peran = ?, foto = ? WHERE id_anggota = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sssi", $nama_anggota, $peran, $foto, $id_anggota);
                if ($stmt->execute()) {
                    echo "
                        <script>
                        alert('Berhasil memperbarui data!');
                        document.location.href = 'admin_tentang.php';
                        </script>
                    ";
                } else {
                    echo "
                        <script>
                        alert('Gagal memperbarui data!');
                        document.location.href = 'admin_tentang.php';
                        </script>
                    ";
                }
                $stmt->close();
            }
        } else {
            echo "
                <script>
                alert('Gagal mengunggah foto!');
                document.location.href = 'admin_tentang.php';
                </script>
            ";
        }
    } else {
        $sql = "UPDATE tim SET nama_anggota = ?, peran = ? WHERE id_anggota = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssi", $nama_anggota, $peran, $id_anggota);
            if ($stmt->execute()) {
                echo "
                    <script>
                    alert('Berhasil memperbarui data!');
                    document.location.href = 'admin_tentang.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                    alert('Gagal memperbarui data!');
                    document.location.href = 'admin_tentang.php';
                    </script>
                ";
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbarui Anggota</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #3A2470;
        }
        .login-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            min-height: 100vh;
            background-color: #3A2470;
        }
        .login-box {
            width: 50%;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px;
            background-color: #191919;
            border-radius: 20px;
            box-shadow: 0 0 100px #703BF7;
        }
        .login-title {
            text-align: center;
            padding: 0;
            margin: 0;
            color: white;
            font-size: 64px;
            font-weight: bold;
            letter-spacing: -2px;
        }
        .form-group {
            display: flex;
            align-items: center;
            flex-direction: column;
            margin: 20px 0;
        }
        .redirect-register {
            color: #703BF7;
            width: 60%;
            font-family: "Poppins", sans-serif;
            font-size: 12px;
            text-align: right;
        }
        .redirect-register a {
            color: #703BF7;
        }
        .form-control {
            width: 60%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }
        #text-foto {
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            margin: 10px 0;
            align-items: left;
            justify-content: left;
        }
        .button-ungu {
            width: 100px;
            height: 40px;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #703BF7;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <section class="login-content">
        <div class="login-box">
            <div class="login-title">
                Perbarui Anggota
            </div>
            <form class="form-group" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_anggota" value="<?php echo $row['id_anggota']; ?>">
                <input type="text" class="form-control" name="nama_anggota" placeholder="Nama Anggota" value="<?php echo $row['nama_anggota']; ?>">
                <input type="text" class="form-control" name="peran" placeholder="Peran" value="<?php echo $row['peran']; ?>">
                <a id="text-foto">Foto</a>
                <input type="file" class="form-control" name="foto" accept="image/*" style="color: white;">
                <button name="update-submit" class="button-ungu" type="submit">Perbarui</button>
            </form>
        </div>
    </section>
</body>
</html>