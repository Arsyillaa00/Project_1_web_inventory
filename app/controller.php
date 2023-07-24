<?php
//===== fungsi untuk check connect ke mysqli atau tidak ===== 
$servername = "localhost";
$username = "root";
$password = "";

function connection(){
    global $servername;
    global $username;
    global $password;
    
    // Buat koneksi
    $conn = new mysqli($servername, $username, $password);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    return $conn;
}


//===== fungsi untuk check apakah ada database atau tdk ===== 
function check_database($mysql, $db){

    $query = "SHOW DATABASES LIKE '$db'";

    $result = $mysql->query($query)->num_rows;

    return $result;

}

//===== fungsi untuk create database 
function create_database($mysql, $db){

    $query = "CREATE DATABASE IF NOT EXISTS $db";

    if($mysql->query($query) != false){
        return 1;

    }else{
        return 0;
    }

}

//===== fungsi untuk check koneksi mysql ke database ===== 

function database(){
    
    // Buat koneksi
    $conn = new mysqli("localhost", "root", "", "project_2");

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    return $conn;
}


//===== membuat fungsi untuk login ===== 
function login($mysql, $email, $password){
    //perintah SQL Injection
    $inputEmail = $mysql->real_escape_string($email); 
    $inputPassword = $mysql->real_escape_string($password); 

    $query = "SELECT * FROM user WHERE email='$inputEmail' AND password='$inputPassword'";

    return $mysql->query($query)->fetch_assoc();
}


/*
- ASC = urutan dr kecil ke besar,
- DESC = urutan dr besar ke kecil 
   
===Mecegah SQL Injection===
    - $name = mysqli_real_escape_string($mysql, $name);
    - $name = $mysql->real_escape_string($name);
*/


//fungsi untuk update session
function update_session($profil){
    $id = $profil['id'];
    $nama = $profil['nama'];
    $email = $profil['email'];
    $status = $profil['status'];

    if($id == $_SESSION['id_user']){
        $_SESSION['nama'] = $nama;
        $_SESSION['email'] = $email;
        $_SESSION['status'] = $status;

    }
}


//fungsi untuk nilai di bagian status
function get_status($mysql,$id_status){
    $id = $mysql->real_escape_string($id_status);

    $query = "SELECT title FROM status WHERE id_status = '$id'";
    $result = $mysql->query($query)->fetch_assoc();

    return $result;
}


//class untuk menampilkan product yg aktif
class Konsumen{
    const LIMIT = 12;
    public $mysql;
    public $page;
    public $array;
    public $input;

    function __construct($mysql, $page){
        $this->mysql=$mysql;
        $this->page=$page;
        //echo "test construct";
    }

    function __destruct(){
        //echo "test destruct";
    }

    public function search($input){
        $this->input=$input;

        if($input){
            return "<nav style=\"--bs-breadcrumb-divider: '>';\" class='col-12 mb-3'>
                        <ol class='breadcrumb'>
                            <li class='breadcrumb-item'>
                                search: 
                            </li>
                            <li class='breadcrumb-item active fw-bold'>
                               ".$input."
                            </li>
                            <li class='breadcrumb-item'>
                                <a class='link-danger' href='index.php'>reset</a>
                            </li>
                        </ol>
                    </nav>";
        }
    }

    function products(){
        $search = "";
        if($this->input){
            $search = "AND nama_products LIKE '%$this->input%'";
        }

        $page = $this->page;
        $mysql = $this->mysql;
        $limit = self::LIMIT*$page;
        $number = self::LIMIT;
        $query = "SELECT (@no:=@no+1) AS nomor, id_products, nama_products, harga, total, date_m FROM products, (SELECT @no:=$limit) AS number WHERE status='1' $search ORDER BY id_products LIMIT $limit,$number";
        $result = $mysql->query($query);
        $this->array = $result->num_rows;
        return $this->view($result->fetch_all(MYSQLI_ASSOC));
    }

