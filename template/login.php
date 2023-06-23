<section class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Dashboard Admin</h3>
                    <p class="card-subtitle">Form untuk Login</p>
                </div>

                <div class="card-body">
                    <form name="login" method="POST" action="login.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label> <!-- saat nama label diklik langsung fokus ke lokasi input email -->
                            <input type="email" id="email" name="email" placeholder="example@example" required class="form-control"> <!-- "required" berfungsi utk mengingatkan user utk isi data dulu baru disubmit / tdk blh submit saat data kosong-->
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label> 
                            <input type="password" id="password" name="password" placeholder="********" required minlength="8" maxlength="60" class="form-control"> 
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </div>
                    </form>
                </div>

                <div class="card-footer">
                    <p>Project 2 - Inventory by <a href="https://instagram.com/" class="text-primary">@arsyillacs</a>. @23-06-2023</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- 
        standart value:
        - title max panjang 30
        - subtitle max panjang 80
        - deskripsi max panjang (optional) 500-1600, di ig : max 1600, di fb : max 4000
        - password min panjang 8 | max panjang 60
        - telpon min panjang 8 | max panjang 14
    -->