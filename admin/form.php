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

    //panggil function mysql 
    $db = database();
    session_start();
    $page = $_GET["page"]??"";

    //mengecheck session user
    if(isset($_SESSION['id_user'])){
        switch($page){
            case "create":
                $form = new Form($_GET['db']);
                $input = $form->create();

                print $input;
            break;

            case "insert":
                $post = $_POST??[];

                if(empty($post)){
                    header("Location: ../index.php");
                }else{
                    $form = new Form($_GET['db']);
                    $form->insert($db,$post);
                }
            break;

            case 'delete':
                $id = $_GET['id']??"";
                $redirect = $_GET['db'];

                if($id){
                    $form = new Form($_GET['db']);
                    $form->delete($db,$id);  
                    
                }else{
                    //notifikasi saat data yg di input sama
                    print "<script>alert('id user tidak ada!')</script>";
                }

                //perintah untuk redirect
                header("Location: ".$redirect.".php?db=".$redirect);

            break;

            case 'edit':
                $id = $_GET['id']??"";

                if($id){
                    $form = new Form($_GET['db']);
                    $form->edit($db,$id);
                }else{
                    //notifikasi saat data yg diinput sama
                    print "<script>alert('id user tidak ada!')</script>";
                }
            break;

            case 'update':
                $post = $_POST??[];
                $post['id']=$_GET['id'];
                
                $redirect = $_GET['db'];
                switch($redirect){
                    case "user":
                        $query = new User($db,0);
                        $result = $query->update($post);
                    break;

                    case "status":
                        $query = new Status($db,0);
                        $result = $query->update($post);
                    break;

                    case "products":
                        $query = new Products($db,0);
                        $result = $query->update($post);
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
                header("Location: ".$redirect.".php?db=".$redirect);

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