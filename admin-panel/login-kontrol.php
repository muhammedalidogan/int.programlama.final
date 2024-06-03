<?php
ob_start();
session_start(); 
include("ayarlar.php"); 
if (!isset($_SESSION['adminbilgi'])){
 header("Location:login.php");
}
?>