<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
    </body>
</html>


<?php


    //nyambungin file dashboard.php ke file controller.php
    require_once "../app/controller.php";
    
    //koneksi ke router php
    require_once "../app/router.php"; 


    //nyambungin file dashboard.php ke file login.php
    //include "../template/login.php";

    //panggil function mysql 
    $db = database();
    session_start();
    $id = $_GET['id']??0;
    //mengecheck session user
    if($id){
        $profil = detail_user($db,$id);
        $nama = $profil['nama'];
        $email = $profil['email'];
        $status = get_status($db,$profil['status'])['title']??'';

        //jika session tersimpan, perintah dibawah akan dijalankan, dan untuk menampilkan sidebar
        login_status($_SESSION);

        include "../template/profil.php";


    }else{ 
        //notifikasi saat profil tidak diketahui
        print "<script>alert('profil tidak diketahui!')</script>";

        //perintah untuk redirect
        header("Location: user.php");
    }



?>