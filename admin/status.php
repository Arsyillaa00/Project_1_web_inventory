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

    //panggil function mysql 
    session_start();

    //mengecheck session user
    if(isset($_SESSION['id_user'])){
        
        //mengatur data agar hanya di tampilkan 4 baris
        $page = $_GET["page"]??0;

        //Memanggil class User dr filw controller.php
        $status = new Status($page);
        $new = $status->new();
        $tabels = $status->tabel();
        $count = $status->count();
        $header = $status->header();

        $text = "";
        if(isset($_GET['search'])&&$_GET['search']!=NULL){
            $text = $_GET['search'];

            $status->search($_GET['search']);
        };

        $url = $status->url();
        $list = $status->list();
        $prev = $status->prev();
        $next = $status->next();
        $limit = $status->limit();
        $nav = $status->nav();

        //nyambungin file dashboard.php ke file login.php
        include "../template/tabel.php";



    }else{ 
        //perintah untuk redirect
        header("Location: ../index.php");
    }



?>