<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>User Page</title>
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
        
        $page = $_GET["page"]??"";

        switch($page){
            case "create":
                //memanggil file form_input.php
                include "../template/form_input.php";
            break;

            case "insert":
                $post = $_POST??[];

                if(empty($post)){
                    header("Location: ../index.php");
                }else{
                    $result = insert_user($db,$post);

                    if($result){
                        //perintah untuk redirect
                        header("Location: user.php");

                    }else{
                        //notifikasi saat data yg di input sama
                        print "<script>alert('nama atau email sudah digunakan!')</script>";

                        //memanggil file form_input.php
                        include "../template/form_input.php";
                    }
                }
            break;

            case 'delete':
                $id_user = $_GET['id']??"";

                if($id_user){
                    $result = delete_user($db,$id_user);
                    
                    if($result){
                        //notifikasi saat data yg di input sama
                        print "<script>alert('data berhasil dihapus!')</script>";
                    }else{
                        //notifikasi saat data yg di input sama
                        print "<script>alert('data gagal dihapus!')</script>";
                    }

                }else{
                    //notifikasi saat data yg di input sama
                    print "<script>alert('id user tidak ada!')</script>";
                }

                //perintah untuk redirect
                header("Location: user.php");

            break;

            case 'edit':
                $id_user = $_GET['id']??"";

                if($id_user){
                    
                    $result = detail_user($db,$id_user);

                    if(empty($result)){
                        //notifikasi saat data yg di input kosong
                        print "<script>alert('id user tidak ada!')</script>";
                    }else{
                        $nama = $result['nama'];
                        $email = $result['email'];
                        $status = $result['status'];

                        include '../template/form_edit.php';
                    }

                }else{
                    //notifikasi saat data yg di input sama
                    print "<script>alert('id user tidak ada!')</script>";
                }

                

            break;

            case 'update':
                $post = $_POST??[];
                $post['id']=$_GET['id'];
                $result = update_user($db,$post);

                if($result){
                    
                    //notifikasi saat data yg di update berhasil
                    print "<script>alert('data berhasil diupdate!')</script>";
                }else{
                    //notifikasi saat data yg di update gagal
                    print "<script>alert('data gagal diupdate!')</script>";
                }

                //perintah untuk redirect
                header("Location: user.php");

            break;

            default: 
                //perintah untuk redirect
                header("Location: ../index.php");
            break;
        }


    }else{ 
        //perintah untuk redirect
        header("Location: ../index.php");
    }



?>