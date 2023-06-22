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
        print "page dashboard";

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