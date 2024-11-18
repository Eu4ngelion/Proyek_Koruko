<?php
require "koneksi.php";

// Memulai Sesion
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = false;
}

// Mengambil data admin
$sql = "SELECT nama_admin FROM admin";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koruko</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: black;
        }

        .main-index {
            height: auto;
            min-height: 100vh;
            padding-top: 60px;
            font-family: 'Poppins', sans-serif;
            z-index: -2;
        }

        /* Hero */
        .main-hero-image {
            height: 500px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .hero-image {
            width: 102%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            z-index: -1;
            filter: blur(7px) brightness(0.5);
        }

        .hero-text {
            text-align: center;
            color: white;
        }

        .main-hero-title {
            font-size: 64px;
            font-weight: bolder;
            letter-spacing: -2px;
            color: white;
        }

        .main-hero-subtitle {
            font-size: 32px;
            font-weight: bold;
            color: white;
        }

        .main-hero-search {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .main-search-lokasi,
        .main-search-tipe,
        .main-search-harga {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }

        .main-dropdown-lokasi-box,
        .main-dropdown-tipe-box,
        .main-dropdown-harga-box {
            display: none;
            flex-direction: column;
            position: absolute;
            z-index: 1;
            background-color: #ffffff;
            border: 1px solid #703BF7;
            border-radius: 10px;
            box-shadow: 0px 8px 16px 0px #703BF7;
            padding: 12px 0px;
            margin-top: 5px;
            width: auto;
            min-width: 200px;
        }

        .main-dropdown-lokasi-search {
            padding: 10px 80px 10px 10px;
            margin: 5px 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
        }

        .main-dropdown-harga-min,
        .main-dropdown-harga-max {
            padding: 10px 80px 10px 10px;
            margin: 5px 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
        }

        .main-dropdown-tipe-radio {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            padding: 10px 20px;

        }

        .main-dropdown-tipe-radio label {
            display: flex;
            margin-right: 10px;
            font-family: "Poppins", sans-serif;
            font-size: 16px;
        }

        .main-dropdown-tipe-radio input[type="radio"] {
            margin-right: 5px;
            width: 20px;
            height: 16px;
        }


        .main-lokasi-search-box,
        .main-tipe-search-box,
        .main-harga-search-box {
            background-color: white;
            color: black;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            width: 200px;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
        }

        .main-lokasi-search-category-title,
        .main-tipe-search-category-title,
        .main-harga-search-category-title {
            font-weight: bold;
        }

        .main-search-submit {
            background-color: #703BF7;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 24px;
            font-weight: bold;
            width: 150px;
            height: 100%;
        }

        .main-input-lokasi {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
        }

        .main-dropdown-lokasi-terapkan,
        .main-dropdown-tipe-terapkan,
        .main-dropdown-harga-terapkan {
            display: flex;
            width: 80%;
            justify-content: center;
            border-top: 2px solid #703BF7;
            margin: 10px auto;
            padding-top: 10px;
        }

        .main-dropdown-lokasi-terapkan-button,
        .main-dropdown-tipe-terapkan-button,
        .main-dropdown-harga-terapkan-button {
            background-color: #703BF7;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100px;
        }

        /* Section Rekomendasi */

        .main-section-rekomendasi {
            margin-top: 20px;
            padding: 20px 10%;
            font-family: "Poppins", sans-serif;
        }

        .main-rekomendasi-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .main-rekomendasi-title-left {
            font-size: 40px;
            font-weight: bold;
            align-items: center;
            margin: 20px 0;
            color: #703BF7;
        }

        .main-rekomendasi-title-left img {
            vertical-align: middle;
        }
    </style>
</head>


<body class="body-index">
    <header><?php include "navbar.php" ?></header>

    <main class="main-index">
        <div class="main-hero-image">
            <img class="hero-image" src="images/assets/hero_bg2.png" alt="hero image">

            <div class="hero-text">
                <div class="main-hero-title">Selamat Datang di Koruko</div>
                <div class="main-hero-subtitle">Mencari Ruko Jadi Lebih Mudah</div>
            </div>

            <div class="main-hero-search">
                <!-- kategori lokasi -->
                <div class="main-search-lokasi">
                    <button type="button" class="main-lokasi-search-box">
                        <div class="main-lokasi-search-category">
                            <!-- the title of the category -->
                            <div class="main-lokasi-search-category-title">
                                Lokasi
                                <img id="lokasi-arrow" src="images/assets/dropdown_arrow_icon.png" alt="arrow down" style="width: 20px; float: right;">
                            </div>
                            <!-- the value it picked -->
                            <div id="subvalue-lokasi" class="main-lokasi-search-category-value">
                                Pilih Lokasi
                            </div>
                        </div>
                    </button>
                    <!-- drop down -->
                    <div class="main-dropdown-lokasi-box">
                        <!-- search bar lokasi-->
                        <input id="main-input-lokasi" name="lokasi" type="text" class="main-dropdown-lokasi-search" placeholder="Cari Kota atau Alamat">
                        <!-- tombol terapkan -->
                        <div class="main-dropdown-lokasi-terapkan">
                            <button type="button" id="terapkan-lokasi" class="main-dropdown-lokasi-terapkan-button">Terapkan</button>
                        </div>
                    </div>
                </div>

                <!-- kategori tipe disewa/dijual -->
                <div class="main-search-tipe">
                    <button type="button" class="main-tipe-search-box">
                        <div class="main-tipe-search-category">
                            <!-- the title of the category -->
                            <div class="main-tipe-search-category-title">
                                Tipe
                                <img id="tipe-arrow" src="images/assets/dropdown_arrow_icon.png" alt="arrow down" style="width: 20px; float: right;">
                            </div>
                            <!-- the value it picked -->
                            <div id="subvalue-tipe" class="main-tipe-search-category-value">
                                Pilih Tipe
                            </div>
                        </div>
                    </button>
                    <!-- drop down -->
                    <div class="main-dropdown-tipe-box">
                        <div class="main-dropdown-tipe">
                            <!-- hidden input -->
                            <input id="main-input-tipe" type="hidden" name="tipe" value="">

                            <!-- radio -->
                            <div class="main-dropdown-tipe-radio">
                                <label>
                                    <input type="radio" name="tipe" value="Semua"> Semua
                                </label>
                                <label>
                                    <input type="radio" name="tipe" value="Dijual"> Dijual
                                </label>
                                <label>
                                    <input type="radio" name="tipe" value="Disewa"> Disewa
                                </label>
                            </div>

                            <!-- terapkan tipe -->
                            <div class="main-dropdown-tipe-terapkan">
                                <button type="button" id="terapkan-tipe" class="main-dropdown-tipe-terapkan-button">Terapkan</button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- kategori harga -->
                <div class="main-search-harga">
                    <button type="button" class="main-harga-search-box">
                        <div class="main-harga-search-category">
                            <!-- the title of the category -->
                            <div class="main-harga-search-category-title">
                                Harga
                                <img id="harga-arrow" src="images/assets/dropdown_arrow_icon.png" alt="arrow down" style="width: 20px; float: right;">
                            </div>
                            <!-- the value it picked -->
                            <div id="subvalue-harga" class="main-harga-search-category-value">Pilih Rentang Harga</div>

                        </div>
                    </button>

                    <!-- drop down -->
                    <div class="main-dropdown-harga-box">
                        <input id="main-input-harga-min" name="harga_min" type="text" class="main-dropdown-harga-min" placeholder="Minimum">
                        <input id="main-input-harga-max" name="harga_max" type="text" class="main-dropdown-harga-max" placeholder="Maksimum">

                        <!-- terapkan harga -->
                        <div class="main-dropdown-harga-terapkan">
                            <button type="button" id="terapkan-harga" class="main-dropdown-harga-terapkan-button">Terapkan</button>
                        </div>
                    </div>
                </div>

                <!-- Submit, Pencarian -->
                <form action="pencarian.php" method="GET">
                    <!-- Hidden Form -->
                    <input id="hidden_lokasi" type="hidden" name="lokasi" value="">
                    <input id="hidden_tipe" type="hidden" name="tipe" value="">
                    <input id="hidden_min" type="hidden" name="harga_min" value="">
                    <input id="hidden_max" type="hidden" name="harga_max" value="">

                    <button class="main-search-submit" name="submit-search-block" type="submit" value="submitted">Cari</button>
                </form>
            </div>
        </div>

        <section class="main-section-rekomendasi">
            <div class="main-rekomendasi">
                <div class="main-rekomendasi-title">
                    <div class="main-rekomendasi-title-left">
                        Rekomendasi
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 25px; height: auto;">
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 20px; height: auto;">
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 15px; height: auto;">
                    </div>
                    <div class="main-rekomendasi-title-right">
                        <a href="pencarian.php">
                            <button>
                                Lihat Semua
                            </button>
                        </a>
                    </div>
                </div>

                <div class="main-rekomendasi-content">
                    <div class="main-rekomendasi-card">
                        <div class="rekomendasi-card-image">

                        <!-- Jika Disewa -->

                        <!-- Jika Dijual -->

                        </div>
                        <div class="rekomendasi-card-bottom">
                            <div class="rekomendasi-card-harga">
                                <!-- Harga Jual,     Harga Sewa -->
                            </div>
                            <!-- deskripsi atas= kota, nama ruko, alamat -->

                            <!-- deskripsi bawah = fasilitas -->
                        </di>

                    </div>
                </div>


            </div>

            <div class="main-rekomendasi">
                <div class="main-rekomendasi-title">
                    <div class="main-rekomendasi-title-left">
                        Rekomendasi
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 25px; height: auto;">
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 20px; height: auto;">
                        <img src="images/assets/purple_star(2).png" alt="star" style="width: 15px; height: auto;">
                    </div>

                    <div class="main-rekomendasi-title-right">
                        <a href="pencarian.php">
                            <button>
                                Lihat Semua
                            </button>
                        </a>
                    </div>
                </div>
            </div>


        </section>
    </main>

    <footer><?php include "footer.php"; ?></footer>


    <script>
        // Dropdown Lokasi
        let lokasiSearchBox = document.querySelector(".main-lokasi-search-box");
        let lokasiDropdownBox = document.querySelector(".main-dropdown-lokasi-box");
        let lokasiRekomendasi = document.querySelector(".main-dropdown-lokasi-rekomendasi");

        // Dropdown Tipe
        let tipeSearchBox = document.querySelector(".main-tipe-search-box");
        let tipeDropdownBox = document.querySelector(".main-dropdown-tipe-box");
        let tipeRekomendasi = document.querySelector(".main-dropdown-tipe-rekomendasi");
        let tipeInput = document.querySelector("#main-input-tipe");

        // Dropdown Harga
        let hargaSearchBox = document.querySelector(".main-harga-search-box");
        let hargaDropdownBox = document.querySelector(".main-dropdown-harga-box");

        // Ketika hover - unhover
        lokasiSearchBox.addEventListener("mouseover", function() {
            if (lokasiDropdownBox.style.display != "flex") {
                lokasiSearchBox.style.backgroundColor = "lightgrey";
            }
        });
        lokasiSearchBox.addEventListener("mouseout", function() {
            if (lokasiDropdownBox.style.display != "flex") {
                lokasiSearchBox.style.backgroundColor = "lightgrey";
            }
        });

        tipeSearchBox.addEventListener("mouseover", function() {
            if (tipeDropdownBox.style.display != "flex") {
                tipeSearchBox.style.backgroundColor = "lightgrey";
            }
        });
        tipeSearchBox.addEventListener("mouseout", function() {
            if (tipeDropdownBox.style.display != "flex") {
                tipeSearchBox.style.backgroundColor = "lightgrey";
            }
        });

        hargaSearchBox.addEventListener("mouseover", function() {
            if (hargaDropdownBox.style.display != "flex") {
                hargaSearchBox.style.backgroundColor = "lightgrey";
            }
        });
        hargaSearchBox.addEventListener("mouseout", function() {
            if (hargaDropdownBox.style.display != "flex") {
                hargaSearchBox.style.backgroundColor = "lightgrey";
            }
        });


        // Ketika diklik display dropdown
        lokasiSearchBox.addEventListener("click", function() {
            lokasiDropdownBox.style.display = "flex";
            // main lokasi search box clicked berubah warna ungu yang cocok
            lokasiSearchBox.style.backgroundColor = "#703BF7";
            // rotate arrow
            document.getElementById("lokasi-arrow").style.transform = "rotate(180deg)";

        });
        tipeSearchBox.addEventListener("click", function() {
            tipeDropdownBox.style.display = "flex";
            tipeSearchBox.style.backgroundColor = "#703BF7";
            // rotate arrow
            document.getElementById("tipe-arrow").style.transform = "rotate(180deg)";
        });
        hargaSearchBox.addEventListener("click", function() {
            hargaDropdownBox.style.display = "flex";
            hargaSearchBox.style.backgroundColor = "#703BF7";
            // rotate arrow
            document.getElementById("harga-arrow").style.transform = "rotate(180deg)";
        });


        // Ketika diklik di luar dropdown
        window.addEventListener("click", function(e) {
            if (!lokasiSearchBox.contains(e.target) && !lokasiDropdownBox.contains(e.target)) {
                lokasiDropdownBox.style.display = "none";
                lokasiSearchBox.style.backgroundColor = "white";
                // reset arrow
                document.getElementById("lokasi-arrow").style.transform = "rotate(0deg)";
            }
            if (!tipeSearchBox.contains(e.target) && !tipeDropdownBox.contains(e.target)) {
                tipeDropdownBox.style.display = "none";
                tipeSearchBox.style.backgroundColor = "white";
                // reset arrow
                document.getElementById("tipe-arrow").style.transform = "rotate(0deg)";
            }
            if (!hargaSearchBox.contains(e.target) && !hargaDropdownBox.contains(e.target)) {
                hargaDropdownBox.style.display = "none";
                hargaSearchBox.style.backgroundColor = "white";
                // reset arrow
                document.getElementById("harga-arrow").style.transform = "rotate(0deg)";
            }
        });

        // Ketika diklik terapkan update subvalue kategori
        let subvalueLokasi = document.querySelector("#subvalue-lokasi");
        let subvalueTipe = document.querySelector("#subvalue-tipe");
        let subvalueHarga = document.querySelector("#subvalue-harga");

        let terapkanLokasi = document.querySelector("#terapkan-lokasi");
        let terapkanTipe = document.querySelector("#terapkan-tipe");
        let terapkanHarga = document.querySelector("#terapkan-harga");

        let hiddenLokasi = document.querySelector("#hidden_lokasi");
        let hiddenTipe = document.querySelector("#hidden_tipe");
        let hiddenMin = document.querySelector("#hidden_min");
        let hiddenMax = document.querySelector("#hidden_max");


        terapkanLokasi.addEventListener("click", function() {
            let inputLokasi = document.querySelector("#main-input-lokasi").value;

            if (inputLokasi != "") {
                subvalueLokasi.innerHTML = inputLokasi;
                lokasiDropdownBox.style.display = "none";
            } else {
                subvalueLokasi.innerHTML = "Pilih Lokasi";
                lokasiDropdownBox.style.display = "none";
            }
            lokasiSearchBox.style.backgroundColor = "white";


            hiddenLokasi.value = inputLokasi;

        });

        terapkanTipe.addEventListener("click", function() {
            let inputTipe = document.querySelector('input[name="tipe"]:checked').value;
            subvalueTipe.innerHTML = inputTipe;
            tipeDropdownBox.style.display = "none";

            hiddenTipe.value = inputTipe;
        });

        terapkanHarga.addEventListener("click", function() {
            let inputHargaMin = document.querySelector("#main-input-harga-min").value;
            let inputHargaMax = document.querySelector("#main-input-harga-max").value;
            subvalueHarga.innerHTML = "Rp " + inputHargaMin + " - Rp " + inputHargaMax;
            hargaDropdownBox.style.display = "none";

            hiddenMin.value = inputHargaMin;
            hiddenMax.value = inputHargaMax;
        });

        // Ketika diklik terapkan update hidden input
        let terapkanLokasiHidden = document.querySelector("#terapkan-lokasi");
        let terapkanTipeHidden = document.querySelector("#terapkan-tipe");
        let terapkanHargaHidden = document.querySelector("#terapkan-harga");

        terapkanLokasiHidden.addEventListener("click", function() {
            let inputLokasi = document.querySelector("#main-input-lokasi").value;
            document.querySelector('input[name="lokasi"]').value = inputLokasi;
        });

        terapkanTipeHidden.addEventListener("click", function() {
            let inputTipe = document.querySelector('input[name="tipe"]:checked').value;
            document.querySelector('input[name="tipe"]').value = inputTipe;
        });

        // Harga
        terapkanHargaHidden.addEventListener("click", function() {
            let inputHargaMin = document.querySelector("#main-input-harga-min").value;
            let inputHargaMax = document.querySelector("#main-input-harga-max").value;
            document.querySelector('input[name="harga_min"]').value = inputHargaMin;
            document.querySelector('input[name="harga_max"]').value = inputHargaMax;
        });

        // Harga Min > Max dan sebaliknya
        let inputHargaMin = document.querySelector("#main-input-harga-min");
        let inputHargaMax = document.querySelector("#main-input-harga-max");

        inputHargaMin.addEventListener("input", function() {
            // jika max masih kosong, isi dengan min
            if (inputHargaMax.value == "") {
                inputHargaMax.value = inputHargaMin.value;
            }
            if (parseInt(inputHargaMin.value.replace(/[^0-9]/g, '')) > parseInt(inputHargaMax.value.replace(/[^0-9]/g, ''))) {
                inputHargaMax.value = inputHargaMin.value;
            }
        });

        inputHargaMax.addEventListener("input", function() {
            // jika min masih kosong, isi dengan 0
            if (inputHargaMin.value == "") {
                inputHargaMin.value = "0";
            }


            if (parseInt(inputHargaMax.value.replace(/[^0-9]/g, '')) < parseInt(inputHargaMin.value.replace(/[^0-9]/g, ''))) {
                inputHargaMin.value = inputHargaMax.value;
            }
        });


        // Format subvalue harga ribu, juta, m, dst ketika
        terapkanHarga.addEventListener("click", function() {
            let inputHargaMinValue = formatSubvalueHarga(inputHargaMin.value);
            let inputHargaMaxValue = formatSubvalueHarga(inputHargaMax.value);

            // Jika Min = "" OR Max == ""
            if (inputHargaMin.value == "" || inputHargaMax.value == "") {
                subvalueHarga.innerHTML = "Pilih Rentang Harga"
            } else {
                subvalueHarga.innerHTML = "Rp " + inputHargaMinValue + " - Rp " + inputHargaMaxValue;
                hiddenMin.value = inputHargaMin.value;
                hiddenMax.value = inputHargaMax.value;
            }

        });

        function formatSubvalueHarga(value) {
            let num = parseInt(value.replace(/[^0-9]/g, ''));
            if (num >= 1000000000) {
                return (num / 1000000000).toFixed(1) + ' miliar';
            } else if (num >= 1000000) {
                return (num / 1000000).toFixed(1) + ' juta';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(1) + ' ribu';
            } else {
                return num;
            }
        }
    </script>
</body>


</html>