<?php
include("login-kontrol.php");
if (!empty($_POST["garson_id"]) && is_numeric($_POST["garson_id"])) {
    $id = htmlspecialchars($_POST["garson_id"]);
    try {
        $sorgu = "DELETE FROM garson_tablosu WHERE garson_id=:id";
        $sonuc = $db->prepare($sorgu);
        $sonuc->bindParam(":id", $id, PDO::PARAM_INT);
        $sonuc->execute();
        header("Location:garson-bekleyen.php");
    } catch (PDOException $ex) {
        $hata = $ex->getMessage();
        header("Location:garson-bekleyen.php");
    }
} else {
    header("Location:garson-bekleyen.php");
}
