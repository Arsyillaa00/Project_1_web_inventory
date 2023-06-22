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