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
                    $form_name = $_GET['db']??"";
                    $result = "";
                    switch($form_name){
                        case "user":
                            $result = insert_user($db,$post);
                        break;

                        case "status":
                            $result = insert_status($db,$post);
                        break;

                        case "products":
                            $result = insert_products($db,$post);
                        break;

                        default:
                        break;
                    }

                    if($result){
                        //perintah untuk redirect
                        header("Location: ".$form_name.".php?db=".$form_name);

                    }else{
                        //notifikasi saat data yg di input sama
                        print "<script>alert('nama atau email sudah digunakan!')</script>";

                        //memanggil file form_input.php
                        include "../template/form_input.php";
                    }
                }
            break;

            case 'delete':
                $id = $_GET['id']??"";

                if($id){
                    $form_name = $_GET['db']??"";
                    $result = "";
                    switch($form_name){
                        case 'user':
                            $result = delete_user($db,$id);
                        break;
                        
                        case "status":
                            $result = delete_status($db,$id);
                        break;

                        case "products":
                            $result = delete_products($db,$id);
                        break;

                        default:
                        break;
                    }
                    
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
                header("Location: ".$form_name.".php?db=".$form_name);

            break;

            case 'edit':
                $id = $_GET['id']??"";
                $result = "";
                $form_name = $_GET['db']??"";

                if($id){
                    switch($form_name){
                        case "user":
                            $result = detail_user($db,$id);

                            if(empty($result)){
                                //notifikasi saat data yg di input kosong
                                print "<script>alert('id user tidak ada!')</script>";
                            }else{
                                $nama = $result['nama'];
                                $email = $result['email'];
                                $status = $result['status'];

                                include '../template/form_edit.php';
                            }
                        break;

                        case "status":
                            $result = detail_status($db,$id);

                            if(empty($result)){
                                //notifikasi saat data yg di input kosong
                                print "<script>alert('id user tidak ada!')</script>";
                            }else{
                                $title = $result['title'];
                                $level = $result['level'];

                                include '../template/form_edit.php';
                            }
                        break;

                        case "products":
                            $result = detail_products($db,$id);

                            if(empty($result)){
                                //notifikasi saat data yg di input kosong
                                print "<script>alert('id user tidak ada!')</script>";
                            }else{
                                $nama_products = $result['nama_products'];
                                $harga = $result['harga'];
                                $total = $result['total'];
                                $status = $result['status'];

                                include '../template/form_edit.php';
                            }
                        break;

                        default:

                        break;
                        
                    }
                }else{
                    //notifikasi saat data yg di input sama
                    print "<script>alert('id user tidak ada!')</script>";
                }
            break;

            case 'update':
                $post = $_POST??[];
                $post['id']=$_GET['id'];
                
                $form_name = $_GET['db']??"";
                switch($form_name){
                    case "user":
                        $result = update_user($db,$post);
                    break;

                    case "status":
                        $result = update_status($db,$post);
                    break;

                    case "products":
                        $result = update_products($db,$post);
                    break;

                    default:
                    break;
                }

                if($result){
                    //notifikasi saat data yg di update berhasil
                    print "<script>alert('data berhasil diupdate!')</script>";
                }else{
                    //notifikasi saat data yg di update gagal
                    print "<script>alert('data gagal diupdate!')</script>";
                }
                
                //perintah untuk redirect
                header("Location: ".$form_name.".php?db=".$form_name);

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