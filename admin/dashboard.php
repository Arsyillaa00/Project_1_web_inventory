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

    session_start();

    if(isset($_SESSION['id_user'])){
        login_status($_SESSION);
    
    }else{
        //print "page dashboard";

        //panggil function mysql 
        $db = database();

        if($db){
            $user = check_tabel_user($db);

            if($user){
                
                //nyambungin file dashboard.php ke file login.php
                include "../template/login.php";
            }
        }
    }

?>