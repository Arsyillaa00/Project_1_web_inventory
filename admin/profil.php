<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Detail Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.js"></script>
    </head>
    <body class="d-flex justify-content-between">
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
        $form_name = $_GET['db']??"";
        switch($form_name){
            case 'user':
                $profil = detail_user($db,$id);
                $nama = $profil['nama'];
                $email = $profil['email'];
                $status = get_status($db,$profil['status'])['title']??'';
            break;
            case 'products':
                $list_status = array("tidak aktif", "aktif");

                $profil = detail_products($db,$id);
                $nama_products = $profil['nama_products'];
                $harga = $profil['harga'];
                $total = $profil['total'];
                $status = $list_status[(int)$profil['status']];
                $date_c = date("Y-m-d", $profil['date_c']);
                $date_m = date("Y-m-d", $profil['date_m']);
            break;
            case 'status':
                $profil = detail_status($db,$id);
                $title = $profil['title'];
                $level = $profil['level'];
            break;
        }

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