<main class="col-10 p-3 ms-auto">
    <section class="countainer">
        <div class="row">
            <div class="col-12">
                <form class="card" action="?page=insert&db=<?php echo $form->db;?>" method="POST" >
                    <div class="card-header">
                        <h3>Form Input <span class="text-danger text-uppercase"><?php echo $form->db; ?></span></h3>
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