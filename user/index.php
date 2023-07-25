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

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
                }
            }

            .b-example-divider {
                width: 100%;
                height: 3rem;
                background-color: rgba(0, 0, 0, .1);
                border: solid rgba(0, 0, 0, .15);
                border-width: 1px 0;
                box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
            }

            .b-example-vr {
                flex-shrink: 0;
                width: 1.5rem;
                height: 100vh;
            }

            .bi {
                vertical-align: -.125em;
                fill: currentColor;
            }

            .nav-scroller {
                position: relative;
                z-index: 2;
                height: 2.75rem;
                overflow-y: hidden;
            }

            .nav-scroller .nav {
                display: flex;
                flex-wrap: nowrap;
                padding-bottom: 1rem;
                margin-top: -1px;
                overflow-x: auto;
                text-align: center;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }

            .btn-bd-primary {
                --bd-violet-bg: #712cf9;
                --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

                --bs-btn-font-weight: 600;
                --bs-btn-color: var(--bs-white);
                --bs-btn-bg: var(--bd-violet-bg);
                --bs-btn-border-color: var(--bd-violet-bg);
                --bs-btn-hover-color: var(--bs-white);
                --bs-btn-hover-bg: #6528e0;
                --bs-btn-hover-border-color: #6528e0;
                --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
                --bs-btn-active-color: var(--bs-btn-hover-color);
                --bs-btn-active-bg: #5a23c8;
                --bs-btn-active-border-color: #5a23c8;
            }
            .bd-mode-toggle {
                z-index: 1500;
            }
        </style>
    </head>
    <body>
        <header>
            <?php
                $url = array();

                if(isset($_GET['page'])){
                    $url['page'] = $_GET['page'];
                }

                if(isset($_GET['search'])){
                    $url['search'] = $_GET['search'];
                }

                $search = "?".http_build_query($url);
            ?>

            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="#"><span class="text-capitalize">Inventory</span></a>            
                    <form class="d-flex" action="<?php echo $search; ?>" role="search">
                        <button class="btn btn-danger rounded-0" type="reset"><i class="fa-solid fa-x"></i></button>
                        <input class="form-control rounded-0 me-2" value="<?php echo $_GET['search']??""; ?>" name="search" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </header>

        

        <!--Menampilkan Product-->
        <section class="container py-4 mt-5">
            <div class="row">
                <?php

                    //koneksi ke file controller
                    require_once "../app/controller.php";
                    
                    //panggil function mysql 
                    $db = database();

                    //mengatur data agar hanya di tampilkan 4 baris
                    $page = $_GET["page"]??0;  

                    //print class Konsumen di file controller.php
                    $konsumen = new Konsumen($db,$page);
                    $input = $konsumen->search($_GET['search']??"");
                    $products = $konsumen->products();
                    $prev = $konsumen->prev();
                    $next = $konsumen->next();
                    echo $input;
                    echo $products;

                    /*
                    - echo Konsumen::LIMIT; cara memanggil variabel constant dan static di dalam class
                    - $next = $konsumen->next(); cara memanggil function di dalam class
                    - $next = $konsumen->page; cara memanggil variabel public di dalam class
                    */

                ?>
            </div>
        </section>
        <footer class="container p-3">
            <?php echo $prev.$next; ?>
        </footer>
    </body>
</html>



