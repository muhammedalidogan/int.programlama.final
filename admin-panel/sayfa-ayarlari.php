<?php
include("login-kontrol.php");
$not = "";
$not2 = "";

$sitesorgu = $db->prepare("SELECT * FROM site_bilgi_tablosu");
$sitesorgu->execute();
$sitecikti = $sitesorgu->fetch(PDO::FETCH_ASSOC);
$logo = $sitecikti["site_logo"];
$favicon = $sitecikti["site_favicon"];
$sayfagorsel = $sitecikti["site_gorsel"];
if (isset($_POST["sayfa-bilgi-dz"])) {

    $sbaslik = htmlspecialchars($_POST["sayfa-baslik"]);
    $sbaslik2 = htmlspecialchars($_POST["sayfa-baslik-2"]);
    $saciklama = htmlspecialchars($_POST["sayfa-aciklama"]);
    $stelefon = htmlspecialchars(trim($_POST["sayfa-telefon"]));
    $temail = htmlspecialchars(trim($_POST["sayfa-email"]));
    $sfooteraciklama = htmlspecialchars($_POST["sayfa-footer"]);
    $sfacebook = htmlspecialchars($_POST["sayfa-facebook"]);
    $sinstagram = htmlspecialchars($_POST["sayfa-instagram"]);
    $syoutube = htmlspecialchars($_POST["sayfa-youtube"]);
    $stwitter = htmlspecialchars($_POST["sayfa-twitter"]);
    $sekle = $db->prepare("UPDATE site_bilgi_tablosu SET site_baslik=?,site_baslik_2=?,site_aciklama=?,site_telefon=?,site_email=?,site_footer_aciklama=?,site_facebook=?,site_instagram=?,site_youtube=?,site_twitter=? WHERE site_id=1");
    $sekle->execute([$sbaslik, $sbaslik2, $saciklama, $stelefon, $temail, $sfooteraciklama, $sfacebook, $sinstagram, $syoutube, $stwitter]);
    if ($sekle) {
        header("Location:sayfa-ayarlari.php");
    } else {
        $not = "<div class='alert alert-success text-center font-weight-bold' role='alert'>Sayfa Bilgileri Güncellenemedi.</div>";
        header("refresh:2;sayfa-ayarlari.php");
    }
}

// LOGO DÜZENLE
if (isset($_POST["logo-dz"])) {
    unlink("../images/$logo");
    $yol = '../images/';
    $tmp_name = $_FILES['logo-img']['tmp_name'];
    $name = $_FILES['logo-img']['name'];
    $isim = mt_rand();
    $ext = pathinfo($_FILES['logo-img']['name'], PATHINFO_EXTENSION);
    $yeniad = $isim . "." . $ext;
    $tip = $_FILES['logo-img']['type'];
    if (strlen($name) == 0) {
        $not2 = "<div class='alert alert-info text-center font-weight-bold' role='alert'>Bir resim seçiniz</div>";
    }
    if ($tip != 'image/jpeg' && $tip != 'image/png' && $tip != 'image/jpg') {
        $not2 = "<div class='alert alert-danger text-center font-weight-bold' role='alert'>Yalnızca jpg,Jpeg ve png formatında olabilir.</div>";
    }
    move_uploaded_file($tmp_name, "$yol/$yeniad");

    $guncelle = $db->prepare("UPDATE site_bilgi_tablosu SET site_logo=? WHERE site_id=1");
    $guncelle->execute([$yeniad]);
    if ($guncelle) {
        header("Location:sayfa-ayarlari.php");
    }
}


