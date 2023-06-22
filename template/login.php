<form name="login" method="POST" action="login.php">


    <label for="email">Email:</label> <!-- saat nama label diklik langsung fokus ke lokasi input email -->
	<input type="email" id="email" name="email" required><br> <!-- "required" berfungsi utk mengingatkan user utk isi data dulu baru disubmit / tdk blh submit saat data kosong-->

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required minlength="8" maxlength="60"><br>

    <button type="submit"> SUBMIT </button>

    <!-- 
        standart value:
        - title max panjang 30
        - subtitle max panjang 80
        - deskripsi max panjang (optional) 500-1600, di ig : max 1600, di fb : max 4000
        - password min panjang 8 | max panjang 60
        - telpon min panjang 8 | max panjang 14
    -->
</form>