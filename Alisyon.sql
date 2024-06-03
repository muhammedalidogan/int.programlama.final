-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 07 Kas 2022, 18:42:38
-- Sunucu sürümü: 5.7.31
-- PHP Sürümü: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `gefqrv6`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin_tablo`
--

DROP TABLE IF EXISTS `admin_tablo`;
CREATE TABLE IF NOT EXISTS `admin_tablo` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_ad` varchar(30) NOT NULL,
  `admin_kad` varchar(30) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_sifre` varchar(60) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `admin_tablo`
--

INSERT INTO `admin_tablo` (`admin_id`, `admin_ad`, `admin_kad`, `admin_email`, `admin_sifre`) VALUES
(1, 'Emre', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `garson_tablosu`
--

DROP TABLE IF EXISTS `garson_tablosu`;
CREATE TABLE IF NOT EXISTS `garson_tablosu` (
  `garson_id` int(11) NOT NULL AUTO_INCREMENT,
  `garson_masa_no` int(4) NOT NULL,
  PRIMARY KEY (`garson_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `garson_tablosu`
--

INSERT INTO `garson_tablosu` (`garson_id`, `garson_masa_no`) VALUES
(9, 1),
(10, 2),
(11, 7),
(12, 8),
(13, 56);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori_tablosu`
--

DROP TABLE IF EXISTS `kategori_tablosu`;
CREATE TABLE IF NOT EXISTS `kategori_tablosu` (
  `kategori_id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_ad` varchar(50) NOT NULL,
  `kategori_sira` int(3) NOT NULL,
  PRIMARY KEY (`kategori_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kategori_tablosu`
--

INSERT INTO `kategori_tablosu` (`kategori_id`, `kategori_ad`, `kategori_sira`) VALUES
(1, 'Kahvaltılar', 1),
(2, 'Tostlarımız', 2),
(5, 'Atıştırmalıklar', 3),
(6, 'Burger', 4),
(7, 'Wrap', 5);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `site_bilgi_tablosu`
--

DROP TABLE IF EXISTS `site_bilgi_tablosu`;
CREATE TABLE IF NOT EXISTS `site_bilgi_tablosu` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_baslik` varchar(50) NOT NULL,
  `site_baslik_2` varchar(75) NOT NULL,
  `site_aciklama` varchar(125) NOT NULL,
  `site_telefon` varchar(15) DEFAULT NULL,
  `site_email` varchar(60) DEFAULT NULL,
  `site_logo` varchar(22) NOT NULL,
  `site_favicon` varchar(22) NOT NULL,
  `site_footer_aciklama` varchar(150) DEFAULT NULL,
  `site_facebook` varchar(70) DEFAULT NULL,
  `site_instagram` varchar(70) DEFAULT NULL,
  `site_youtube` varchar(70) DEFAULT NULL,
  `site_twitter` varchar(70) DEFAULT NULL,
  `site_gorsel` varchar(20) NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `site_bilgi_tablosu`
--

INSERT INTO `site_bilgi_tablosu` (`site_id`, `site_baslik`, `site_baslik_2`, `site_aciklama`, `site_telefon`, `site_email`, `site_logo`, `site_favicon`, `site_footer_aciklama`, `site_facebook`, `site_instagram`, `site_youtube`, `site_twitter`, `site_gorsel`) VALUES
(1, 'Gefsoft QRmenuV6', 'Gefsoft', 'Bu kısım google tarafında gözüken meta-description kısmıdır.', '0555 555 5555', 'deneme@gefsoft.com', '337153112.png', '1066453323.png', 'Footer Yazı Alanı bu kısmı Sayfa Ayarları kısmından düzenleyebilirsiniz.', 'qrmenufacebook', 'qrmenuinstagram', 'qrmenuyt', 'qrmenutw', '971522457.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_tablosu`
--

DROP TABLE IF EXISTS `urun_tablosu`;
CREATE TABLE IF NOT EXISTS `urun_tablosu` (
  `urun_id` int(11) NOT NULL AUTO_INCREMENT,
  `urun_ad` varchar(100) NOT NULL,
  `urun_aciklama` varchar(400) DEFAULT NULL,
  `urun_kategori` int(3) NOT NULL,
  `urun_fiyat` varchar(5) NOT NULL,
  `urun_gorsel` varchar(50) NOT NULL,
  `urun_sira` int(3) NOT NULL DEFAULT '999',
  PRIMARY KEY (`urun_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `urun_tablosu`
--

INSERT INTO `urun_tablosu` (`urun_id`, `urun_ad`, `urun_aciklama`, `urun_kategori`, `urun_fiyat`, `urun_gorsel`, `urun_sira`) VALUES
(1, 'Serpme Kahvaltı', 'Beyaz Peynir, taze kaşar peyniri, kızarmış hellim peyniri, otlu peynir, tulum peynir', 1, '69.00', '1476880282.png', 2),
(7, 'Günün Çorbası', 'Lütfen servis personeline sorunuz.', 1, '9.50', '614429807.jpg', 3),
(4, 'Kaşarlı Tost', ' ', 2, '12.50', '1782129920.png', 1),
(8, 'Parmak Patates', '', 5, '13.00', '1866968740.png', 1),
(9, 'Klasik Burger', '150 gr burger köfte, göbek salata, domates, soğan halkaları, patates kızartması.', 6, '25.00', '1938830170.png', 1),
(10, 'Steak Wrap', 'Tortilla ekmeğinde, kaşar peyniri, julyen dana bonfile, köy biberi, kapya biberi, mantar.', 7, '35.00', '1860368067.png', 1),
(12, 'Köfteli Wrap', 'Tortilla ekmeğinde, kaşar peyniri, köfte, soğan, renkli biber, yeşillik, domates, mantar, patates kızartması.', 7, '27.00', '2084143046.png', 2),
(13, 'Ayvalık Tostu', '', 2, '19.00', '262865639.png', 2),
(14, 'Muhlama', 'Kolot peyniri, trabzon tereyağı, çeçil peyniri, çifte kavrulmuş mısır unu', 1, '19.00', '238335600.png', 1),
(16, 'Sucuklu Tost', 'Sucuk, Tereyağ', 2, '23.50', '9155974.png', 3),
(17, 'MajoR Burger', 'MajoR Köfte', 6, '11.99', '781172472.png', 1),
(18, 'Zap Burger', 'Peynir', 6, '24.50', '2126673341.png', 8);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