    private function view($array){
        $result = "";
        foreach($array as $key){
            $result.=    "<div class='col-3 mb-3'>
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

        return $result;
    }

    function count(){
        //memanggil variabel public
        $mysql = $this->mysql;

        $query = "SELECT COUNT(id_products) FROM products";
        $result = $mysql->query($query)->fetch_row();
        

        return $result[0];
    }

    function prev(){
        $page = $this->page;
        $prev = "";
        $url = array();
        $url['page'] = $page-1;

        //membuat tombol prev saat mencari berdasarkan karakter
        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        //membuat tombol prev
        if(!$page){
            $prev = "<a class='btn btn-primary disabled me-2' href='".$search."'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }else{
            $prev = "<a class='btn btn-primary me-2' href='".$search."'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }

        return $prev;
    }

    function next(){
        $count = $this->count();
        $page = $this->page;
        $next = "";
        $url = array();
        $url['page'] = $page+1;

        //membuat tombol next saat mencari berdasarkan karakter
        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        //membuat tombol next 
        if($this->array >= self::LIMIT && ($this->array*($page+1))!=$count){
            $next = "<a class='btn btn-primary' href='".$search."'> <span class='fa-solid fa-chevron-right'></span> </a>";
        }else{
            $next = "<a class='btn btn-primary disabled' href='".$search."'> <span class='fa-solid fa-chevron-right'></span> </a>";
        }

        return $next;
    }

}

class User{
    const LIMIT = 12;
    const DB = "user";
    public $mysql;
    public $page;
    public $array;
    public $input;

    function __construct($mysql, $page){
        $this->mysql=$mysql;
        $this->page=$page;
        //echo "test construct";

        //jika session tersimpan, perintah dibawah akan dijalankan
        login_status();
    }

    function __destruct(){
        //echo "test destruct";
    }

    function new(){
        return  "<a class='btn btn-primary' href='form.php?page=create&db=user'>
                    <span class='fa-solid fa-plus'></span>    
                    Tambah Data
                </a>";
    }

    function insert($post){
        //memanggil variabel public
        $mysql = $this->mysql;

        $nama = $mysql->real_escape_string($post['nama']);
        $email = $mysql->real_escape_string($post['email']);
        $password = $mysql->real_escape_string($post['password']);
        $password2 = $mysql->real_escape_string($post['password2']);


        //untuk konfirmasi ulang pass, jika nilai berbeda data tdk bisa diinput
        if($password == $password2){

            //cek email sudah digunakan atau belum
            $check = $mysql->query("SELECT id_user FROM user WHERE nama='$nama' AND email='$email'")->num_rows;

            if($check){
                return 0;
            }else{
                $mysql->query("INSERT INTO user(nama,email,password) VALUES ('$nama','$email','$password')");
                return $mysql->affected_rows;
            }
        }else{
            return 0;
        }
    }

    static function form(){
        return  "<div class='input-group mb-3'>
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
                </div>";
    }

    function detail($id_user){
        //memanggil variabel public
        $mysql = $this->mysql;

        $id = $mysql->real_escape_string($id_user);
        $query = "SELECT nama, email, status FROM user WHERE id_user = '$id'";
        $result = $mysql->query($query)->fetch_assoc();
        return $result;
    }

    function update($profil){
        //memanggil variabel public
        $mysql = $this->mysql;

        $id = $mysql->real_escape_string($profil['id']);
        $nama = $mysql->real_escape_string($profil['nama']);
        $email = $mysql->real_escape_string($profil['email']);
        $status = $mysql->real_escape_string($profil['status']);
    
        $mysql->query("UPDATE user SET nama = '$nama', email = '$email', status = '$status' WHERE id_user = '$id'");
        return $mysql->affected_rows;
    
    }

    function tabel(){
        //memanggil variabel public
        $mysql = $this->mysql;
        $count = $this->count();

        //perintah utk check tabel
        $query = "SHOW TABLES LIKE 'user'";
        $result = $mysql->query($query)->num_rows;
        //check $result berhasil/tdk
        //print json_encode($result);

        if($result){
            return "TOTAL TABEL ".$count;
            
        }else{
            $create = "CREATE TABLE user (
                id_user INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nama VARCHAR(60) NOT NULL,
                email VARCHAR(60) NOT NULL,
                password VARCHAR(60) NOT NULL,
                status INT(1)
                )";

            //perintah untuk membuat tabel di database
            if($mysql->query($create) != false){
                $demo = "INSERT INTO user (nama,email,password) VALUES ('admin','admin@gmail.com','admin123')";

                //perintah untuk check insert user telah berhsl/tdk
                if($mysql->query($demo) != false){
                    return "TOTAL TABEL".$count;
                }else{
                    return "TABEL USER NO EXIST";
                }
            }
            

        }
    }

    function count(){
        //memanggil variabel public
        $mysql = $this->mysql;

        $query = "SELECT * FROM user";
        $result = $mysql->query($query)->num_rows;

        return $result;
    }

    function header(){
        return  "<tr>
                    <th>Nomor</th>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Menu</th>
                </tr>";
    }

    function list(){
        //memanggil variabel public
        $page = $this->page;
        $mysql = $this->mysql;

        $limit = self::LIMIT*$page;
        $number = self::LIMIT;
        $query = "SELECT (@no:=@no+1) AS nomor, id_user, email, nama FROM user, (SELECT @no:=$limit) AS number ORDER BY id_user LIMIT $limit,$number";
        $result = $mysql->query($query);

        $this->array = $result->num_rows;
        return  $this->view($result->fetch_all(MYSQLI_ASSOC));
    }

    function view($array){
        $list_products = "";
        foreach($array as $key){
            $list_products.= "<tr>       
                        <th>".$key['nomor']."</th>
                        <td>".$key['email']."</td>
                        <td>".$key['nama']."</td>
                        <td>
                            <a class='btn btn-warning' href='form.php?page=edit&id=".$key['id_user']."&db=user'><span class='fa-solid fa-pencil'></span></a>
                            <a class='btn btn-danger' href='form.php?page=delete&id=".$key['id_user']."&db=user'><span class='fa-solid fa-trash'></span></a>
                            <a class='btn btn-success' href='profil.php?id=".$key['id_user']."&db=user'><span class='fa-solid fa-circle-info'></span></a>

                        </td>
                    </tr>";
        }
        return $list_products;
    }

    function delete($id_user){
        //memanggil variabel public
        $mysql = $this->mysql;

        $id = $mysql->real_escape_string($id_user);

        //perulangan untuk mencegah hapus id/akun yg digunakan untuk login
        if($id == $_SESSION['id_user']){
            return 0;
        }else{
            $mysql->query("DELETE FROM user WHERE id_user='$id' ");
            return $mysql->affected_rows;
        }
    }

    function prev(){
        //memanggil variabel public
        $page = $this->page;

        $prev = "";
        $url = array();
        $url['db'] = "user";
        $url['page'] = $page-1;

        //membuat tombol prev saat mencari berdasarkan karakter
        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        //membuat tombol prev
        if(!$page){
            $prev = "<a class='btn btn-primary disabled me-2' href='".$search."'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }else{
            $prev = "<a class='btn btn-primary me-2' href='".$search."'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }

        return $prev;
    }

    function next(){
        //memanggil function dalam class
        $count = $this->count();

        //memanggil variabel public
        $page = $this->page;

        $next = "";
        $url = array();
        $url['db'] = "user";
        $url['page'] = $page+1;

        //membuat tombol next saat mencari berdasarkan karakter
        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        //membuat tombol next 
        if($this->array >= self::LIMIT && ($this->array*($page+1))!=$count){
            $next = "<a class='btn btn-primary' href='".$search."'> <span class='fa-solid fa-chevron-right'></span> </a>";
        }else{
            $next = "<a class='btn btn-primary disabled' href='".$search."'> <span class='fa-solid fa-chevron-right'></span> </a>";
        }

        return $next;
    }

}

class Products{
    const LIMIT = 12;
    const DB = "products";
    public $mysql;
    public $page;
    public $array;
    public $input;

    function __construct($mysql, $page){
        $this->mysql=$mysql;
        $this->page=$page;
        //echo "test construct";

        //jika session tersimpan, perintah dibawah akan dijalankan
        login_status();
    }

    function __destruct(){
        //echo "test destruct";
    }

    function new(){
        return  "<a class='btn btn-primary' href='form.php?page=create&db=products'>
                    <span class='fa-solid fa-plus'></span>    
                    Tambah Data
                </a>";
    }

    function insert($post){
        //memanggil variabel public
        $mysql = $this->mysql;

        $nama_products = $mysql->real_escape_string($post['nama_products']);
        $harga = $mysql->real_escape_string($post['harga']);
        $total = $mysql->real_escape_string($post['total']);
        $status = 0;
        $date_c = time();
        $date_m = 0;

        $mysql->query("INSERT INTO products(nama_products, harga, total, status, date_c, date_m) VALUES ('$nama_products', '$harga', '$total', '$status', '$date_c', '$date_m')");
        return $mysql->affected_rows;
    }

    static function form(){
        return  "  <div class='input-group mb-3'>
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
    }

    function detail($id_products){
        //memanggil variabel public
        $mysql = $this->mysql;

        $id = $mysql->real_escape_string($id_products);
        $query = "SELECT nama_products, harga, total, status, date_c, date_m FROM products WHERE id_products = '$id'";
        $result = $mysql->query($query)->fetch_assoc();
        return $result;
    }

    function update($profil){
        //memanggil variabel public
        $mysql = $this->mysql;
        
        $id = $mysql->real_escape_string($post['id']);
        $nama_products = $mysql->real_escape_string($post['nama_products']);
        $harga = $mysql->real_escape_string($post['harga']);
        $total = $mysql->real_escape_string($post['total']);
        $status = $mysql->real_escape_string($post['status']);
        $date_m = time();

        $mysql->query("UPDATE products SET nama_products = '$nama_products', harga = '$harga', total = '$total', status = '$status', date_m = '$date_m' WHERE id_products = '$id'");
        return $mysql->affected_rows;
    
    }

    function tabel(){
        //memanggil variabel public
        $mysql = $this->mysql;
        $count = $this->count();

        //perintah utk check tabel
        $query = "SHOW TABLES LIKE 'products'";
        $result = $mysql->query($query)->num_rows;
        //check $result berhasil/tdk
        //print json_encode($result);

        if($result){
            return "Total tabel products ";
            
        }else{
            $create = "CREATE TABLE products (
                id_products INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nama_products VARCHAR(60) NOT NULL,
                harga INT(25) NOT NULL,
                total INT(12) NOT NULL,
                status INT(6) NOT NULL,
                date_c INT(20) NOT NULL,
                date_m INT(20) NOT NULL
                )";

            //perintah untuk membuat tabel di database
            if($mysql->query($create) != false){
                $time = time();
                $demo = "INSERT INTO products (nama_products,harga,total,status,date_c,date_m) VALUES ('Goodtime','12000','24','1','$time','$time')";

                //perintah untuk check insert status telah berhsl/tdk
                if($mysql->query($demo) != false){
                    return "Total tabel products ";
                }else{
                    return "TABLE PRODUCTS NO EXIST";;
                }
            }
        }
    }

    function count(){
        //memanggil variabel public
        $mysql = $this->mysql;

        $query = "SELECT * FROM products";
        $result = $mysql->query($query)->fetch_row();

        return $result;
    }

    function header(){
        return  "<tr>
                    <th>Nomor</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal Input</th>
                    <th>Tanggal Update</th>
                    <th>Menu</th>
                </tr>";
    }

    function list(){
        //memanggil variabel public
        $page = $this->page;
        $mysql = $this->mysql;

        $limit = self::LIMIT*$page;
        $number = self::LIMIT; 
        $query = "SELECT (@no:=@no+1) AS nomor, id_products, nama_products, harga, total, IF(status = 1, 'aktif', 'tidak aktif') AS status, date_c, date_m FROM products, (SELECT @no:=$limit) AS number ORDER BY id_products LIMIT $limit,$number";
        $result = $mysql->query($query);

        $this->array = $result->num_rows;
        return $this->view($result->fetch_all(MYSQLI_ASSOC));
    }

    function view($array){
        $list_products = "";
        foreach($array as $key){
            $list_products.=    "<tr>       
                                    <th>".$key['nomor']."</th>
                                    <td>".$key['nama_products']."</td>
                                    <td>".$key['harga']."</td>
                                    <td>".$key['total']."</td>
                                    <td>".$key['status']."</td>
                                    <td>".date('d/m/Y', $key['date_c'])."</td>
                                    <td>".date('d/m/Y', $key['date_m'])."</td>

                                    <td>
                                        <a class='btn btn-warning' href='form.php?page=edit&id=".$key['id_products']."&db=products'><span class='fa-solid fa-pencil'></span></a>
                                        <a class='btn btn-danger' href='form.php?page=delete&id=".$key['id_products']."&db=products'><span class='fa-solid fa-trash'></span></a>
                                        <a class='btn btn-success' href='profil.php?id=".$key['id_products']."&db=products'><span class='fa-solid fa-circle-info'></span></a>

                                    </td>
                                </tr>";
        }
        return $list_products;
    }

    function delete($id_producst){
        //memanggil variabel public
        $mysql = $this->mysql;

        $id = $mysql->real_escape_string($id_products);

        //perulangan untuk mencegah hapus id/akun yg digunakan untuk login
        if($id == $_SESSION['id_products']){
            return 0;
        }else{
            $mysql->query("DELETE FROM products WHERE id_products='$id' ");
            return $mysql->affected_rows;
        }
    }

    function prev(){
        //memanggil variabel public
        $page = $this->page;

        $prev = "";
        $url = array();
        $url['db'] = "products";
        $url['page'] = $page-1;

        //membuat tombol prev saat mencari berdasarkan karakter
        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        //membuat tombol prev
        if(!$page){
            $prev = "<a class='btn btn-primary disabled me-2' href='$search'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }else{
            $prev = "<a class='btn btn-primary me-2' href='$search'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }

        return $prev;
    }

    function next(){
        //memanggil function dalam class
        $count = $this->count();

        //memanggil variabel public
        $page = $this->page;

        $next = "";
        $url = array();
        $url['db'] = "products";
        $url['page'] = $page+1;

        //membuat tombol next saat mencari berdasarkan karakter
        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        //membuat tombol next 
        if($this->array >= self::LIMIT && ($this->array*($page+1))!=$count){
            $next = "<a class='btn btn-primary' href='$search'> <span class='fa-solid fa-chevron-right'></span> </a>";
        }else{
            $next = "<a class='btn btn-primary disabled' href='$search'> <span class='fa-solid fa-chevron-right'></span> </a>";

        }

        return $next;
    }

}

class Status{
    const LIMIT = 12;
    const DB = "status";
    public $mysql;
    public $page;
    public $array;
    public $input;

    function __construct($mysql, $page){
        $this->mysql=$mysql;
        $this->page=$page;
        //echo "test construct";

        //jika session tersimpan, perintah dibawah akan dijalankan
        login_status();
    }

    function __destruct(){
        //echo "test destruct";
    }

    function new(){
        return  "<a class='btn btn-primary' href='form.php?page=create&db=status'>
                    <span class='fa-solid fa-plus'></span>    
                    Tambah Data
                </a>";
    }

    static function json($mysql){
        $query = "SELECT * FROM status";
        $result = $mysql->query($query)->fetch_all(MYSQLI_ASSOC);
        
        return $result;
    }

    function insert($post){
        //memanggil variabel public
        $mysql = $this->mysql;

        $nama = $mysql->real_escape_string($post['title']);

        //cek ada data atau tdk
        $check = $mysql->query("SELECT id_status FROM status WHERE title='$nama'")->num_rows;

        if($check){
            return 0;
        }else{
            $mysql->query("INSERT INTO status(title) VALUES ('$nama')");
            return $mysql->affected_rows;
        }
    }

    static function form(){
        return  "  <div class='input-group mb-3'>
                        <label class='input-group-text' for='title'><i class='fa-solid fa-user'></i></label>
                        <input class='form-control' id='title' type='text' name='title' placeholder='masukkan nama status' required>
                    </div>
                ";
    }

    function detail($id_status){
        //memanggil variabel public
        $mysql = $this->mysql;

        $id = $mysql->real_escape_string($id_status);
        $query = "SELECT title, level FROM status WHERE id_status = '$id'";
        $result = $mysql->query($query)->fetch_assoc();
        return $result;
    }

    function update($profil){
        //memanggil variabel public
        $mysql = $this->mysql;
        
        $id = $mysql->real_escape_string($profil['id']);
        $nama = $mysql->real_escape_string($profil['title']);
        $level = $mysql->real_escape_string($profil['level']);

        $mysql->query("UPDATE status SET title = '$nama', level = '$level' WHERE id_status = '$id'");
        return $mysql->affected_rows;
    
    }

    function tabel(){
        //memanggil variabel public
        $mysql = $this->mysql;
        $count = $this->count();

        //perintah utk check tabel
        $query = "SHOW TABLES LIKE 'status'";
        $result = $mysql->query($query)->num_rows;
        //check $result berhasil/tdk
        //print json_encode($result);

        if($result){
            return "TOTAL TABEL ".$count;
            
        }else{
            $create = "CREATE TABLE status (
                id_status INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(60) NOT NULL,
                level INT(6) NOT NULL
                )";

            //perintah untuk membuat tabel di database
            if($mysql->query($create) != false){
                $demo = "INSERT INTO status (title,level) VALUES ('admin','1')";

                //perintah untuk check insert status telah berhsl/tdk
                if($mysql->query($demo) != false){
                    return "TOTAL TABEL ".$count;
                }else{
                    return "TABEL USER NO EXIST";
                }
            }
        }
    }

    function count(){
        //memanggil variabel public
        $mysql = $this->mysql;

        $query = "SELECT * FROM status";
        $result = $mysql->query($query)->num_rows;

        return $result;
    }

    function header(){
        return  "<tr>
                    <th>Nomor</th>
                    <th>Title</th>
                    <th>Level</th>
                    <th>Menu</th>
                </tr>";
    }

    function list(){
        //memanggil variabel public
        $page = $this->page;
        $mysql = $this->mysql;

        $limit = self::LIMIT*$page;
        $number = self::LIMIT;
        $query = "SELECT (@no:=@no+1) AS nomor, id_status, title, level FROM status, (SELECT @no:=$limit) AS number ORDER BY id_status LIMIT $limit,$number";
        $result = $mysql->query($query);

        $this->array = $result->num_rows;
        return $this->view($result->fetch_all(MYSQLI_ASSOC));
    }

    function view($array){
        $list_status = "";
        foreach($array as $key){
            $list_status.=    "<tr>       
                                    <td>".$key['nomor']."</td>
                                    <td>".$key['title']."</td>
                                    <td>".$key['level']."</td>
                                    <td>
                                        <a class='btn btn-warning' href='form.php?page=edit&id=".$key['id_status']."&db=status'><span class='fa-solid fa-pencil'></span></a>
                                        <a class='btn btn-danger' href='form.php?page=delete&id=".$key['id_status']."&db=status'><span class='fa-solid fa-trash'></span></a>
                                        <a class='btn btn-success' href='profil.php?id=".$key['id_status']."&db=status'><span class='fa-solid fa-circle-info'></span></a>

                                    </td>
                                </tr>";
        }
        return $list_status;
    }

    function delete($id_status){
        //memanggil variabel public
        $mysql = $this->mysql;

        $id = $mysql->real_escape_string($id_status);

        //perulangan untuk mencegah hapus id/akun yg digunakan untuk login
        if($id == $_SESSION['id_status']){
            return 0;
        }else{
            $mysql->query("DELETE FROM status WHERE id_status='$id' ");
            return $mysql->affected_rows;
        }
    }

    function prev(){
        //memanggil variabel public
        $page = $this->page;

        $prev = "";
        $url = array();
        $url['db'] = "status";
        $url['page'] = $page-1;

        //membuat tombol prev saat mencari berdasarkan karakter
        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        //membuat tombol prev
        if(!$page){
            $prev = "<a class='btn btn-primary disabled me-2' href='$search'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }else{
            $prev = "<a class='btn btn-primary me-2' href='$search'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }

        return $prev;
    }

    function next(){
        //memanggil function dalam class
        $count = $this->count();

        //memanggil variabel public
        $page = $this->page;

        $next = "";
        $url = array();
        $url['db'] = "status";
        $url['page'] = $page+1;

        //membuat tombol next saat mencari berdasarkan karakter
        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        //membuat tombol next 
        if($this->array >= self::LIMIT && ($this->array*($page+1))!=$count){
            $next = "<a class='btn btn-primary' href='$search'> <span class='fa-solid fa-chevron-right'></span> </a>";
        }else{
            $next = "<a class='btn btn-primary disabled' href='$search'> <span class='fa-solid fa-chevron-right'></span> </a>";

        }

        return $next;
    }

}

class Form{
    public $db;

    function __construct($db){
        $this->db=$db;
        //echo "test construct";

        //jika session tersimpan, perintah dibawah akan dijalankan
        login_status();
    }

    function __destruct(){
        //echo "test destruct";
    }

    function create(){
        //memanggil variabel public
        $db = $this->db;
        $input = "";

        switch($db){
            case 'user':
                $input = User::form();
            break;

            case 'status':
                $input = Status::form();
            break;

            case 'products':
                $input = Products::form();
            break;
        }

        return "<main class='col-10 p-3'>
                    <section class='countainer'>
                        <div class='row'>
                            <div class='col-12'>
                                <form class='card' action='?page=insert&db=".$this->db."' method='POST' >
                                    <div class='card-header'>
                                        <h3>Form Input <span class='text-danger text-uppercase'>".$this->db."</span></h3>
                                    </div>
                                    <div class='card-body'>
                                        ".$input."
                                    </div>
                                    <div class='card-footer'>
                                        <button data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='This top tooltip is themed via CSS variables.' type='submit' class='btn btn-primary'><i class='fa-solid fa-floppy-disk me-2'></i>SUBMIT</button>
                                        <button type='reset' class='btn btn-warning'><i class='fa-solid fa-rotate me-2'></i>Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </main>";

    }

    function insert($mysql,$post){
        $db = $this->db;
        $query = "";
        $result = "";
            switch($db){
                case "user":
                    $query = new User($mysql,0);
                    $result = $query->insert($post);
                break;

                case "status":
                    $query = new Status($mysql,0);
                    $result = $query->insert($post);
                break;

                case "products":
                    $query = new Products($mysql,0);
                    $result = $query->insert($post);
                break;

                default:
                break;
            }

            if($result){
                //perintah untuk redirect
                header("Location: ".$this->db.".php?db=".$this->db);

            }else{
                //notifikasi saat data yg di input sama
                print "<script>alert('nama atau email sudah digunakan!')</script>";

                //memanggil file form_input.php
                include "../template/form_input.php";
            }

    }

    function delete($mysql,$id){
        $db = $this->db;
        $query = "";
        $result = "";
        switch($db){
            case 'user':
                $query = new User($mysql,0);
                $result = $query->delete($id);
            break;
            
            case "status":
                $query = new Status($mysql,0);
                $result = $query->delete($id);
            break;

            case "products":
                $query = new Status($mysql,0);
                $result = $query->products($id);
            break;

            default:
            break;
        }
        
        if($result){
            //notifikasi saat data yg di input sama
            print "<script>alert('data berhasil dihapus!')</script>";
        }else{
            //notifikasi saat data yg di input sama
            print "<script>alert('data gagal dihapus!')</script>";
        }
    }

    function edit($mysql,$id){
        $db = $this->db;
        $query = "";
        $result = "";
        switch($db){
            case "user":
                $query = new User($mysql,0);
                $result = $query->detail($id);
                $list_status = Status::json($mysql);

                if(empty($result)){
                    //notifikasi saat data yg di input kosong
                    print "<script>alert('id user tidak ada!')</script>";
                }else{
                    $nama = $result['nama'];
                    $email = $result['email'];
                    $status = $result['status'];

                    include '../template/form_edit.php';
                }
            break;

            case "status":
                $query = new Status($mysql,0);
                $result = $query->detail($id);

                if(empty($result)){
                    //notifikasi saat data yg di input kosong
                    print "<script>alert('id user tidak ada!')</script>";
                }else{
                    $title = $result['title'];
                    $level = $result['level'];

                    include '../template/form_edit.php';
                }
            break;

            case "products":
                $query = new Products($mysql,0);
                $result = $query->detail($id);

                if(empty($result)){
                    //notifikasi saat data yg di input kosong
                    print "<script>alert('id user tidak ada!')</script>";
                }else{
                    $nama_products = $result['nama_products'];
                    $harga = $result['harga'];
                    $total = $result['total'];
                    $status = $result['status'];

                    include '../template/form_edit.php';
                }
            break;

            default:

            break;
            
        }
    }

}
?>