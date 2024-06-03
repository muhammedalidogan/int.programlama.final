<?php
include("login-kontrol.php");
$not = "";
$not2 = "";
$id = $_GET["id"];
$sorgu = $db->prepare("SELECT * FROM urun_tablosu WHERE urun_id=:id");
$sorgu->execute(array(":id" => $id));
$row = $sorgu->fetch(PDO::FETCH_ASSOC);
$ukat = $row["urun_kategori"];
$kresim = $row["urun_gorsel"];
// Başlık Düzenleme
if (isset($_POST["urun-duzenle"])) {
    $uad = $_POST["urun-ad"];
    $uaciklama = $_POST["urun-aciklama"];
    $ukategori = $_POST["urun-kategori"];
    $ufiyat = $_POST["urun-fiyat"];
    $guncelle = $db->prepare("UPDATE urun_tablosu SET urun_ad=?,urun_aciklama=?,urun_kategori=?,urun_fiyat=? WHERE urun_id=?");
    $guncelle->execute([$uad, $uaciklama, $ukategori, $ufiyat, $id]);
    if ($guncelle) {
        header("Location:urun-listesi.php");
    }
}
// Resim Düzenleme
if (isset($_POST["resim-duzenle"])) {
    unlink("../images/urunler/$kresim");
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

    $guncelle = $db->prepare("UPDATE urun_tablosu SET urun_gorsel=? WHERE urun_id=?");
    $guncelle->execute([$yeniad, $id]);
    if ($guncelle) {
        header("Location:urun-listesi.php");
    }
}

?>


<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ürün Düzenle</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="./assets/js/init-alpine.js"></script>
</head>

<body>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen}">
        <?php include("sidebar.php"); ?>
        <div class="flex flex-col flex-1">
            <?php include("header.php"); ?>
            <main class="h-full pb-16 overflow-y-auto">
                <div class="container px-6 mx-auto grid ">
                    <h2 class="my-6 text-2xl font-semibold  text-gray-700 dark:text-gray-200">
                        &RightArrow; Ürün Düzenle
                    </h2>

                    <div class="grid gap-6 mb-8 md:grid-cols-2">
                        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                            <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                                Ürün Bilgilerini Düzenle
                            </h4>
                            <form method="POST">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ürün Ad </span>
                                    <input type="text" name="urun-ad" maxlength="100" value="<?php echo $row["urun_ad"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>

                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ürün Açıklama</span>
                                    <textarea name="urun-aciklama" maxlength="400" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="5"><?php echo $row["urun_aciklama"]; ?></textarea>
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
                                            if($ukat==$kaid){
                                                echo "<option value='$kaid' selected>$kaad</option>";
                                            }else{
                                                echo "<option value='$kaid'>$kaad</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </label>
                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ürün Fiyat </span>
                                    <input type="text" name="urun-fiyat" maxlength="5" value="<?php echo $row["urun_fiyat"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                <label class="block text-sm mt-2">
                                    <input type="submit" name="urun-duzenle" class="block w-full mt-1 bg-purple-600 text-sm text-white dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                            </form>
                            <?php echo $not; ?>
                        </div>
                        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                            <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                                Ürün Resmini Düzenle
                            </h4>
                            <form method="POST" enctype="multipart/form-data">
                                <label class="block text-sm mt-2">
                                    <span class="text-gray-700 dark:text-gray-400">Ürün Resim </span>
                                    <input type="file" name="urun-resim" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                <label class="block text-sm mt-2">
                                    <input type="submit" name="resim-duzenle" class="block w-full mt-1 bg-purple-600 text-sm text-white dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                            </form>
                            <?php echo $not2; ?>
                            <img src="../images/urunler/<?php echo $kresim; ?>" class="mt-4 rounded-md w-full object-cover" alt="">
                        </div>
                    </div>
                </div>


            </main>
        </div>
    </div>
</body>

</html>