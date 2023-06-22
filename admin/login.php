<?php

//koneksi ke file controller
require_once "../app/controller.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];

    //koneksi fungsi mysql
    $db = mysql();

    if($db){

        print json_encode(login($db));

    }
}

?>