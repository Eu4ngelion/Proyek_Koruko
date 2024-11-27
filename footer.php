<?php
require "koneksi.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ambil data website
$sql = "SELECT telepon, alamat, email, instagram, facebook, youtube, twitter, judul, deskripsi_footer FROM website";
$result = mysqli_query($conn, $sql);
$footer = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <style>
        * {
            font-family: "Poppins";
        }

        html{
           height: 100%;
        }

        .footer {
            background-color: #320276;
            color: white;
            width: 100%;
            margin-top: auto;
            padding-top: 20px;
            position: relative;
            box-sizing: border-box;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            margin: 0 10%;
            flex-wrap: nowrap;
        }

        .footer-kiri {
            padding: 0 10px;
        }

        .footer-kanan {
            flex: 1;
            display: flex;
            width: 100%;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .link-section {
            display: flex;
            flex-direction: column;
            margin-bottom: 40px;
        }


        .footer-logo {
            color: #FECE0E;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            width: fit-content
        }

        .footer-description {
            font-size: 11px;
            line-height: 1.5;
            text-align: justify;
            max-width: 30vh;
            color: white;
            font-weight: bold;
            ;
        }

        .footer-title {
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: bold;
            padding: 0;
            color: #FECE0E
        }

        .link-list {
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 8px 10px;

        }

        .link-list li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .link-list li a:hover {
            color: #FECE0E;
            text-decoration: underline;
        }


        .contact-info {
            font-size: 14px;
            max-width: 30vh;
        }

        .contact-info-p {
            color: white;
            display: flex;
            margin: 0 0 15px 0;

        }

        .contact-info img {
            height: 20px;
            margin-right: 10px;
            filter: brightness(0) invert(1) sepia(1) saturate(10000%)
        }


        .social-icons-container {
            width: fit-content;
            margin: 0 auto;
        }

        .social-icons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            justify-content: center;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 white;
        }

        .social-icons a:hover {
            background-color: #FECE0E;
            box-shadow: 0 0 0 2px white;
        }

        .social-icons img {
            width: 100%;
            height: 100%;
            border-radius: 10px;

        }

        /* Copyright text */
        .copyright {
            text-align: center;
            font-size: 12px;
            margin: 10px 10%;
            padding: 20px 0;
            border-top: 1px solid #FECE0E;
            color: #FECE0E;

        }
    </style>
</head>

<body>
    <footer class="footer">
        <div class="footer-content">
            <!-- Deskripsi Footer -->
            <div class="footer-kiri">
                <div class="footer-logo">
                    <?php echo $footer['judul']; ?>
                </div>
                <div class="footer-description">
                    <?php echo $footer['deskripsi_footer']; ?>
                </div>
            </div>

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
                <div class="footer-title">Kontak Kami</div>
                <div class="contact-info">
                    <div class="contact-info-value">
                        <div class="contact-info-p">
                            <img src="images/assets/phone_icon.png" alt="phone">
                            <?php echo $footer['telepon']; ?>
                        </div>
                        <div class="contact-info-p">
                            <img src="images/assets/email_icon.png" alt="email">
                            <?php echo $footer['email']; ?>
                        </div>
                        <div class="contact-info-p">
                            <img src="images/assets/address_icon.png" alt="location">
                            <?php echo $footer['alamat']; ?>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Sosial Media -->
            <div class="link-section">
                <div class="footer-title">Sosial Media</div>
                <div class="social-icons">
                    <a href="<?php echo htmlspecialchars($footer['instagram']); ?>"><img src="images/assets/ig.png" alt="IG"></a>
                    <a href="<?php echo htmlspecialchars($footer['twitter']); ?>"><img src="images/assets/twitter.png" alt="Twit"></a>
                    <a href="<?php echo htmlspecialchars($footer['facebook']); ?>"><img src="images/assets/fb.png" alt="FB"></a>
                    <a href="<?php echo htmlspecialchars($footer['youtube']); ?>"><img src="images/assets/yt.png" alt="YT"></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            ©2024 <?php echo $footer['judul']; ?>. All rights reserved.
        </div>
    </footer>
</body>

</html>