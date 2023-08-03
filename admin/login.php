<?php

//koneksi ke file controller
require_once "../app/router.php";
require_once "../app/controller.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $home = new Home();
    $home->login();

}

?>