// FAVİCON DÜZENLE
if (isset($_POST["favicon-dz"])) {
    unlink("../images/$favicon");
    $yol = '../images/';
    $tmp_name = $_FILES['favicon-img']['tmp_name'];
    $name = $_FILES['favicon-img']['name'];
    $isim = mt_rand();
    $ext = pathinfo($_FILES['favicon-img']['name'], PATHINFO_EXTENSION);
    $yeniad = $isim . "." . $ext;
    $tip = $_FILES['favicon-img']['type'];
    if (strlen($name) == 0) {
        $not2 = "<div class='alert alert-info text-center font-weight-bold' role='alert'>Bir resim seçiniz</div>";
    }
    if ($tip != 'image/jpeg' && $tip != 'image/png' && $tip != 'image/jpg') {
        $not2 = "<div class='alert alert-danger text-center font-weight-bold' role='alert'>Yalnızca jpg,Jpeg ve png formatında olabilir.</div>";
    }
    move_uploaded_file($tmp_name, "$yol/$yeniad");

    $guncelle = $db->prepare("UPDATE site_bilgi_tablosu SET site_favicon=? WHERE site_id=1");
    $guncelle->execute([$yeniad]);
    if ($guncelle) {
        header("Location:sayfa-ayarlari.php");
    }
}

// SAYFA GÖRSEL DÜZENLE
if (isset($_POST["sayfa-dz"])) {
    unlink("../images/$sayfagorsel");
    $yol = '../images/';
    $tmp_name = $_FILES['sayfa-img']['tmp_name'];
    $name = $_FILES['sayfa-img']['name'];
    $isim = mt_rand();
    $ext = pathinfo($_FILES['sayfa-img']['name'], PATHINFO_EXTENSION);
    $yeniad = $isim . "." . $ext;
    $tip = $_FILES['sayfa-img']['type'];
    if (strlen($name) == 0) {
        $not2 = "<div class='alert alert-info text-center font-weight-bold' role='alert'>Bir resim seçiniz</div>";
    }
    if ($tip != 'image/jpeg' && $tip != 'image/png' && $tip != 'image/jpg') {
        $not2 = "<div class='alert alert-danger text-center font-weight-bold' role='alert'>Yalnızca jpg,Jpeg ve png formatında olabilir.</div>";
    }
    move_uploaded_file($tmp_name, "$yol/$yeniad");

    $guncelle = $db->prepare("UPDATE site_bilgi_tablosu SET site_gorsel=? WHERE site_id=1");
    $guncelle->execute([$yeniad]);
    if ($guncelle) {
        header("Location:sayfa-ayarlari.php");
    }
}
?>


