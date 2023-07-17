<?php 

    $detail = $_GET['db']??"";
    $input = "";

    switch($detail){
        case 'user':
            $input = "  <div class='input-group mb-3'>
                            <label class='input-group-text' for='nama'><i class='fa-solid fa-user'></i></label>
                            <label class='input-group-text'>Nama</label>
                            <input class='form-control' type='text' id='nama' name='nama' value='".$nama."' disabled>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='email'><i class='fa-solid fa-envelope'></i></label>
                            <label class='input-group-text'>Email</label>
                            <input class='form-control' type='email' id='email' name='email' value='".$email."' disabled>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='status'><i class='fa-solid fa-check-to-slot'></i></label>
                            <label class='input-group-text'>Status</label>
                            <input class='form-control' type='text' id='email' name='status' value='".$status."' disabled>
                        </div>
                     ";
        break;

        case 'status':
            $input = "  <div class='input-group mb-3'>
                            <label class='input-group-text'><i class='fa-solid fa-user'></i></label>
                            <label class='input-group-text'>Title</label>
                            <input class='form-control' value='".$title."' disabled>
                        </div>

                        <div class='input-group mb-3'>
                            <label class='input-group-text'><i class='fa-solid fa-layer-group'></i></label>
                            <label class='input-group-text'>Level</label>
                            <input class='form-control' value='".$level."' disabled>
                        </div>
                     ";
        break;

        case 'products':
            $input = "  <div class='input-group mb-3'>
                            <label class='input-group-text' for='nama_products'><i class='fa-solid fa-tag'></i></label>
                            <label class='input-group-text'>Nama Products</label>
                            <input class='form-control' id='nama_products' type='text' name='nama_products' value='".$nama_products."' disabled>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='harga'><i class='fa-solid fa-dollar-sign'></i></label>
                            <label class='input-group-text'>Harga</label>
                            <input class='form-control' id='harga' type='text' name='harga' value='".$harga."' disabled>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='total'><i class='fa-sharp fa-solid fa-box'></i></label>
                            <label class='input-group-text'>Total</label>
                            <input class='form-control' id='total' type='text' name='total' value='".$total."' disabled>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='nama_products'><i class='fa-solid fa-check-to-slot'></i></label>
                            <label class='input-group-text'>Status</label>
                            <input class='form-control' id='nama_products' type='text' name='nama_products' value='".$status."' disabled>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='harga'><i class='fa-solid fa-calendar-days'></i></label>
                            <label class='input-group-text'>Tanggal Dibuat</label>
                            <input class='form-control' id='harga' type='date' name='harga' value='".$date_c."' disabled>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='total'><i class='fa-solid fa-calendar-days'></i></label>
                            <label class='input-group-text'>Tanggal Edit</label>
                            <input class='form-control' id='total' type='date' name='total' value='".$date_m."' disabled>
                        </div>
                     ";
        break;

        default :
            //perintah untuk redirect
            header("Location: ../index.php");
        break;
    }
?>


<main class="col-10 p-3">
    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Detail <span class="text-danger text-uppercase"><?php echo $detail; ?></span></h3>
                    </div>
                    <div class="card-body">
                        <?php echo $input;?>
                    </div>
                    <div class="card-footer">         
                        <a class='btn btn-warning' href="form.php?page=edit&id=<?php echo $id;?>&db=<?php echo $detail;?>"> <i class="fa-solid fa-pencil"></i></a>
                        <a class='btn btn-danger' href="form.php?page=delete&id=<?php echo $id;?>&db=<?php echo $detail;?>"> <i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>    