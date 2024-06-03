<?php
include("login-kontrol.php");
$not = "";
if ($_POST) {

    $uad = $_POST["urun-ad"];
    $uaciklama = $_POST["urun-aciklama"];
    $ukategori = $_POST["urun-kategori"];
    $ufiyat = $_POST["urun-fiyat"];
    $usira = $_POST["urun-sira"];
    if ($usira == "") {
        $usira = 999;
    }
    $yol = '../images/urunler/';
    $tmp_name = $_FILES['urun-resim']['tmp_name'];
    $name = $_FILES['urun-resim']['name'];
    $isim = mt_rand();
    $ext = pathinfo($_FILES['urun-resim']['name'], PATHINFO_EXTENSION);
    $yeniad = $isim . "." . $ext;
    $tip = $_FILES['urun-resim']['type'];
    if (strlen($name) == 0) {
        $not2 = "<div class='alert alert-info text-center font-weight-bold' role='alert'>Bir resim seçiniz</div>";
    }
    if ($tip != 'image/jpeg' && $tip != 'image/png' && $tip != 'image/jpg') {
        $not2 = "<div class='alert alert-danger text-center font-weight-bold' role='alert'>Yalnızca jpg,Jpeg ve png formatında olabilir.</div>";
    }
    move_uploaded_file($tmp_name, "$yol/$yeniad");


    $sekle = $db->prepare("INSERT INTO urun_tablosu SET urun_ad=?,urun_aciklama=?,urun_kategori=?,urun_fiyat=?,urun_gorsel=?,urun_sira=?");
    $sekle->execute([$uad, $uaciklama, $ukategori, $ufiyat, $yeniad, $usira]);
    if ($sekle) {
        header("refresh:1;urun-ekle.php");
        $not = "<div class='alert success text-center font-weight-bold' role='alert'>Ürün Eklendi</div>";
    } else {
        $not = "<div class='alert alert-success text-center font-weight-bold' role='alert'>Ürün Eklenemedi</div>";
    }
}
?>


<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ürün Ekle</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="./assets/js/init-alpine.js"></script>
    <style>
        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
            text-align: center;
        }

        .alert.success {
            background-color: #04AA6D;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>

</head>

<body>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen}">
        <?php include("sidebar.php"); ?>
        <div class="flex flex-col flex-1">
            <?php include("header.php"); ?>
            <main class="h-full pb-16 overflow-y-auto">
                <div class="container px-6 mx-auto grid ">
                    <h2 class="my-6 text-2xl font-semibold  text-gray-700 dark:text-gray-200">
                        &RightArrow; Ürün Ekle
                        <a href="urun-listesi.php"> <button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Ürün Listesine Git
                            </button>
                        </a>
                    </h2>

                    <div class="grid gap-6 mb-8 ">
                        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                            <form enctype="multipart/form-data" method="POST">

                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ürün Ad </span>
                                    <input type="text" name="urun-ad" maxlength="100" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Örn: Serpme Kahvaltı" required />
                                </label>

                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ürün Açıklama</span>
                                    <textarea name="urun-aciklama" maxlength="400" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" placeholder="Örn İçerik: Beyaz peynir, Taze kaşar Peyniri..."></textarea>
                                </label>


                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Ürün Kategori
                                    </span>
                                    <select name="urun-kategori" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                        <?php
                                        $sorgu = $db->prepare("SELECT * FROM kategori_tablosu ORDER BY kategori_id ASC");
                                        $sorgu->execute();
                                        foreach ($sorgu as $cikti) {
                                            $kaid = $cikti["kategori_id"];
                                            $kaad = $cikti["kategori_ad"];
                                            echo "<option value='$kaid'>$kaad</option>";
                                        }
                                        ?>
                                    </select>
                                </label>

                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ürün Fiyat </span>
                                    <input type="text" name="urun-fiyat" maxlength="5" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Örn: 12.30" required />
                                </label>
                                <label class="block text-sm mt-4">
                                    <span class="text-gray-700 dark:text-gray-400">Ürün Resim </span>
                                    <input type="file" name="urun-resim" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required />
                                </label>
                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ürün Sıra </span>
                                    <input type="text" name="urun-sira" maxlength="3" placeholder="Boş Bırakırsanız Varsayılan Sıra: '999' olarak ayarlanır." class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>

                                <label class="block text-sm mt-4">
                                    <input type="submit" class="block w-full mt-1 bg-purple-600 text-sm text-white dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                            </form>
                            <?php echo $not; ?>
                        </div>
                    </div>
                </div>


            </main>
        </div>
    </div>
</body>

</html>