<?php
require 'koneksi.php';
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
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO tim (id_anggota, nama_anggota, peran, foto) VALUES ('$id_anggota', '$nama_anggota', '$peran', '$foto')";
        if (mysqli_query($conn, $sql)) {
            echo "
                <script>
                alert('Berhasil menambahkan data!');
                document.location.href = 'admin_tentang.php';
                </script>
            ";
        } else {
            echo "
            <script>
            alert('Gagal menambahkan data!');
            document.location.href = 'admin_tentang.php';
            </script>
            ";
        }
    } else {
        echo "
                <script>
                alert('Tidak erhasil menambahkan data!');
                document.location.href = 'admin_tentang.php';
                </script>
            ";    
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota</title>
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
            /* placeholder font */
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
                Tambah Anggota
            </div>
            <form class="form-group" method="POST" enctype="multipart/form-data">
                <input type="text" class="form-control" name="id_anggota" placeholder="ID Anggota">
                <input type="text" class="form-control" name="nama_anggota" placeholder="Nama Anggota">
                <input type="text" class="form-control" name="peran" placeholder="Peran">
                <a id="text-foto">Foto</a>
                <input type="file" class="form-control" name="foto" accept="image/*" style="color: white;">
                <button name="login-submit" class="button-ungu" type="submit">Tambah</button>
            </form>
        </div>
    </section>
</body>
</html>