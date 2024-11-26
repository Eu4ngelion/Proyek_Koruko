<?php
require "koneksi.php";

// Memulai Sesion
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = false;
}

// Default GET
if (isset($_GET['searching'])) {
    $cari_keyword = $_GET['searching'];
} else {
    $cari_keyword = "";
}
if (isset($_GET['lokasi'])) {
    $cari_lokasi = $_GET['lokasi'];
} else {
    $cari_lokasi = "";
}
if (isset($_GET['tipe'])) {
    $cari_tipe = $_GET['tipe'];
} else {
    $cari_tipe = "";
}
if (isset($_GET['harga_min'])) {
    $cari_harga_min = $_GET['harga_min'];
} else {
    $cari_harga_min = "";
}
if (isset($_GET['harga_max'])) {
    $cari_harga_max = $_GET['harga_max'];
} else {
    $cari_harga_max = "";
}
if (isset($_GET["cur_page"])) {
    $cur_page = $_GET["cur_page"];
} else {
    // Masuk lagi ke url ini dengan get cur page = 1
    $new_location = "Location: pencarian.php?";
    $new_location .= "searching=" . $cari_keyword . "&";
    $new_location .= "lokasi=" . $cari_lokasi . "&";
    $new_location .= "tipe=" . $cari_tipe . "&";
    $new_location .= "harga_min=" . $cari_harga_min . "&";
    $new_location .= "harga_max=" . $cari_harga_max . "&";
    $new_location .= "cur_page=1";
    header($new_location);
    exit();
}

// Algoritma Searching 
$search_where_algoritma = "WHERE (
    nama_ruko LIKE '%$cari_keyword%'
    OR kota LIKE '%$cari_keyword%'
    OR alamat LIKE '%$cari_keyword%'
    OR harga_sewa LIKE '%$cari_keyword%'
    OR harga_jual LIKE '%$cari_keyword%'
    )";

if ($cari_lokasi != "") {
    $search_where_algoritma .= " AND kota LIKE '%$cari_lokasi%' ";
}

if ($cari_tipe != "" && $cari_tipe != "Semua") {
    if ($cari_tipe == "Dijual") {
        $search_where_algoritma .= " AND harga_jual > 0 ";
    }
    if ($cari_tipe == "Disewa") {
        $search_where_algoritma .= " AND harga_sewa > 0 ";
    }
}

if ($cari_harga_min != "") {
    $search_where_algoritma .= " AND (
           (harga_sewa > 0 AND harga_sewa >= $cari_harga_min) OR 
           (harga_jual > 0 AND harga_jual >= $cari_harga_min)
       ) ";
}

if ($cari_harga_max != "") {
    $search_where_algoritma .= " AND (
           (harga_sewa > 0 AND harga_sewa <= $cari_harga_max) OR 
           (harga_jual > 0 AND harga_jual <= $cari_harga_max)
       ) ";
}

// Query Pencarian
$sql_search = "SELECT * FROM ruko ";
$sql_search .= $search_where_algoritma;
$sql_search .= " AND status = 1";
$sql_search .= " LIMIT 12";
$sql_search .= " OFFSET " . ($cur_page - 1) * 12;

$result_search = mysqli_query($conn, $sql_search);
$ruko_rekomendasi = mysqli_fetch_all($result_search, MYSQLI_ASSOC);

// Query Count Jumlah Ruko Ditemukan
$sql_count = "SELECT COUNT(*) AS count FROM ruko ";
$sql_count .= $search_where_algoritma;
$sql_count .= " AND status = 1";

$result_count = mysqli_query($conn, $sql_count);
$count_total_ruko = mysqli_fetch_assoc($result_count);

