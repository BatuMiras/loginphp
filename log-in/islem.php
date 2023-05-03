<?php

ob_start();
session_start();

require 'baglan.php';

if(isset($_POST['kayit'])) {
    $username = @$_POST['username'];
    $password = @$_POST['password'];
    $password_again = @$_POST['password_again'];
    
    
    if(!$username){
        echo "Lütfen kullanıcı adınızı girin";
    } elseif(!$password || !$password_again){
        echo "Lütfen şifrenizi girin";
    } elseif($password != $password_again){
        echo "Girdiğiniz şifreler birbiri ile aynı değil";
    } else {
        //veritabanı kayıt işlemi
        $sorgu = $db->prepare('INSERT INTO users SET user_name = ?, user_password = ?');
        $ekle = $sorgu->execute([
            $username, $password
        ]);
        if($ekle){
            echo "Kayıt başarıyla gerçekleşti, yönlendiriliyorsunuz.";
            header('Refresh:2; index.php');
        } else {
            echo "Bir hata oluştu, Lütfen tekrar kontrol ediniz";
        }
    }
    
}


if(isset($_POST['giris'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(!$username){
        echo "Lütfen kullanıcı adınızı giriniz";
    } elseif(!$password){
        echo "Lütfen şifrenizi giriniz";
    } else{
        $kullanici_sor = $db->prepare('SELECT * FROM users WHERE user_name = ? && user_password = ?');
        $kullanici_sor->execute([
            $username, $password
        ]);
        
         $say = $kullanici_sor->rowCount();
        if($say==1){
            $_SESSİON['username']=$username;
            echo "Başarıyla giriş yaptınız, yönlendiriliyorsunuz";
            header('Refresh:2; main.php');
        }else {
            echo "Bir hata oluştu tekrar kontrol edin";
        }
    }
    
    
}















?>
