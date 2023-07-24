<?php 
    $form_edit = $_GET['db']??"";
    $edit = "";

    switch($form_edit){
        case 'user':
            $input_status = "";
            foreach($list_status as $key){
                $input_status.="<option value='".$key['id_status']."' ".($key['id_status']==$status?'selected':'')."> ".$key['title']." </option>";
            }

            $edit = " <div class='input-group mb-3'>
                        <label class='input-group-text' for='nama'><i class='fa-solid fa-user'></i></label>
                        <input class='form-control' id='nama' type='text' name='nama' placeholder='masukkan nama lengkap' value='".$nama."' required>
                      </div>
                      <div class='input-group mb-3'>
                        <label class='input-group-text' for='email'><i class='fa-solid fa-envelope'></i></label>
                        <input class='form-control' type='email' id='email' name='email' placeholder='xxx@gmail.com' value='".$email."' required>
                      </div>
                      <div class='input-group'>
                        <label class='input-group-text' for='status'><i class='fa-solid fa-check-to-slot'></i></label>
                        <select class='form-select' name='status' id='status'>".$input_status."</select>  
                      </div>
                     ";
        break;

        case 'status':
            $edit = " <div class='input-group mb-3'>
                        <label class='input-group-text' for='title'><i class='fa-solid fa-user'></i></label>
                        <input class='form-control' type='text' id='title' name='title' placeholder='masukkan status saat ini' value='".$title."' required>
                      </div>
                      <div class='input-group mb-3'>
                        <label class='input-group-text' for='level'><i class='fa-solid fa-layer-group'></i></label>
                        <input class='form-control' type='text' id='level' name='level' placeholder='masukkan level saat ini' value='".$level."' required>
                      </div>
                    ";
        break;

        case 'products':
            $list_status = array("tidak aktif", "aktif");
            $input_status = "";
            foreach($list_status as $key => $value){
                $input_status.="<option value='".$key."' ".($key==$status?'selected':'')."> ".$value." </option>";
            }

            $edit = " <div class='input-group mb-3'>
                        <label class='input-group-text' for='nama_products'><i class='fa-solid fa-tag'></i></label>
                        <input class='form-control' type='text' id='nama_products' name='nama_products' placeholder='masukkan nama products' value='".$nama_products."' required>
                      </div>
                      <div class='input-group mb-3'>
                        <label class='input-group-text' for='harga'><i class='fa-solid fa-dollar-sign'></i></label>
                        <input class='form-control' type='text' id='harga' name='harga' placeholder='0' value='".$harga."' required>
                      </div>
                      <div class='input-group mb-3'>
                        <label class='input-group-text' for='total'><i class='fa-sharp fa-solid fa-box'></i></label>
                        <input class='form-control' type='text' id='total' name='total' placeholder='0' value='".$total."' required>
                      </div>
                      <div class='input-group mb-3'>
                        <label class='input-group-text' for='status'><i class='fa-solid fa-check-to-slot'></i></label>
                        <select class='form-select' name='status' id='status'>".$input_status."</select>  
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
    <section class="countainer">
        <div class="row">
            <div class="col-12">
                <form class="card" action="?page=update&id=<?php echo $id; ?>&db=<?php echo $form_edit;?>" method="POST">
                    <div class="card-header">
                        <h3>Form Edit <span class="text-danger text-uppercase"><?php echo $form_edit; ?></span></h3>
                    </div>
                    <div class="card-body">
                        <?php echo $edit;?>
                    </div>
                    <div class="card-footer">
                        <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="This top tooltip is themed via CSS variables." type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-2"></i>SUBMIT</button>
                        <button type="reset" class="btn btn-warning"><i class="fa-solid fa-rotate me-2"></i>Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
