<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.js"></script>
    </head>
    <body class="d-flex justify-content-between">
    </body>
</html>


<?php

    require_once "../app/controller.php";
  
    require_once "../app/router.php"; 

    $db = database();
    session_start();

    if(isset($_SESSION['id_user'])){
        $page = $_GET["page"]??0;

        $user = new User($db,$page);
        $new = $user->new();
        $tabels = $user->tabel();
        $count = $user->count();
        $header = $user->header();

        $text = "";
        if(isset($_GET['search'])&&$_GET['search']!=NULL){
            $text = $_GET['search'];

            $user->search($_GET['search']);
        };

        $url = $user->url();
        $list = $user->list();
        $prev = $user->prev();
        $next = $user->next();
        $limit = $user->limit();
        $nav = $user->nav();

        include "../template/tabel.php";

    }else{ 
        
        header("Location: ../index.php");
    }
?>