<?php 

    $form = $_GET['db']??"";
    $input = "";

    switch($form){
        case 'user':
            $input = "  <div class='input-group mb-3'>
                            <label class='input-group-text' for='nama'><i class='fa-solid fa-user'></i></label>
                            <input class='form-control' type='text' id='nama' name='nama' placeholder='masukkan nama lengkap' required>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='email'><i class='fa-solid fa-envelope'></i></label>
                            <input class='form-control' type='email' id='email' name='email' placeholder='xxx@gmail.com' required>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='password'><i class='fa-solid fa-lock'></i></label>
                            <input class='form-control' type='password' id='password' name='password' placeholder='masukkan password 8 karakter' required>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='password2'><i class='fa-solid fa-lock'></i></label>
                            <input class='form-control' type='password' id='password2' name='password2' placeholder='masukkan ulang password' required>
                        </div>
                     ";
        break;

        case 'status':
            $input = "  <div class='input-group mb-3'>
                            <label class='input-group-text' for='title'><i class='fa-solid fa-user'></i></label>
                            <input class='form-control' id='title' type='text' name='title' placeholder='masukkan status saat ini' required>
                        </div>
                     ";
        break;

        case 'products':
            $input = "  <div class='input-group mb-3'>
                            <label class='input-group-text' for='nama_products'><i class='fa-solid fa-tag'></i></label>
                            <input class='form-control' id='nama_products' type='text' name='nama_products' placeholder='masukkan nama product' required>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='harga'><i class='fa-solid fa-dollar-sign'></i></label>
                            <input class='form-control' id='harga' type='text' name='harga' placeholder='0' required>
                        </div>
                        <div class='input-group mb-3'>
                            <label class='input-group-text' for='total'><i class='fa-sharp fa-solid fa-box'></i></label>
                            <input class='form-control' id='total' type='text' name='total' placeholder='0' required>
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
                <form class="card" action="?page=insert&db=<?php echo $form;?>" method="POST" >
                    <div class="card-header">
                        <h3>Form Input <span class="text-danger text-uppercase"><?php echo $form; ?></span></h3>
                    </div>
                    <div class="card-body">
                        <?php echo $input;?>  
                    </div>
                    <div class="card-footer">
                        <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="This top tooltip is themed via CSS variables." type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-2"></i>SUBMIT</button>
                        <button type="reset" class="btn btn-warning"><i class="fa-solid fa-rotate me-2"></i>Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<!-- untuk melihat data 
<script type="text/javascript">
    document.addEventListener("submit",function(a){
    a.preventDefault()
    const b = new FormData(a.target)
    c = b.entries()
    d = Object.fromEntries(c)

    fetch("?page=insert", {
            method: 'POST',
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(d)
        }).then(e => e.json()).then(f => console.log(f)).catch(g => console.log(g))
})
</script>-->