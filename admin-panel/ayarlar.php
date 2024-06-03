<?php
 
try {

	$db = new PDO("mysql:host=localhost;dbname=garson-menu",'root','');
	$db->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
	
} catch (PDOException $e) {
	echo 'Hata: '.$e->getMessage();
}
 ?>