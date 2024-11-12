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
        .footer {
            background-color: #8A4FFF;
            color: white;
            padding: 30px 5px 0 30px;
            width: 100%;
            margin-top: auto;
            position: relative;
            box-sizing: border-box;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            max-width: 1400px;
            margin: 0 auto;
            padding-right: 20%;
        }

        .footer-kiri {
            flex: 1;
            padding-right: 40px;
        }

        .footer-tengah, .footer-kanan {
            flex: 1;
        }
        .footer-logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .footer-description {
            font-size: 14px;
            line-height: 1.5;
            max-width: 400px;
        }

        .link-sectiion{
            /* set the width to be fit */
            width: fit-content;
        }



        .footer-title{
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

        .social-icons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: center;
        }

        .social-icons a {
            width: 32px;
            height: 32px;
            background-color: white;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
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

            <div class="footer-tengah">
                <div class="link-section">
                    <div class="footer-title">Link Cepat</div>
                    <ul class="link-list">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="pencarian.php">Cari</a></li>
                        <li><a href="tentang.php">Tentang</a></li>
                        <li><a href="daftar.php">Daftar</a></li>
                        <li><a href="kelola.php">Kelola</a></li>
                        <li><a href="masuk.php">Masuk</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-kanan">
                <div class="link-section">
                    <div class="footer-title">Kontak Kami</div>
                    <div class="contact-info">
                        <p>Telp: +62 8123456790</p>
                        <p>Email: koruko@gmail.com</p>
                        <div class="social-icons">
                            <a href="#"><img src="path-to-instagram-icon.png" alt="IG"></a>
                            <a href="#"><img src="path-to-twitter-icon.png" alt="Twit"></a>
                            <a href="#"><img src="path-to-facebook-icon.png" alt="FB"></a>
                            <a href="#"><img src="path-to-youtube-icon.png" alt="YT"></a>
                        </div>
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