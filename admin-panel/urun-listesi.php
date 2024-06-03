<?php
include("login-kontrol.php");
$not = "";
if (isset($_POST['urun-sira'])) {
  $usira = $_POST["urun-sira"];
  $uid = $_POST["urun-id"];
  $siraguncelle = $db->prepare("UPDATE urun_tablosu SET urun_sira=? WHERE urun_id=?");
  $siraguncelle->execute([$usira, $uid]);
  if ($siraguncelle) {
    header("Location:urun-listesi.php");
  }
}

?>


<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ürün Listesi</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="./assets/js/init-alpine.js"></script>
  <style>
    .menu-resim:hover {
      -ms-transform: scale(4);
      /* IE 9 */
      -webkit-transform: scale(4);
      /* Safari 3-8 */
      transform: scale(4);
      transition: transform .2s;
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
          <h2 class="my-6 text-2xl text-center font-semibold  text-gray-700 dark:text-gray-400">
            &RightArrow; Ürün Listesi &LeftArrow;
          </h2>

          <div class="grid gap-6 mb-8">
            <div class="min-w-0 p-4 text-center rounded-lg shadow-xs">
              <h4 class="mb-4 font-semibold">
                Ürün Listesi
              </h4>
              <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                  <table class="w-full whitespace-no-wrap text-center">
                    <thead>
                      <tr class="text-xs font-semibold text-center tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Ad</th>
                        <th class="px-4 py-3">Açıklama</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Fiyat</th>
                        <th class="px-4 py-3">Görsel</th>
                        <th class="px-4 py-3">Ürün Sırası</th>
                        <th class="px-4 py-3">Düzenle/Sil</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                      <?php
                      $ksorgu = "SELECT * FROM kategori_tablosu";
                      $ksonuc = $db->query($ksorgu, PDO::FETCH_ASSOC);
                      foreach ($ksonuc as $ksatir) {
                        $kkid = $ksatir["kategori_id"];
                        $kad = $ksatir["kategori_ad"];
                        echo "<tr class='text-xs font-semibold text-center tracking-wide text-left bg-purple-600  text-white uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-white dark:bg-purple-600'><td class='px-4 py-3' colspan='8'>$kad</td></tr>";
                        $sorgu = "SELECT * FROM urun_tablosu WHERE urun_kategori=$kkid ORDER BY urun_sira ASC";
                        $sonuc = $db->query($sorgu, PDO::FETCH_ASSOC);
                        $ksira = 0;
                        foreach ($sonuc as $satir) {
                          $ksira += 1;
                          $uid = $satir["urun_id"];
                          $uad = $satir["urun_ad"];
                          $uaciklama = $satir["urun_aciklama"];
                          $ukategori = $satir["urun_kategori"];
                          $ufiyat = $satir["urun_fiyat"];
                          $ugorsel = $satir["urun_gorsel"];
                          $urunsira = $satir["urun_sira"];

                          $uaciklama = mb_substr($uaciklama, 0, 50) . "...";
                          echo "
                                                <tr class='text-gray-700 dark:text-gray-4'>

                                                <td class='px-4 py-3 text-xs'>
                                                  <span class='px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100'>
                                                    $ksira
                                                  </span>
                                                </td>
                                                <td class='px-4 py-3 text-sm dark:text-white'>$uad</td>
                                                <td class='px-4 py-3 text-sm dark:text-white'>
                                                $uaciklama
                                               </td>
                                               <td class='px-4 py-3 text-sm dark:text-white'> ";
                                                $asorgu = "SELECT * FROM kategori_tablosu ORDER BY kategori_id ASC";
                                                $asonuc = $db->query($asorgu, PDO::FETCH_ASSOC);
                                                foreach ($asonuc as $asatir) {
                                                  $akid = $asatir["kategori_id"];
                                                  if ($ukategori == $akid) {
                                                    echo $asatir["kategori_ad"];
                                                  }
                                                }

                                                echo
                                                "</td> 
                                               <td class='px-4 py-3 text-sm dark:text-white'>
                                               $ufiyat ₺
                                               </td>
                                               <td class='px-4 py-3'>
                                               <div class='flex items-center text-sm'>
                                                 <!-- Avatar with inset shadow -->
                                                 <div class='w-12 h-12 mr-3'>
                                                   <img class='object-cover w-full h-full rounded menu-resim' src='../images/urunler/$ugorsel' />
                                                 </div>
                                               </div>
                                             </td>
                                                <td class='px-4 py-3 text-sm dark:text-white'>
                                                <form method='POST'>
                                                <input type='hidden' value='$uid' name='urun-id'>
                                                <input type='text' name='urun-sira' value='$urunsira' size='1' maxlength='3' class='block  mt-1 text-center text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input'/>
                                                </form>
                                                </td>
                                                <td class='px-4 py-3'>
                                                  <div class='flex items-center space-x-4 text-sm'>
                                                  <a href='urun-duzenle.php?id=$uid''>
                                                    <button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' aria-label='Edit'>
                                                      <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
                                                        <path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'>
                                                        </path>
                                                      </svg>
                                                    </button>
                                                        </a>

                                                    <form method='POST' action='urun-sil.php'>
                                                    <input type='hidden' value='$uid' name='urun_id'>
                                                    <input type='hidden' value='$ugorsel' name='urun_resim'>
                                                    <button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' aria-label='Delete'>
                                                      <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
                                                        <path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path>
                                                      </svg>
                                                    </button>
                                                    </form>
                                                  </div>
                                                </td>
                                              </tr>
                                                ";
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>


      </main>
    </div>
  </div>
</body>

</html>