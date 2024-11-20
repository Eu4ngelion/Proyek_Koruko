<?php
    require "koneksi.php";

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <style>
        * {
            font-family: "Poppins", sans-serif;
        }
        html {
            margin: 0;
            padding: 0;
        }

        .footer {
            background-color: #703BF7;
            color: white;
            width: 100%;
            margin-top: auto;
            padding-top: 40px;
            position: relative;
            box-sizing: border-box;
        }

        .footer-content {
            display: flex;
            align-items: flex-start;
            margin: 0 10%;
            flex-wrap: nowrap;
        }

        .footer-kiri {
            flex: 0.8;
        }

        .footer-kanan {
            flex: 1.5;
            display: flex;
            width: 100%;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .link-section {
            margin-bottom: 40px;
        }


        .footer-logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .footer-description {
            font-size: 14px;
            line-height: 1.5;
        }

        .footer-title {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
            padding: 0;
        }

        .link-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            text-align: center;
            gap: 8px 10px;

        }

        .link-list {
            width: fit-content;
            margin: 0 auto;
        }

        .link-list li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .contact-info {
            font-size: 14px;

        }

        .contact-info p {
            margin-bottom: 12px;
            text-align: center;
        }

        .social-icons-container {
            width: fit-content;
            margin: 0 auto;
        }

        .social-icons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 20px;
            justify-content: center;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            background-color: transparent;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .social-icons img {
            width: 100%;
            height: 100%;
        }

        /* Copyright text */
        .copyright {
            text-align: right;
            font-size: 12px;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-kiri">
                <div class="footer-logo">
                    Koruko
                </div>
                <div class="footer-description">
                    Koruko adalah platform, yang bertujuan untuk membantu menemukan ruko idaman untuk disewa atau dibeli. Kami menyediakan informasi lengkap dan terkini tentang harga, lokasi, dan fitur-fitur lainnya untuk membantu Anda dalam proses pencarian.
                </div>
            </div>

            <div class="footer-kanan">
                <!-- Link Cepat -->
                <div class="link-section">
                    <div class="footer-title">Link Cepat</div>
                    <ul class="link-list">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="pencarian.php">Jelajah</a></li>
                        <li><a href="tentang.php">Tentang</a></li>
                        <li><a href="daftar.php">Daftar</a></li>
                        <li><a href="kelola.php">Kelola</a></li>
                        <li><a href="masuk.php">Masuk</a></li>
                    </ul>
                </div>

                <!-- Kontak Kami -->
                <div class="link-section">
                    <div class="footer-title">Kontak</div>
                    <div class="contact-info">
                        <p>Telp: +62 8123456790</p>
                        <p>Email: koruko@gmail.com</p>
                        <p>Alamat: Jl. Raya No. 1, Jakarta</p>
                    </div>
                </div>
                
                <!-- Sosial Media -->
                <div class="link-section">
                    <div class="footer-title">Sosial Media</div>
                    <div class="social-icons">
                        <a href="#"><img src="images/assets/instagram.png" alt="IG"></a>
                        <a href="#"><img src="images/assets/twitter.png" alt="Twit"></a>
                        <a href="#"><img src="images/assets/fb.png" alt="FB"></a>
                        <a href="#"><img src="images/assets/yt.png" alt="YT"></a>
                        </div>
                </div>
                
            </div>
        </div>
        <div class="copyright">
            © 2024 Koruko . All rights reserved
        </div>
    </footer>
</body>

</html>