<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Status Page</title>
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
        
        //check tabel status ada/tdk
        $status = check_count_status($db);
        $count_data = $status?"Total tabel status ".check_count_status($db):"TABLE STATUS NO EXIST";

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
                            <a class='btn btn-warning' href='form.php?page=edit&id=".$results['id_status']."&db=status'><span class='fa-solid fa-pencil'></span></a>
                            <a class='btn btn-danger' href='form.php?page=delete&id=".$results['id_status']."&db=status'><span class='fa-solid fa-trash'></span></a>
                            <a class='btn btn-success' href='profil.php?id=".$results['id_status']."&db=status'><span class='fa-solid fa-circle-info'></span></a>

                        </td>
                    </tr>";
        }

        //membuat tombol next $ prev
        $database = $_GET['db']??"";

        if(!$page){
            $prev = "<a class='btn btn-primary disabled me-2' href='status.php?page=".($page-1)."&db=status'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }else{
            $prev = "<a class='btn btn-primary me-2' href='status.php?page=".($page-1)."&db=status'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }

        $count = check_count_status($db);
        if(count($result)>=4 && (count($result)*($page+1))!=$count){
            $next = "<a class='btn btn-primary' href='status.php?page=".($page+1)."&db=status'> <span class='fa-solid fa-chevron-right'></span> </a>";
        }else{
            $next = "<a class='btn btn-primary disabled' href='status.php?page=".($page+1)."&db=status'> <span class='fa-solid fa-chevron-right'></span> </a>";

        }

        //nyambungin file dashboard.php ke file login.php
        include "../template/tabel.php";



    }else{ 
        //perintah untuk redirect
        header("Location: ../index.php");
    }



?>