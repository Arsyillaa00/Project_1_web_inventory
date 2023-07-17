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
    <body>
        <section class="container py-3">
            <div class="row">
                <?php

                    //koneksi ke file controller
                    require_once "../app/controller.php";

                    //panggil function mysql 
                    $db = database();

                    //mengatur data agar hanya di tampilkan 4 baris
                    $page = $_GET["page"]??0;

                    //panggil function products_aktif() dr controller.php
                    $products_aktif = products_aktif($db, $page);

                    foreach($products_aktif as $key){
                        echo    "<div class='col-3 mb-3'>
                                    <div class='card'>
                                        <div class='card-header'>
                                            <strong class='text-uppercase'>".$key['nama_products']."</strong>
                                        </div>
                                        <div class='card-body'>
                                            <div>Total tersedia masih ada <span class='text-success'>".$key['total']."</span></div>
                                            <div>Harga /pcs : Rp. <span class='text-danger'>".$key['harga']."</span></div>
                                        </div>
                                        <div class='card-footer'>
                                            <p>Update terakhir ".date('d/m/Y',$key['date_m'])."</p>
                                        </div>
                                    </div>
                                </div>";
                    };

                    //membuat tombol next $ prev
                    if(!$page){
                        $prev = "<a class='btn btn-primary disabled me-2' href='index.php?page=".($page-1)."'> <span class='fa-solid fa-chevron-left'></span> </a>";
                    }else{
                        $prev = "<a class='btn btn-primary me-2' href='index.php?page=".($page-1)."'> <span class='fa-solid fa-chevron-left'></span> </a>";
                    }

                    $count = check_count_products_aktif($db);
                    if(count($products_aktif)>=4 && (count($products_aktif)*($page+1))!=$count){
                        $next = "<a class='btn btn-primary' href='index.php?page=".($page+1)."'> <span class='fa-solid fa-chevron-right'></span> </a>";
                    }else{
                        $next = "<a class='btn btn-primary disabled' href='index.php?page=".($page+1)."'> <span class='fa-solid fa-chevron-right'></span> </a>";
                    }
                ?>
            </div>
        </section>
        <footer class="container p-3">
            <?php echo $prev.$next; ?>
        </footer>
    </body>
</html>


