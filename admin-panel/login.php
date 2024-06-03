<?php
ob_start();
session_start();
if ($_POST) {
  if (!empty($_POST["admin-ad"]) && !empty($_POST["admin-sifre"])) {
    $ad = htmlspecialchars($_POST["admin-ad"]);
    $ads = htmlspecialchars($_POST["admin-sifre"]);
    try {
      include_once("ayarlar.php");

      $sorgu = "SELECT * FROM admin_tablo WHERE admin_kad=:ad AND admin_sifre=:ads";
      $sonuc = $db->prepare($sorgu);
      $sonuc->bindParam(":ad", $ad, PDO::PARAM_STR);
      $ads = md5($ads);
      $sonuc->bindParam(":ads", $ads, PDO::PARAM_STR);
      $sonuc->execute();

      if ($sonuc->rowCount() == 1) {
        $_SESSION['adminbilgi'] = $ad;
        echo "<div class='alert success'>Başarılı bir şekilde giriş yaptınız. Anasayfaya Yönlendiriliyorsunuz lütfen bekleyiniz.</div>";
        header("refresh:2;index.php");
      } else {
        echo "<div class='alert'>Kullanıcı bilgileri Hatalı ! . Lütfen Tekrar Deneyiniz.</div>";
        header("refresh:2;login.php");
      }
    } catch (PDOException $ex) {
      $hata = $ex->getMessage();
      echo "<div class='alert'>Bir hata ile karşılaşıldı. Daha sonra tekrar deneyiniz.</div>";
      header("refresh:2;index.php");
    }
  } else {
    echo "<div class='alert'>Lütfen Giriş Yapınız.</div>";
    header("refresh:2;login.php");
  }
}
?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MUDO CAFE - QR Menü</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/tailwind.output.css" />
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="assets/js/init-alpine.js"></script>
  <style>
    .alert {
      padding: 20px;
      background-color: #f44336;
      color: white;
      text-align: center;
    }
    .alert.success {background-color: #04AA6D;}
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
  <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
    <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
      <div class="flex flex-col overflow-y-auto md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
          <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="assets/img/login-office.jpeg" alt="Office" />
          <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="assets/img/login-office-dark.jpeg" alt="Office" />
        </div>
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
          <div class="w-full">
            <h1 class="mb-4 text-xl text-center font-semibold text-gray-700 dark:text-gray-200">
              Giriş Yap
            </h1>
            <form action="#" method="POST">
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Kullanıcı Adı</span>
                <input type="text" name="admin-ad" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required />
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Parola</span>
                <input type="password" name="admin-sifre" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" type="password" required />
              </label>

              <!-- You should use a button here, as the anchor is only used for the example  -->
              <input type="submit" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" name="" id="">
            </form>
            <hr class="my-8" />


            <p class="mt-4 text-center">
              <a class="text-sm font-medium  text-purple-600 dark:text-purple-400 hover:underline" href="../index">
                Ana Sayfaya Git
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>