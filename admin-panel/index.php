<?php
include("login-kontrol.php");
$kkategorisorgu = "SELECT * FROM kategori_tablosu";
$ktoplamsonuc = $db->query($kkategorisorgu, PDO::FETCH_ASSOC);
$kkategori = $ktoplamsonuc->rowCount();

$urunsorgu = "SELECT * FROM urun_tablosu";
$utoplamsonuc = $db->query($urunsorgu, PDO::FETCH_ASSOC);
$urunsayisi = $utoplamsonuc->rowCount();

$sitesorgu = $db->prepare("SELECT * FROM site_bilgi_tablosu");
$sitesorgu->execute();
$sitecikti = $sitesorgu->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>| Admin Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="./assets/js/init-alpine.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
  <script src="./assets/js/charts-lines.js" defer></script>
  <script src="./assets/js/charts-pie.js" defer></script>
</head>

<body>
  <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
    <!-- Desktop sidebar -->
    <?php include("sidebar.php"); ?>

    <div class="flex flex-col flex-1 w-full">
      <?php include("header.php"); ?>
      <main class="h-full mt-4 overflow-y-auto">
        <div class="container px-6 mx-auto grid">
           <!-- CTA -->
           <?php if ($garsonbekleyen >= 1) : ?>
           <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple" href="garson-bekleyen.php">
            <div class="flex items-center">
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                </path>
              </svg>
              <span>Masa 
              <?php 
                  $sorgu = "SELECT * FROM garson_tablosu ORDER BY garson_masa_no ASC";
                  $sonuc = $db->query($sorgu, PDO::FETCH_ASSOC);
                  foreach ($sonuc as $satir) {
                    $masa=$satir["garson_masa_no"];
                    echo"$masa - " ;
                  }
              ?>  
              Garson Bekliyor...</span>
            </div>
            <span>Devam Et &RightArrow;</span>
          </a>
          <?php endif; ?>
          <!-- Cards -->
          <div class="grid gap-6 mb-8  md:grid-cols-2 xl:grid-cols-2">
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                  </path>
                </svg>
              </div>
              <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                  Toplam Kategori Sayısı
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                  <?php echo "$kkategori"; ?>
                </p>
              </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
              </div>
              <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                  Ürün Sayısı
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                  <?php echo "$urunsayisi"; ?>
                </p>
              </div>
            </div>
          </div>
          <!-- Site Ayarları -->
          <div class="px-4 py-3 mb-8 bg-white rounded-lg  text-center shadow-md dark:bg-gray-800">
            <p class="text-lg text-gray-600 font-bold dark:text-gray-400">
              Sayfa Bilgileri
            </p>
          </div>

          <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                Sayfa Başlık
              </h4>
              <p class="text-gray-600 dark:text-gray-400">
                <?php echo $sitecikti["site_baslik"]; ?>
              </p>
            </div>
            <div class="min-w-0 p-4 text-white bg-purple-600 rounded-lg shadow-xs">
              <h4 class="mb-4 font-semibold">
               Ana Sayfa Açıklama
              </h4>
              <p>
                <?php echo $sitecikti["site_aciklama"]; ?>
              </p>
            </div>
          </div>

          <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 text-white bg-purple-600 rounded-lg shadow-xs">
              <h4 class="mb-4 font-semibold">
                Sayfa Logo
              </h4>
              <p>
                <img src="../images/<?php echo $sitecikti["site_logo"]; ?>" alt="">
              </p>
            </div>

            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                Sayfa Favicon
              </h4>
              <p class="text-gray-600 dark:text-gray-400">
                <img src="../images/<?php echo $sitecikti["site_favicon"]; ?>" alt="">
              </p>
            </div>

          </div>

          <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-600 bg-white rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple" href="sayfa-ayarlari.php">
            <div class="flex items-center">
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                </path>
              </svg>
              <span>Sayfa Ayarlarını Düzenle...</span>
            </div>
            <span>Devam Et &RightArrow;</span>
          </a>

        </div>
      </main>
    </div>
  </div>
</body>

</html>