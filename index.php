<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Project 2 - Inventory</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    </head>
    <body>
    </body>
</html>



<?php

//sambungin file index.php ke file controller.php
require_once "app/controller.php";

//sambungin koneksi dr index.php ke router.php
require_once "app/router.php";

//memanggil fungsi connect di file "controller.php"

//fungsi untuk check database ada/tdk
$connection = connection();
if($connection){
    
$db = check_database($connection, "project_2" /*nama db yg di cari*/);

    if($db){
        return dashboard();
    }else{
        //memanggil function create database
        if(create_database($connection, "project_2")){
            return dashboard();
        }else{
            //memanggil fungsi database tidak ada
            return no_database();
        }
    }
}

/*
//memanggil fungsi db di file "controller.php"
$db = db();
if($db){
    print json_encode($db);
}
*/
?>


