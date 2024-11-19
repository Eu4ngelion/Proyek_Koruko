<?php
require "koneksi.php";

// Memulai Sesion
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = false;
}

// Jika tidak ada searcing, tampilkan random
if (isset($_GET['submit-search-block'])) {
    $lokasi = $_GET['lokasi'];
    $tipe = $_GET['tipe'];
    $harga_min = $_GET['harga_min'];
    $harga_max = $_GET['harga_max'];

    $sql_search = "SELECT * FROM ruko WHERE kota LIKE '%$lokasi%' OR (harga_sewa BETWEEN $harga_min AND $harga_max OR harga_jual BETWEEN $harga_min AND $harga_max) AND status = 1";
    $result = mysqli_query($conn, $sql_search);
    $ruko_rekomendasi = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $sql_rekomendasi = "SELECT * FROM ruko ORDER BY RAND() LIMIT 12";
    $result = mysqli_query($conn, $sql_rekomendasi);
    $ruko_rekomendasi = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
$sql_rekomendasi = "SELECT * FROM ruko ORDER BY RAND() LIMIT 12";
$result = mysqli_query($conn, $sql_rekomendasi);
$ruko_rekomendasi = mysqli_fetch_all($result, MYSQLI_ASSOC);

// jika ada searching
if (isset($_POST['searching'])) {
    $searching = $_POST['searching'];
    $sql_search = "SELECT * FROM ruko WHERE nama_ruko LIKE '%$searching%' OR kota LIKE '%$searching%' OR alamat LIKE '%$searching%' OR harga_sewa LIKE '%$searching%' OR harga_jual LIKE '%$searching%' AND status = 1";
    $result = mysqli_query($conn, $sql_search);
    $ruko_rekomendasi = mysqli_fetch_all($result, MYSQLI_ASSOC);
}


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
</head>

<body>
    <header>
        <?php include "navbar.php"; ?>
    </header>
    <main class="container-main">
        <div class="main-pencarian">
            <div class="search-bar">
                <form action="pencarian.php" method="GET">
                    <input type="text" name="searching" placeholder="Cari buku...">
                </form>
                <button class="search-button">
                    <i class="fas fa-search"></i>
                </button>
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
            <div class="main-rekomendasi-content">
                    <?php foreach ($ruko_rekomendasi as $ruko) : ?>
                        <?php
                        $sql = "SELECT gambar_properti FROM gambar_ruko WHERE id_ruko = " . $ruko['id_ruko'];
                        $result = mysqli_query($conn, $sql);
                        $gambar = mysqli_fetch_assoc($result);
                        ?>
                        <a class="main-link-card" href="detail.php?id_ruko=<?php echo $ruko['id_ruko']; ?>">
                            <button class="main-rekomendasi-card">
                                <div class="rekomendasi-card-image" style="background-image: url('images/ruko/<?php echo $gambar['gambar_properti']; ?>')">
                                    <!-- Jika Disewa -->
                                    <?php if ($ruko['harga_jual'] != 0 || $ruko['harga_jual'] != NULL) : ?>
                                        <div class="card-pop-sewa">
                                            Disewa
                                        </div>
                                    <?php endif; ?>

                                    <!-- Jika Dijual -->
                                    <?php if ($ruko['harga_sewa'] != 0 || $ruko['harga_sewa'] != NULL) : ?>
                                        <div class="card-pop-jual">
                                            Dijual
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="rekomendasi-card-bottom">
                                    <div class="rekomendasi-card-harga">
                                        <!-- Harga Jual, Harga Sewa -->
                                        <?php if ($ruko['harga_jual'] != 0 || $ruko['harga_jual'] != NULL) : ?>
                                            <div class="rekomendasi-card-harga-kiri">
                                                <!-- function format subvalue harga -->
                                                IDR <?php echo formatSubvalue($ruko['harga_jual']); ?>
                                            </div>
                                            <?php if ($ruko['harga_sewa'] != 0 || $ruko['harga_sewa'] != NULL) : ?>
                                                <div class="rekomendasi-card-harga-kanan">
                                                    IDR <?php echo formatSubvalue($ruko['harga_sewa']); ?>
                                                </div>
                                            <?php endif; ?>

                                        <?php elseif ($ruko['harga_sewa'] != 0 || $ruko['harga_sewa'] != NULL) : ?>
                                            <div class="rekomendasi-card-harga-kiri">
                                                <!-- per bulan -->
                                                IDR <?php echo formatSubvalue($ruko['harga_sewa']); ?> / bulan
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

                                        </div>
                                    </div>

                                    <!-- deskripsi bawah -->
                                    <div class="rekomendasi-card-deskripsi-bawah">
                                        <div class="rekomendasi-card-fasilitas">
                                            <div class="fasilitas-title-luas">LT : </div>
                                            <div class="fasilitas-value"><?php echo $ruko['luas_tanah']; ?> m2</div>
                                        </div>
                                        <div class="rekomendasi-card-fasilitas">
                                            <div class="fasilitas-title-luas">LB :</div>
                                            <div class="fasilitas-value"><?php echo $ruko['luas_bangunan']; ?> m2</div>
                                        </div>
                                        <div class="rekomendasi-card-fasilitas">
                                            <div class="fasilitas-title">Kamar</div>
                                            :
                                            <div class="fasilitas-value"><?php echo $ruko['jmlh_kmr_tdr']; ?></div>
                                        </div>
                                        <div class="rekomendasi-card-fasilitas">
                                            <div class="fasilitas-title">Toilet</div>
                                            :
                                            <div class="fasilitas-value"><?php echo $ruko['jmlh_kmr_mandi']; ?></div>
                                        </div>
                                        <div class="rekomendasi-card-fasilitas">
                                            <div class="fasilitas-title">Garasi</div>
                                            :
                                            <div class="fasilitas-value"><?php echo $ruko['jmlh_lantai']; ?></div>
                                        </div>
                                        <div class="rekomendasi-card-fasilitas">
                                            <div class="fasilitas-title">Lantai</div>
                                            :
                                            <div class="fasilitas-value"><?php echo $ruko['jmlh_garasi']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
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