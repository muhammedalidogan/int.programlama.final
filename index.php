<?php
session_start();
ob_start();
include("admin-panel/ayarlar.php");

// Site Bilgi Çekme
$sbilgisorgu = $db->prepare("SELECT * FROM site_bilgi_tablosu");
$sbilgisorgu->execute();
$sbilgicikti = $sbilgisorgu->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?= $sbilgicikti["site_baslik"]; ?></title>
	<meta name="description" content="<?= $sbilgicikti["site_aciklama"]; ?>">
	<link rel="icon" href="images/<?= $sbilgicikti["site_favicon"]; ?>" type="image/x-icon" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Monoton&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Miss+Fajardose&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
	<link rel="stylesheet" href="css/animate.css">

	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="css/magnific-popup.css">

	<link rel="stylesheet" href="css/aos.css">

	<link rel="stylesheet" href="css/ionicons.min.css">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/flaticon.css">
	<link rel="stylesheet" href="css/icomoon.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/sweetalert2.min.css">
	<script src="js/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body>
	<div class="py-1 bg-black top">
		<div class="container">
			<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
				<div class="col-lg-12 d-block">
					<div class="row d-flex">
						<div class="col-md-12 pr-4 d-flex topper align-items-center">
							<?php if (!$sbilgicikti["site_telefon"] == null) : ?>
								<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
								<span class="text"><a href="tel:<?= str_replace(" ", "", $sbilgicikti["site_telefon"]); ?>"><?= $sbilgicikti["site_telefon"]; ?></a></span>
							<?php endif; ?> &nbsp;&nbsp;&nbsp;
							<?php if (!$sbilgicikti["site_email"] == null) : ?>
								<span class="text"><span class="icon-paper-plane mr-2"></span><a href="mailto:<?= $sbilgicikti["site_email"]; ?>"><?= $sbilgicikti["site_email"]; ?></a></span>
							<?php endif; ?>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>


	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="./"><img src="images/<?= $sbilgicikti["site_logo"]; ?>" alt="" class="img-fluid" width="150px"></a>
			<button class="button-75" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><span class="text">Garson Çağır</span></button></li>
			<?php
			if (isset($_POST["garson-cagir"])) {
				$masano = htmlspecialchars($_POST["masa-no"]);

				$kontrol = $db->prepare("SELECT * FROM garson_tablosu WHERE garson_masa_no=?");
				$kontrol->execute(array($masano));
				if ($kontrol->rowCount()) {
					echo '<script>Swal.fire("Masaya Garson Çağrılmış Gözüküyor.", "Lütfen sesli olarak garsonla iletişime geçiniz. ", "error"); </script>';
					header("refresh:3;./");
				} else {
					$gekle = $db->prepare("INSERT INTO garson_tablosu SET garson_masa_no=?");
					$gekle->execute([$masano]);
					if ($gekle) {
						echo '<script>Swal.fire("Garson Çağırma Talebiniz alındı.", "Hemen Geliyoruz. ", "success"); </script>';
						header("refresh:2;./");
					} else {
						echo '<script>Swal.fire("Masa Çağırma İsteğiniz Alınamadı.", "En Kısa sürede düzelteceğiz. ", "error"); </script>';
						header("refresh:2;./");
					}
				}
			}
			?>
		</div>
	</nav>
	<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="bi bi-arrow-up-short"></i></button>

	<!-- END nav -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header ">
					<h1 class="modal-title fs-5" id="exampleModalLabel"><img src="images/garson-icon.svg" width="24"> Garson Çağır</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body text-center">
					<form action="" method="POST">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1"> <img src="images/masa.svg" alt="" width="32"></span>
							</div>
							<input type="text" class="form-control" pattern="\d*" placeholder="Masa Numaranızı Giriniz" name="masa-no" aria-label="Username" aria-describedby="basic-addon1" maxlength="4" required>
						</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="garson-cagir" class="btn btn-success px-5">Çağır</button>
					</form>
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kapat</button>
				</div>
			</div>
		</div>
	</div>

	<section class="hero-wrap hero-wrap-2" style="background-image: url('images/<?php echo $sbilgicikti["site_gorsel"]; ?>');">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text align-items-end justify-content-center">
			</div>
		</div>
	</section>

	<section class="ftco-section">
		<div class="container-fluid px-4">
			<div class="row justify-content-center mb-5 pb-2">
				<div class="col-md-7 text-center heading-section ftco-animate">
					<span class="subheading"><?= $sbilgicikti["site_baslik_2"]; ?></span>
					<h2 class="mb-4">Menü</h2>
				</div>
			</div>
			<div class="row">
				<?php
				$sorgu = $db->prepare("SELECT * FROM kategori_tablosu ORDER BY kategori_sira ASC");
				$sorgu->execute();
				$sonuc = $sorgu->fetchAll(PDO::FETCH_ASSOC);
				foreach ($sonuc as $asatir) {
					$kid = $asatir["kategori_id"];
					$kad = $asatir["kategori_ad"];
					echo "
					<div class='col-md-6 col-lg-4 menu-wrap'>
						<div class='heading-menu text-center ftco-animate'>
							<h3>$kad</h3>
						</div>";
					$usorgu = "SELECT * FROM urun_tablosu WHERE urun_kategori=$kid ORDER BY urun_sira ASC";
					$usonuc = $db->query($usorgu, PDO::FETCH_ASSOC);
					foreach ($usonuc as $usatir) {
						$uad = $usatir["urun_ad"];
						$uaciklama = $usatir["urun_aciklama"];
						$ugorsel = $usatir["urun_gorsel"];
						$ufiyat = $usatir["urun_fiyat"];
						echo "
						<div class='menus d-flex ftco-animate'>
                        <div class='menu-img img' style='background-image: url(images/urunler/$ugorsel);'></div>
                        <div class='text'>
                            <div class='d-flex'>
                                <div class='one-half'>
                                    <h3>$uad</h3>
                                </div>
                                <div class='one-forth'>
                                    <span class='price'>$ufiyat ₺</span>
                                </div>
                            </div>
                            <p>$uaciklama</p>
                        </div>
                    </div>
						";
					}
					echo "</div>";
				}
				?>
			</div>
		</div>
	</section>

	<footer class="ftco-footer ftco-bg-dark ftco-section">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12">
					<div class="ftco-footer-widget text-center mb-4">
						<ul class="ftco-footer-social list-unstyled  mt-3">
							<?php if (!$sbilgicikti["site_twitter"] == null) : ?> <li class="ftco-animate"><a href="https://twitter.com/<?= $sbilgicikti["site_twitter"]; ?>" target="_blank"><span class="icon-twitter"></span></a></li><?php endif; ?>
							<?php if (!$sbilgicikti["site_facebook"] == null) : ?> <li class="ftco-animate"><a href="https://facebook.com/<?= $sbilgicikti["site_facebook"]; ?>" target="_blank"><span class="icon-facebook"></span></a></li><?php endif; ?>
							<?php if (!$sbilgicikti["site_instagram"] == null) : ?> <li class="ftco-animate"><a href="https://instagram.com/<?= $sbilgicikti["site_instagram"]; ?>" target="_blank"><span class="icon-instagram"></span></a></li><?php endif; ?>
							<?php if (!$sbilgicikti["site_youtube"] == null) : ?><li class="ftco-animate"><a href="https://youtube.com/<?= $sbilgicikti["site_youtube"]; ?>" target="_blank"><span class="icon-youtube"></span></a></li><?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<p><?= $sbilgicikti["site_footer_aciklama"]; ?></p>
				</div>
			</div>
		</div>
	</footer>

	<!-- loader -->
	<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
		</svg>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-migrate-3.0.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/jquery.stellar.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/aos.js"></script>
	<script src="js/jquery.animateNumber.min.js"></script>
	<script src="js/scrollax.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>