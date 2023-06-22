<?php

//koneksi ke file controller
require_once "../app/controller.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];

    //koneksi fungsi mysql
    $db = database();

    if($db){
        print json_encode(login($db, $email, $password));

        $login = login($db, $email, $password);

        if(!empty($login)){
            session_start();
            foreach($login AS $key => $value){
                $_SESSION[$key] = $value;
            }

            //perintah untuk redirect
            header("Location: dashboard.php");
        }
    }

    
    
}

?>