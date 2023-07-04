<form action="?page=insert" method="POST" >
    <label for="">Nama</label>
    <input type="text" name="nama" placeholder="masukkan nama lengkap" required>
    <br>
    <label for="">Email</label>
    <input type="email" name="email" placeholder="xxx@gmail.com" required>
    <br>
    <label for="">Password</label>
    <input type="password" name="password" placeholder="masukkan password 8 karakter" required>
    <br>
    <label for="">Masukkan Ulang Password</label>
    <input type="password" name="password2" placeholder="masukkan ulang password" required>

    <br>
    <button type="submit" class="btn btn-primary">SUBMIT</button>
    <button type="reset" class="btn btn-warning">Reset</button>
</form>

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