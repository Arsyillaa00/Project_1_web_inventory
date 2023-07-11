<?php 

    $tabel = $_GET['db']??"";
    $head = "";

    switch($tabel){
        case 'user':
            $head = "<tr>
                        <th>Nomor</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>Menu</th>
                    </tr>";
        break;

        case 'status':
            $head = "<tr>
                        <th>Nomor</th>
                        <th>Title</th>
                        <th>Level</th>
                        <th>Menu</th>
                    </tr>";
        break;

        case 'products':
            $head = "<tr>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal Input</th>
                        <th>Tanggal Update</th>
                        <th>Menu</th>
                    </tr>";
        break;

        default :
            //perintah untuk redirect
            header("Location: ../index.php");
        break;
    }

?>

<main class="col-10 p-3">
    <section class="countainer">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped caption-top shadow"> 
                    <thead class="table-dark"> 
                        <?php echo $head;?>
                    </thead> 

                    <tbody>
                        <?php  echo $html;?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td class="border-0">
                                <?php echo $prev.$next; ?>
                            </td>
                        </tr>
                    </tfoot>

                    <caption>
                        <div class="d-flex justify-content-between">
                            <div class="px-2 fw-bold">
                                <?php echo $count_data; ?>
                            </div>
                            <a class="btn btn-primary" href="form.php?page=create&db=<?php echo $tabel;?>">
                                <span class="fa-solid fa-plus"></span>    
                                Tambah Data
                            </a>
                        </div>
                    </caption>
                </table>
            </div>
        </div>
    </section>
</main>