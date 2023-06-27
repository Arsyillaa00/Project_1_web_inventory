<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Project 2 - Inventory</title>
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

    //mengecheck session user
    if(isset($_SESSION['id_user'])){
        //jika session tersimpan, perintah dibawah akan dijalankan
        login_status($_SESSION);
        
        //check tabel user ada/tdk
        $user = check_tabel_user($db);
        if($user){
            //print "TABLE USER EXIST";
            print check_count_user($db);
        }else{
            print "TABLE USER NO EXIST";
        }

        print "<br>";
        //check tabel status ada/tdk
        $status = check_tabel_status($db);
        if($status){
            //print "TABLE STATUS EXIST";
            print check_count_status($db);
        }else{
            print "TABLE STATUS NO EXIST";
        }

        print "<br>";
        //check tabel products ada/tdk
        $products = check_tabel_products($db);
        if($products){
            //print "TABLE PRODUCTS EXIST";
            print check_count_products($db);
        }else{
            print "TABLE PRODUCTS NO EXIST";
        }

    }else{ 
        //jika session masih null/kosong, maka akan mengecek tabel user dan menampilkan form login
        if($db){
            $user = check_tabel_user($db);

            if($user){
                
                //nyambungin file dashboard.php ke file login.php
                include "../template/login.php";
            }
        }
    }



?>