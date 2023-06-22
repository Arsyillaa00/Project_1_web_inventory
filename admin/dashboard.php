<?php
    //nyambungin file dashboard.php ke file controller.php
    require_once "../app/controller.php"; 

    //nyambungin file dashboard.php ke file login.php
    //include "../template/login.php";

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
    
    
    



?>