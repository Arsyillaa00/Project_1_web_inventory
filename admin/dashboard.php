<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Project 2 - Inventory</title>
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

    //mengecheck session user
    if(isset($_SESSION['id_user'])){
        //jika session tersimpan, perintah dibawah akan dijalankan
        login_status($_SESSION);
        
        //check tabel user ada/tdk
        //$user = check_tabel_user($db);
        //$count_user = $user?"Total tabel user ".check_count_user($db):"TABLE USER NO EXIST";

        //check tabel status ada/tdk
        //$status = check_tabel_status($db);
        //$count_status = $status?"Total tabel status ".check_count_status($db):"TABLE STATUS NO EXIST";

        //check tabel products ada/tdk
        //$products = check_tabel_products($db);
        //$count_products = $products?"Total tabel products ".check_count_products($db):"TABLE PRODUCTS NO EXIST";

        include "../template/dashboard.php";

    }else{ 
        //jika session masih null/kosong, maka akan mengecek tabel user dan menampilkan form login
        if($db){
            //$user = check_tabel_user($db);

            //if($user){
                
                //nyambungin file dashboard.php ke file login.php
                include "../template/login.php";
            //}
        }
    }



?>