<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sayfa Ayarları</title>
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
        <!-- Desktop sidebar -->
        <?php include("sidebar.php"); ?>
        <div class="flex flex-col flex-1">
            <?php include("header.php"); ?>
            <main class="h-full pb-16 overflow-y-auto">


                <div class="container px-6 mx-auto grid">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        &RightArrow; Sayfa Ayarları
                    </h2>
                    <!-- General elements -->
                    <div class="grid gap-6 mb-8 md:grid-cols-2">
                        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                            <h4 class="mb-4  text-center font-semibold text-gray-600 dark:text-gray-300">
                                Sayfa Bilgileri Güncelle
                            </h4>
                            <form enctype="multipart/form-data" class="text-center" method="POST">
                                <label class="block text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">&RightArrow; Sayfa Başlık </span>
                                    <input type="text" name="sayfa-baslik" value="<?php echo $sitecikti["site_baslik"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required />
                                </label>
                                <label class="block text-sm mt-2">
                                    <span class="text-gray-700 dark:text-gray-400">&RightArrow; Sayfa İçi Başlık </span>
                                    <input type="text" name="sayfa-baslik-2" value="<?php echo $sitecikti["site_baslik_2"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required />
                                </label>

                                <label class="block text-sm mt-2">
                                    <span class="text-gray-700 dark:text-gray-400">&RightArrow; Sayfa Açıklama </span>
                                    <input type="text" name="sayfa-aciklama" value="<?php echo $sitecikti["site_aciklama"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required />
                                </label>

                                <label class="block text-sm mt-2">
                                    <span class="text-gray-700 dark:text-gray-400">&RightArrow; Telefon Numarası (Boş bırakırsanız eğer Telefon alanı pasif olacaktır.) </span>
                                    <input type="text" name="sayfa-telefon" value="<?php echo $sitecikti["site_telefon"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>

                                <label class="block text-sm mt-2">
                                    <span class="text-gray-700 dark:text-gray-400">&RightArrow; E Mail adresi (Boş bırakırsanız eğer Mail alanı pasif olacaktır.) </span>
                                    <input type="email" name="sayfa-email" value="<?php echo $sitecikti["site_email"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                <br>
                                <hr>
                                <br>
                                <label class="block text-sm mt-2 mb-4">
                                    <span class="text-gray-700 dark:text-gray-400"> <b> Footer Yazı Alanı</b></span>
                                    <textarea name="sayfa-footer" maxlength="150" rows="3" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"><?= $sitecikti["site_footer_aciklama"]; ?></textarea>
                                </label>
                                <br>
                                <hr>
                                <br>
                                <b> Sosyal Medya Adresleri</b> <br> Boş bırakırsanız Footer kısmında pasif hale getirebilirsiniz.
                                <label class="block text-sm  mt-2">
                                    <span class="text-gray-700 dark:text-gray-400">&RightArrow; Facebook Adresi</span>
                                    <input type="text" name="sayfa-facebook" value="<?php echo $sitecikti["site_facebook"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                <label class="block text-sm  mt-2">
                                    <span class="text-gray-700 dark:text-gray-400">&RightArrow; İnstagram Adresi</span>
                                    <input type="text" name="sayfa-instagram" value="<?php echo $sitecikti["site_instagram"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                <label class="block text-sm  mt-2">
                                    <span class="text-gray-700 dark:text-gray-400">&RightArrow; Youtube Adresi</span>
                                    <input type="text" name="sayfa-youtube" value="<?php echo $sitecikti["site_youtube"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                <label class="block text-sm  mt-2">
                                    <span class="text-gray-700 dark:text-gray-400">&RightArrow; Twitter Adresi</span>
                                    <input type="text" name="sayfa-twitter" value="<?php echo $sitecikti["site_twitter"]; ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                                <label class="block text-sm mt-2">
                                    <input type="submit" name="sayfa-bilgi-dz" value="Kaydet" class="block w-full mt-1 bg-purple-600 text-sm text-white dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                            </form>
                            <?php echo $not; ?>
                        </div>
                        <!-- SOSYAL MEDYA FORM -->

                        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                            <h4 class="mb-4  text-center font-semibold text-gray-600 dark:text-gray-300">
                                Diğer Sayfa Ayarları
                            </h4>
                            <form enctype="multipart/form-data" method="POST">
                                <label class="block text-sm mt-2">
                                    <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">&RightArrow; Logo Değiştir </h4>
                                    <input type="file" name="logo-img" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required />
                                </label>
                                <label class="block text-sm mt-2">
                                    <input type="submit" name="logo-dz" class="block w-full mt-1 bg-purple-600 text-sm text-white dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400  focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                            </form>
                            <h4 class="mt-4  text-center font-semibold text-gray-400 dark:text-gray-300">
                                Mevcut Site Logo
                                <center> <img src="../images/<?php echo $logo ?>" alt=""></center>
                            </h4>
                            <hr class="mt-4">

                            <form enctype="multipart/form-data" method="POST">
                                <label class="block text-sm mt-2">
                                    <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">&RightArrow; Favicon Değiştir </h4>
                                    <input type="file" name="favicon-img" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required />
                                </label>
                                <label class="block text-sm mt-2">
                                    <input type="submit" name="favicon-dz" class="block w-full mt-1 bg-purple-600 text-sm text-white dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400  focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                            </form>
                            <h4 class="mt-4  text-center font-semibold text-gray-400 dark:text-gray-300">
                                Mevcut Site Favicon
                                <center> <img src="../images/<?php echo $favicon ?>" alt=""></center>
                            </h4>
                            <hr class="mt-4">

                            <form enctype="multipart/form-data" method="POST">
                                <label class="block text-sm mt-2">
                                    <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">&RightArrow; Sayfa Görsel Değiştir </h4>
                                    <input type="file" name="sayfa-img" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required />
                                </label>
                                <label class="block text-sm mt-2">
                                    <input type="submit" name="sayfa-dz" class="block w-full mt-1 bg-purple-600 text-sm text-white dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400  focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                </label>
                            </form>
                            <h4 class="mt-4  text-center font-semibold text-gray-400 dark:text-gray-300">
                                Mevcut Sayfa Görsel
                                <center> <img src="../images/<?php echo $sayfagorsel ?>" alt=""></center>
                            </h4>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>

</html>