// Function format subvalue
function formatSubvalue($value)
{
    $num = intval(preg_replace('/[^0-9]/', '', $value));
    if ($num >= 1000000000) {
        return number_format($num / 1000000000, 1, ',', '.') . ' miliar';
    } elseif ($num >= 1000000) {
        return number_format($num / 1000000, 1, ',', '.') . ' juta';
    } elseif ($num >= 1000) {
        return number_format($num / 1000, 0, ',', '.') . ' ribu';
    } else {
        return number_format($num, 0, ',', '.');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/searching.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        html {
            height: 100%;
        }


        .paginasi-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0
        }

        .paginasi-arrow-left {
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
        }

        .paginasi-arrow {
            width: 40px;
            height: 40px;
            background-color: white;
            margin: 0 10px;
            border-radius: 100%;
            /* align center the arrow */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
        }

        .paginasi-page-number-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .paginasi-page-number {
            color: black;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            margin: 0 5px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            border-radius: 100%;
            transition: all 0.3s;
            text-decoration: none;
        }

        .paginasi-page-number-active {
            color: white;
            background-color: #703BF7;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            margin: 0 5px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            border-radius: 100%;
            transition: all 0.3s;
            text-decoration: none;
        }

        .paginasi-page-number:hover {
            background-color: #703BF7;
            color: white;
            transition: 0.3s;
        }
    </style>

</head>

<body>
    <header>
        <?php include "navbar.php"; ?>
    </header>
    <main class="container-main">
        <div class="main-pencarian">
            <div class="search-bar">
                <input id="input-search-bar" type="text" name="input-search-bar"
                    placeholder="Cari Ruko..." value="<?php echo $cari_keyword; ?>">

                <div class="search-button">
                    <i class="fas fa-search"></i>
                </div>
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
                                <?php if ($cari_lokasi != "") {
                                    echo $cari_lokasi;
                                } else {
                                    echo "Pilih Lokasi";
                                } ?>
                            </div>
                        </div>
                    </button>
                    <!-- drop down -->
                    <div class="main-dropdown-lokasi-box">
                        <!-- search bar lokasi-->
                        <input id="main-input-lokasi" name="lokasi" type="text" class="main-dropdown-lokasi-search"
                            placeholder="Cari Kota atau Alamat"
                            <?php if ($cari_lokasi != "") {
                                echo "value='$cari_lokasi'";
                            }
                            ?>>
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
                                <?php if ($cari_tipe != "") {
                                    echo $cari_tipe;
                                } else {
                                    echo "Pilih Tipe";
                                } ?>
                            </div>
                        </div>
                    </button>
                    <!-- drop down -->
                    <div class="main-dropdown-tipe-box">
                        <div class="main-dropdown-tipe">
                            <input id="main-input-tipe" type="hidden" name="tipe" value="<?php echo $cari_tipe; ?>">

                            <!-- radio -->
                            <div class="main-dropdown-tipe-radio">
                                <label>
                                    <input type="radio" name="tipe" value="Semua"
                                        <?php if ($cari_tipe == "Semua") echo "checked"; ?>>
                                    Semua
                                </label>
                                <label>
                                    <input type="radio" name="tipe" value="Dijual"
                                        <?php if ($cari_tipe == "Dijual") echo "checked"; ?>>
                                    Dijual
                                </label>
                                <label>
                                    <input type="radio" name="tipe" value="Disewa"
                                        <?php if ($cari_tipe == "Disewa") echo "checked"; ?>>
                                    Disewa
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
                            <div id="subvalue-harga" class="main-harga-search-category-value">
                                <?php
                                if ($cari_harga_min != "" && $cari_harga_max != "") {
                                    echo "IDR " . formatSubvalue($cari_harga_min) . " - IDR " . formatSubvalue($cari_harga_max);
                                } else {
                                    echo "Pilih Rentang Harga";
                                } ?>
                            </div>

                        </div>
                    </button>

                    <!-- drop down -->
                    <div class="main-dropdown-harga-box">
                        <input id="main-input-harga-min" name="harga_min" type="text" class="main-dropdown-harga-min" '
                        placeholder="Minimum" >
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
                    <input id="hidden_keyword" type="hidden" name="searching" value="<?php echo $cari_keyword; ?>">
                    <input id="hidden_lokasi" type="hidden" name="lokasi" value="<?php echo $cari_lokasi; ?>">
                    <input id="hidden_tipe" type="hidden" name="tipe" value="<?php echo $cari_tipe ?>">
                    <input id="hidden_min" type="hidden" name="harga_min" value="<?php echo $cari_harga_min ?>">
                    <input id="hidden_max" type="hidden" name="harga_max" value="<?php echo $cari_harga_max ?>">

                    <button class="main-search-submit" name="submit-search-block" type="submit" value="submitted">Cari</button>
                </form>
            </div>
            <div class="main-rekomendasi-content">
                <?php foreach ($ruko_rekomendasi as $ruko) : ?>
                    <?php
                    $sql = "SELECT gambar_properti FROM gambar_ruko WHERE id_ruko = " . $ruko['id_ruko'];
                    $result = mysqli_query($conn, $sql);
                    $gambar = mysqli_fetch_assoc($result);
                    ?>
                    <a class="main-link-card" href="detail.php?id_ruko=<?php echo $ruko['id_ruko']; ?>">
                    <button class="main-rekomendasi-card">
                    <div class="rekomendasi-card-image" style="background-image: url(' images/ruko/<?php echo $gambar['gambar_properti']; ?>')">
                        <!-- Tampilkan label Disewa hanya jika harga sewa memiliki nilai -->
                        <?php if ($ruko['harga_sewa'] > 0) : ?>
                            <div class="card-pop-sewa">
                                Disewa
                            </div>
                        <?php endif; ?>

                        <!-- Tampilkan label Dijual hanya jika harga jual memiliki nilai -->
                        <?php if ($ruko['harga_jual'] > 0) : ?>
                            <div class="card-pop-jual">
                                Dijual
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="rekomendasi-card-bottom">
                        <div class="rekomendasi-card-harga">
                            <!-- Jika ada harga jual -->
                            <?php if ($ruko['harga_jual'] > 0) : ?>
                                <div class="rekomendasi-card-harga-kiri">
                                    IDR <?php echo formatSubvalue($ruko['harga_jual']); ?>
                                </div>
                                <!--  Jika ada harga sewa juga -->
                                <?php if ($ruko['harga_sewa'] > 0) : ?>
                                    <div class="rekomendasi-card-harga-kanan">
                                        IDR <?php echo formatSubvalue($ruko['harga_sewa']); ?> / Tahun
                                    </div>
                                <?php endif; ?>
                            <?php elseif($ruko['harga_sewa'] > 0) : ?>
                                <!-- Jika ada harga sewa saja -->
                                <div class="rekomendasi-card-harga-kiri">
                                    IDR <?php echo formatSubvalue($ruko['harga_sewa']); ?> / Tahun
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- deskripsi atas -->
                        <div class="rekomendasi-card-deskripsi-atas">
                            <div class="rekomendasi-card-kota">
                                <?php echo $ruko['kota']; ?>
                            </div>
                            <div class="rekomendasi-card-nama">
                                <?php echo $ruko['nama_ruko']; ?>
                            </div>
                            <div class="rekomendasi-card-alamat">
                                <?php echo $ruko['alamat']; ?>
                            </div>
                        </div>

                        <!-- deskripsi bawah -->
                        <div class="rekomendasi-card-deskripsi-bawah">
                            <div class="rekomendasi-card-fasilitas-luas">
                                <div class="fasilitas-luas">LT : <?php echo $ruko["luas_tanah"] ?> m2 </div>
                                <div class="fasilitas-luas">LB : <?php echo $ruko["luas_tanah"] ?> m2</div>
                            </div>

                            <div class="rekomendasi-card-fasilitas-icon">
                                <div class="fasilitas-icon">
                                    <image src="images/assets/bed_icon.png" alt="bed" style="width: 17px; height: auto;"> :
                                        <?php echo $ruko['jmlh_kmr_tdr']; ?>
                                </div>
                                <div class="fasilitas-icon">
                                    <image src="images/assets/bath_icon.png" alt="bath" style="width: 20px; height: auto;"> :
                                        <?php echo $ruko['jmlh_kmr_mandi']; ?>
                                </div>
                                <div class="fasilitas-icon">
                                    <image src="images/assets/garage_icon.png" alt="garage" style="width: 20px; height: auto;"> :
                                        <?php echo $ruko['jmlh_garasi']; ?>
                                </div>
                                <div class="fasilitas-icon">
                                    <image src="images/assets/floor_icon.png" alt="floor" style="width: 20px; height: auto;"> :
                                        <?php echo $ruko['jmlh_lantai']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </button>
                    </a>
                <?php endforeach; ?>
                </div>
            </div>

            <!-- Paginasi -->
            <div class="paginasi-container">
                <?php
                $total_page = ceil($count_total_ruko['count'] / 12);
                $start_page = $cur_page - 2;
                $end_page = $cur_page + 2;
                ?>
                <!-- jika total page > 3 dan cur_page  -->
                <?php if ($cur_page > 1) : ?>
                    <a id="paginasi-arrow-left"
                        class="paginasi-arrow-left"
                        href="pencarian.php?searching=<?php echo $cari_keyword; ?>&lokasi=<?php echo $cari_lokasi; ?>&tipe=<?php echo $cari_tipe; ?>&harga_min=<?php echo $cari_harga_min; ?>&harga_max=<?php echo $cari_harga_max; ?>&cur_page=<?php echo $cur_page - 1; ?>">
                        <button class="paginasi-arrow">
                            < </button>
                    </a>
                <?php endif; ?>

                <div class="paginasi-page-number-container">
                    <!-- Tampilkan 2 Halaman Sebelumnya, Halaman Sekarang, dan 2 Halaman Selanjutnya -->

                    <?php

                    if ($start_page < 1) {
                        $start_page = 1;
                    }
                    if ($end_page > $total_page) {
                        $end_page = $total_page;
                    }
                    if ($total_page < 5) {
                        $start_page = 1;
                        $end_page = $total_page;
                    }
                    ?>

                    <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                        <?php if ($i == $cur_page) : ?>

                            <a class='paginasi-page-number-active'
                                href="pencarian.php?searching=<?php echo $cari_keyword; ?>&lokasi=<?php echo $cari_lokasi; ?>&tipe=<?php echo $cari_tipe; ?>&harga_min=<?php echo $cari_harga_min; ?>&harga_max=<?php echo $cari_harga_max; ?>&cur_page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php else : ?>
                            <a class='paginasi-page-number'
                                href="pencarian.php?searching=<?php echo $cari_keyword; ?>&lokasi=<?php echo $cari_lokasi; ?>&tipe=<?php echo $cari_tipe; ?>&harga_min=<?php echo $cari_harga_min; ?>&harga_max=<?php echo $cari_harga_max; ?>&cur_page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endif ?>
                    <?php endfor ?>
                </div>

                <?php if ($cur_page < $total_page) : ?>
                    <a id="paginasi-arrow-right"
                        class="paginasi-arrow-left"
                        href="pencarian.php?searching=<?php echo $cari_keyword; ?>&lokasi=<?php echo $cari_lokasi; ?>&tipe=<?php echo $cari_tipe; ?>&harga_min=<?php echo $cari_harga_min; ?>&harga_max=<?php echo $cari_harga_max; ?>&cur_page=<?php echo $cur_page + 1; ?>">
                        <button class="paginasi-arrow"> > </button>
                    </a>
                <?php endif; ?>


                </>
            </div>
    </main>

    <footer>
        <?php include "footer.php"; ?>
    </footer>

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
                lokasiSearchBox.style.backgroundColor = "white";
            }
        });

        tipeSearchBox.addEventListener("mouseover", function() {
            if (tipeDropdownBox.style.display != "flex") {
                tipeSearchBox.style.backgroundColor = "lightgrey";
            }
        });
        tipeSearchBox.addEventListener("mouseout", function() {
            if (tipeDropdownBox.style.display != "flex") {
                tipeSearchBox.style.backgroundColor = "white";
            }
        });

        hargaSearchBox.addEventListener("mouseover", function() {
            if (hargaDropdownBox.style.display != "flex") {
                hargaSearchBox.style.backgroundColor = "lightgrey";
            }
        });
        hargaSearchBox.addEventListener("mouseout", function() {
            if (hargaDropdownBox.style.display != "flex") {
                hargaSearchBox.style.backgroundColor = "white";
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

        // Ketika Search Bar Diinput Update Hidden Input Keyword
        let inputSearchBar = document.querySelector("#input-search-bar");
        let hiddenKeyword = document.querySelector("#hidden_keyword");

        inputSearchBar.addEventListener("input", function() {
            hiddenKeyword.value = inputSearchBar.value;
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
                subvalueHarga.innerHTML = "IDR " + inputHargaMinValue + " - IDR " + inputHargaMaxValue;
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