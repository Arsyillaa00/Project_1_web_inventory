<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Status Page</title>
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
        
        //check tabel status ada/tdk
        $status = check_count_status($db);
        if($status){
            //print "TABLE USER EXIST";
            print check_count_status($db);
        }else{
            print "TABLE STATUS NO EXIST";
        }

        print "<br>";

        //mengatur data agar hanya di tampilkan 4 baris
        $page = $_GET["page"]??0;

        //memanggil fungsi tabel_status()
        $result = tabel_status($db, $page);

        //menampilkan data di body tabel
        $html = "";
        foreach($result as $results){
            $html.= "<tr>       
                        <td>".$results['nomor']."</td>
                        <td>".$results['title']."</td>
                        <td>".$results['level']."</td>
                        <td>
                            <a href='form.php?page=edit&id=".$results['id_status']."&db=status'>Edit</a>
                            <a href='form.php?page=delete&id=".$results['id_status']."&db=status'>Hapus</a>
                            <a href='profil.php?id=".$results['id_status']."&db=status'>Detail</a>

                        </td>
                    </tr>";
        }

        //membuat tombol next $ prev
        $database = $_GET['db']??"";

        if(!$page){
            $prev = "";
        }else{
            $prev = "<a href='status.php?page=".($page-1)."&db=status'> PREV </a>";
        }

        $count = check_count_status($db);
        if(count($result)>=4 && (count($result)*($page+1))!=$count){
            $next = "<a href='status.php?page=".($page+1)."&db=status'> NEXT </a>";
        }else{
            $next = "";
        }

        //nyambungin file dashboard.php ke file login.php
        include "../template/tabel.php";



    }else{ 
        //perintah untuk redirect
        header("Location: ../index.php");
    }



?>