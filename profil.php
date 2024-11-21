<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
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
            height: auto;
            min-height: 100vh;
            padding-top: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-item {
            margin: 15px 0;
            width: 100%;
            max-width: 400px;
            text-align: left;
        }
        .profile-item label {
            display: block;
            margin-bottom: 5px;
            font-size: 18px;
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
        }
        img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body class="body-index">
    <header><?php include "navbar.php"; ?></header>

    <main class="main-index">
        <h1>Profil Akun</h1>
        <div class="profile-item">
            <label>Nama Lengkap:</label>
            <div style="display: flex; align-items: center;">
                <input type="text" value="Nama Lengkap">
                <button class="button-ganti" style="margin-left: 10px;">Ganti</button>
            </div>
        </div>
        <div class="profile-item">
            <label>Nama Pengguna:</label>
            <div style="display: flex; align-items: center;">
                <input type="text" value="User 123">
                <button class="button-ganti" style="margin-left: 10px;">Ganti</button>
            </div>
        </div>
        <div class="profile-item">
            <label>No Telepon:</label>
            <div style="display: flex; align-items: center;">
                <input type="text" value="081234567899">
                <button class="button-ganti" style="margin-left: 10px;">Ganti</button>
            </div>
        </div>
        <div class="profile-item">
            <label>Email:</label>
            <div style="display: flex; align-items: center;">
                <input type="email" value="user123@gmail.com">
                <button class="button-ganti" style="margin-left: 10px;">Ganti</button>
            </div>
        </div>
        <div class="profile-item">
            <label>Kata Sandi:</label>
            <div style="display: flex; align-items: center;">
                <input type="password" value="********">
                <button class="button-ganti" style="margin-left: 10px;">Ganti</button>
            </div>
        </div>
        <div class="profile-item">
            <div style="display: flex; flex-direction: column; align-items: center;">
                <label>Foto Profil:</label>
                <img src="images/user/profil_user_1.png" alt="Foto Profil">
                <button class="button-ganti" style="margin-top: 10px;">Ganti</button>
            </div>
        </div>
    </main>

    <footer><?php include "footer.php"; ?></footer>
</body>
</html>