<?php 
ob_start();
session_start();
#session_destroy();
unset($_SESSION['adminbilgi']);					
header("Location:login.php");
