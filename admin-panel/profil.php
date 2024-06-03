<?php
include("login-kontrol.php");
$not2 = "";
$not3 = "";
// SOSYAL MEDYA HESAP AYARLAR
$adminsorgu = $db->prepare("SELECT * FROM admin_tablo");
$adminsorgu->execute();
$admincikti = $adminsorgu->fetch(PDO::FETCH_ASSOC);
$adminsifre = $admincikti["admin_sifre"];
if (isset($_POST["admin-bilgileri"])) {

  $adminad = htmlspecialchars($_POST["admin-ad"]);
  $adminkad = htmlspecialchars($_POST["admin-kad"]);
  $adminemail = htmlspecialchars($_POST["admin-email"]);

  $sekle = $db->prepare("UPDATE admin_tablo SET admin_ad=?,admin_kad=?,admin_email=? WHERE admin_id=1");
  $sekle->execute([$adminad, $adminkad, $adminemail]);
  if ($sekle) {

    $not2 = "<div class='alert success'>Başarılı Bir şekilde güncellenmiştir. Lütfen Bekleyiniz.</div>";
    header("refresh:2;profil.php");
  } else {
    $not2 = "<div class='alert alert-success text-center font-weight-bold' role='alert'>Güncellenemedi.</div>";
    header("refresh:2;profil.php");
  }
}

// Admin Şifre Değiştir
if (isset($_POST["sifre-degistir"])) {
  $aktifsifre = md5($_POST["aktif-sifre"]);
  $yenisifre = md5($_POST["yeni-sifre"]);
  $yenisifretekrar = md5($_POST["yeni-sifre-tekrar"]);
  if ($aktifsifre == $adminsifre) {
    if ($yenisifre == $yenisifretekrar) {

      $sekle = $db->prepare("UPDATE admin_tablo SET admin_sifre=? WHERE admin_id=1");
      $sekle->execute([$yenisifre]);
      if ($sekle) {

        $not3 = "<div class='alert success'>Başarılı Bir şekilde güncellenmiştir. Lütfen Bekleyiniz.</div>";
        header("refresh:2;exit.php");
      } else {
        $not3 = "<div class='alert alert-success text-center font-weight-bold' role='alert'>Güncellenemedi.</div>";
        header("refresh:2;profil.php");
      }
    } else {
      $not3 = "<div class='alert alert-success text-center font-weight-bold' role='alert'>Yeni Şifreler Birbirine Uyuşmuyor.</div>";
      header("refresh:2;profil.php");
    }
  } else {
    $not3 = "<div class='alert alert-success text-center font-weight-bold' role='alert'>Mevcut Şifreniz Hatalı.</div>";
    header("refresh:2;profil.php");
  }
}
?>


<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Ayarları</title>
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
          <h2 class="my-6 text-2xl font-semibold text-center text-gray-700 dark:text-gray-400">
            &RightArrow; Kullanıcı Ayarları &LeftArrow;
          </h2>

          <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <h4 class="mb-4  text-center font-semibold text-gray-600 dark:text-gray-300">
                Admin Kullanıcı Bilgileri Güncelle
              </h4>
              <form method="POST">
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Admin Adı</span>
                  <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                    <input type="text" name="admin-ad" value="<?php echo $admincikti["admin_ad"]; ?>" class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" />
                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                      </svg>
                    </div>
                  </div>
                </label>

                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Admin Kullanıcı Adı</span>
                  <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                    <input type="text" name="admin-kad" value="<?php echo $admincikti["admin_kad"]; ?>" class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" />
                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                      </svg>
                    </div>
                  </div>
                </label>

                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Admin E Mail Adresi</span>
                  <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                    <input type="text" name="admin-email" value="<?php echo $admincikti["admin_email"]; ?>" class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" />
                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                      </svg>
                    </div>
                  </div>
                </label>

                <label class="block text-sm mt-2">
                  <input type="submit" name="admin-bilgileri" class="block w-full mt-1 bg-purple-600 text-sm text-white dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                </label>
              </form>
              <?php echo $not2; ?>
            </div>
            <!-- SOSYAL MEDYA FORM -->

            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <h4 class="mb-4  text-center font-semibold text-gray-600 dark:text-gray-300">
                Admin Şifre Güncelle
              </h4>
              <form method="POST">
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Aktif Şifre</span>
                  <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                    <input type="password" name="aktif-sifre" maxlength="18" placeholder="Aktif Şifrenizi Giriniz" class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" required />
                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                      </svg>
                    </div>
                  </div>
                </label>

                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Yeni Şifre</span>
                  <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                    <input type="password" name="yeni-sifre" maxlength="18" placeholder="Maksimum 18 Karakter" class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" required/>
                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                      </svg>
                    </div>
                  </div>
                </label>

                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Yeni Şifre Tekrar</span>
                  <div class="relative text-gray-500 focus-within:text-purple-600 dark:focus-within:text-purple-400">
                    <input type="password" name="yeni-sifre-tekrar" maxlength="18" placeholder="Maksimum 18 Karakter" class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" required />
                    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                      </svg>
                    </div>
                  </div>
                </label>

                <label class="block text-sm mt-2">
                  <input type="submit" name="sifre-degistir" class="block w-full mt-1 bg-purple-600 text-sm text-white dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                </label>
              </form>
              <?php echo $not3; ?>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>

</html>