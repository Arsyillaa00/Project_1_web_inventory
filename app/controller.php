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

class Home{
    public $mysql;
    public $result;
    public $home;


    function __construct($mysql){
        //jika session tersimpan, perintah dibawah akan dijalankan
        login_status();

        $this->result = $mysql->query("SELECT TABLE_NAME AS name,TABLE_ROWS AS count FROM information_schema.tables WHERE table_schema = 'project_2';")->fetch_all(MYSQLI_ASSOC);
        //echo "test construct";
    }

    function view(){
        $html = "";

        foreach($this->result AS $key){
            $html .=    "<div class='col-4'>
                            <a class='card text-decoration-none' href='".$key['name'].".php'>
                                <div class='card-header'>
                                    <div class='fw-bold'>
                                        ".$key['name']."
                                    </div>
                                </div>
                                <div class='card-body d-flex justify-content-between'>
                                    <div class=''> Total </div>
                                    <div class=''>
                                        ".$key['count']."
                                    </div>
                                </div>
                            </a>
                        </div>";
        }
        return $html;
        //echo "test destruct";
    }

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

class Database{
    const HOST = "localhost";
    const USER = "root";
    const TABEL = "project_2";
    const PASSWORD = "";
    public $db;

    /**
     * Create class form 
     * 
     * @param MYSQL $mysql ($mysql adalah koneksi mysql)
     * @param string|int $page ($page adalah mengatur halaman tabel)
     * 
     * @return menampilkan sidebar
     */
    function __construct(){
    $conn = new mysqli(self::HOST, self::USER, self::PASSWORD, self::TABEL);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $this->db = $conn;
}
}

/**
* class User adalah mengolah data tabel user
*/ 
class User extends Database{
    const LIMIT = 5;
    const DB = "user";
    public $mysql;
    public $page;
    public $array;
    public $input;
    public $search;

    /**
     * Create class form 
     * 
     * @param MYSQL $mysql ($mysql adalah koneksi mysql)
     * @param string|int $page ($page adalah mengatur halaman tabel)
     * 
     * @return menampilkan sidebar
     */
    function __construct($page){
        parent::__construct();
        $this->page=$page;
        
        login_status();
    }

    function __destruct(){
    }

    /**
     * function new untuk tampilan tombol tambah data
     * 
     * @return string button-action
     */
    function new(){
        return  "<a class='btn btn-primary' href='form.php?page=create&db=user'>
                    <span class='fa-solid fa-plus'></span>    
                    Tambah Data
                </a>";
    }

    /**
     * function insert untuk mengirim query data baru
     * 
     * @param object $post ($post adalah query dari form input)
     * 
     * @return MYSQL affected_rows
     */
    function insert($post){
        $mysql = $this->db;

        $nama = $mysql->real_escape_string($post['nama']);
        $email = $mysql->real_escape_string($post['email']);
        $password = $mysql->real_escape_string($post['password']);
        $password2 = $mysql->real_escape_string($post['password2']);

        if($password == $password2){
            $check = $mysql->query("SELECT 
                                        id_user 
                                    FROM 
                                        user 
                                    WHERE nama='$nama' AND email='$email'")->num_rows;

            if($check){
                return 0;
            }else{
                $mysql->query("INSERT INTO 
                                    user(nama,email,password,status) 
                                VALUES 
                                    ('$nama','$email','$password','1')");
                return $mysql->affected_rows;
            }
        }else{
            return 0;
        }
    }

    /**
     * function form untuk tampilan form input
     * 
     * @return string form input
     */
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

    /**
     * function detail untuk menampilkan kolom berdasarkan id
     * 
     * @param string|int $id_user ($id_user adalah query id)
     * 
     * @return object fetch_assoc()
     */
    function detail($id_user){
        $mysql = $this->db;

        $id = $mysql->real_escape_string($id_user);
        $query = "SELECT nama, email, status FROM user WHERE id_user = '$id'";
        $result = $mysql->query($query)->fetch_assoc();
        return $result;
    }

    /**
     * function update untuk query memperbarui data
     * 
     * @param object $profil ($profil adalah query dari form edit)
     * 
     * @return MYSQL affected_rows
     */
    function update($profil){
        $mysql = $this->db;

        $id = $mysql->real_escape_string($profil['id']);
        $nama = $mysql->real_escape_string($profil['nama']);
        $email = $mysql->real_escape_string($profil['email']);
        $status = $mysql->real_escape_string($profil['status']);
    
        $mysql->query("UPDATE user SET nama = '$nama', email = '$email', status = '$status' WHERE id_user = '$id'");
        return $mysql->affected_rows;
    
    }

    /**
     * function tabel untuk mengecek eksistensi tabel
     * jika null = create tabel user
     * 
     * 
     * @return string nama dan total_column
     */
    function tabel(){
        $mysql = $this->db;
        $count = $this->count();

        $query = "SHOW TABLES LIKE 'user'";
        $result = $mysql->query($query)->num_rows;

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

            if($mysql->query($create) != false){
                $demo = "INSERT INTO user (nama,email,password) VALUES ('admin','admin@gmail.com','admin123')";

                if($mysql->query($demo) != false){
                    return "TOTAL TABEL".$count;
                }else{
                    return "TABEL USER NO EXIST";
                }
            }
            

        }
    }

    /**
     * function limit untuk tampilan drop-down limit column
     * 
     * @return string drop-down menu
     */
    function limit(){
        $limit = $_GET['limit']??self::LIMIT;
        $array = array(5,10,15);
        $result = "";

        foreach($array as $key){
            $result .=  "<li><a class='dropdown-item' href='?limit=".$key."'>".$key." / page</a></li>";
        }

        return  "<div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle mx-2' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        ".$limit." / page
                    </button>
                    <ul class='dropdown-menu'>
                        ".$result."
                    </ul>
                </div>";
    }

    /**
     * function count untuk menampilkan total column
     * 
     * @return string|int total column
     */
    function count(){
        $mysql = $this->db;
        $search = $this->search;

        $query = "SELECT * FROM user $search";
        $result = $mysql->query($query)->num_rows;

        return $result;
    }

    /**
     * function header untuk tampilan header tabel
     * 
     * @return string header tabel
     */
    function header(){
        return  "<tr>
                    <th>Nomor</th>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Menu</th>
                </tr>";
    }

    /**
     * function list untuk mengirim query untuk menampilkan data
     * 
     * @return $this->view($result->fetch_all(MYSQLI_ASSOC))
     */
    function list(){
        $number = $_GET['limit']??self::LIMIT;
        $page = $this->page;
        $mysql = $this->db;
        $search = $this->search;

        $limit = $number*$page;
        $query =    "SELECT 
                        (@no:=@no+1) AS nomor, 
                        user.id_user, 
                        user.email, 
                        user.nama,
                        (SELECT status.title FROM status WHERE status.id_status = user.status) AS title
                    FROM 
                        user,
                        (SELECT @no:=$limit) AS number $search
                    GROUP BY
                        user.id_user
                    ORDER BY 
                        user.id_user LIMIT $limit,$number";
                        
        $result = $mysql->query($query);

        $this->array = $result->num_rows;
        return  $this->view($result->fetch_all(MYSQLI_ASSOC));
    }

    /**
     * function view untuk mengubah data query menjadi string
     * 
     * @param object $array
     * 
     * @return string tabel html
     */ 
    function view($array){
        $list_products = "";
        foreach($array as $key){
            $list_products.= "<tr>       
                        <th style='width:10%'>".$key['nomor']."</th>
                        <td>".$key['email']."</td>
                        <td>".$key['nama']."</td>
                        <td>".$key['title']."</td>
                        <td>
                            <a class='btn btn-warning' href='form.php?page=edit&id=".$key['id_user']."&db=user'><span class='fa-solid fa-pencil'></span></a>
                            <a class='btn btn-danger' href='form.php?page=delete&id=".$key['id_user']."&db=user'><span class='fa-solid fa-trash'></span></a>
                            <a class='btn btn-success' href='profil.php?id=".$key['id_user']."&db=user'><span class='fa-solid fa-circle-info'></span></a>

                        </td>
                    </tr>";
        }
        return $list_products;
    }

    /**
     * function delete untuk query menghapus data
     * 
     * @param string|int $id_user ($id_user adalah query id)
     * 
     * @return MYSQL affected_rows
     */
    function delete($id_user){
        $mysql = $this->db;

        $id = $mysql->real_escape_string($id_user);

        if($id == $_SESSION['id_user']){
            return 0;
        }else{
            $mysql->query("DELETE FROM user WHERE id_user='$id' ");
            return $mysql->affected_rows;
        }
    }

    /**
     * function search untuk konfigurasi filter
     * 
     * @param string|int $search ($search adalah query search)
     * 
     */  
    function search($search){
        $this->input = $search;
        $this->search = "WHERE user.nama LIKE '%$search%'";
    }

    /**
     * function url untuk mengubah array request method get menjadi string
     * 
     * @return string url
     */
    function url(){
        $url = array();
        $url['db'] = "user";
        $url['page'] = 0;

        $search = "user.php?".http_build_query($url);

        return $search;
    }

    /**
     * function nav untuk menampilkan navigasi button page
     * 
     * @return string navigasi button
     */
    function nav(){
        $page = $this->page;
        $count = $this->count();
        $array = $this->array;
        $search = $this->input;

        $limit = $_GET['limit']??self::LIMIT;
        $range = $count/$limit;

        if($range > round($range)){
            $range = round($range)+1;
        }

        $nav = "";

        $nav .= "<a class='btn mx-2 ".($page==0?'btn-primary':'btn-secondary')."' href='user.php?limit=".$limit."&page=0&search=".$search."'> First </a>";

        foreach(range($page-2,$page+2) as $key){
            if(($key+1) > 0 && $key < $range){
                $class = $key==$page?"btn-primary":"btn-secondary";

                $nav .= "<a class='btn ".$class." mx-1' href='user.php?limit=".$limit."&page=".$key."&search=".$search."'> ".($key+1)." </a>";
            }
        }

        $nav .= "<a class='btn mx-2 ".($page==($range-1)?'btn-primary':'btn-secondary')."' href='user.php?limit=".$limit."&page=".($range-1)."&search=".$search."'> Last </a>";


        return $nav;
    }

    /**
     * function prev untuk menampilkan navigasi button prev
     * 
     * @return string navigasi button prev
     */
    function prev(){
        $page = $this->page;

        $limit = $_GET['limit']??self::LIMIT;
        $prev = "";
        $url = array();
        $url['db'] = "user";
        $url['page'] = $page-1;
        $url['limit'] = $limit;

        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        if(!$page){
            $prev = "<a class='btn btn-primary disabled me-2' href='".$search."'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }else{
            $prev = "<a class='btn btn-primary me-2' href='".$search."'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }

        return $prev;
    }

    /**
     * function next untuk menampilkan navigasi button next
     * 
     * @return string navigasi button next
     */
    function next(){
        $count = $this->count();
        $page = $this->page;

        $limit = $_GET['limit']??self::LIMIT;
        $next = "";
        $url = array();
        $url['db'] = "user";
        $url['page'] = $page+1;
        $url['limit'] = $limit;

        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        if($this->array >= $limit && ($this->array*($page+1))!=$count){
            $next = "<a class='btn btn-primary mx-2' href='".$search."'> <span class='fa-solid fa-chevron-right'></span> </a>";
        }else{
            $next = "<a class='btn btn-primary mx-2 disabled' href='".$search."'> <span class='fa-solid fa-chevron-right'></span> </a>";
        }

        return $next;
    }

}

class Products extends Database{
    const LIMIT = 5;
    const DB = "products";
    public $mysql;
    public $page;
    public $array;
    public $input;
    public $search;

    /**
     * Create class form 
     * 
     * @param MYSQL $mysql ($mysql adalah koneksi mysql)
     * @param string|int $page ($page adalah mengatur halaman tabel)
     * 
     * @return menampilkan sidebar
     */
    function __construct($page){
        parent::__construct();
        $this->page=$page;

        login_status();
    }

    function __destruct(){
    }

    /**
     * function new untuk tampilan tombol tambah data
     * 
     * @return string button-action
     */
    function new(){
        return  "<a class='btn btn-primary' href='form.php?page=create&db=products'>
                    <span class='fa-solid fa-plus'></span>    
                    Tambah Data
                </a>";
    }

    /**
     * function insert untuk mengirim query data baru
     * 
     * @param object $post ($post adalah query dari form input)
     * 
     * @return MYSQL affected_rows
     */
    function insert($post){
        $mysql = $this->db;

        $nama_products = $mysql->real_escape_string($post['nama_products']);
        $harga = $mysql->real_escape_string($post['harga']);
        $total = $mysql->real_escape_string($post['total']);
        $status = 0;
        $date_c = time();
        $date_m = 0;

        $mysql->query("INSERT INTO products(nama_products, harga, total, status, date_c, date_m) VALUES ('$nama_products', '$harga', '$total', '$status', '$date_c', '$date_m')");
        return $mysql->affected_rows;
    }

    /**
     * function form untuk tampilan form input
     * 
     * @return string form input
     */
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

    /**
     * function detail untuk menampilkan kolom berdasarkan id
     * 
     * @param string|int $id_products ($id_products adalah query id)
     * 
     * @return object fetch_assoc()
     */
    function detail($id_products){
        //memanggil variabel public
        $mysql = $this->db;

        $id = $mysql->real_escape_string($id_products);
        $query = "SELECT nama_products, harga, total, status, date_c, date_m FROM products WHERE id_products = '$id'";
        $result = $mysql->query($query)->fetch_assoc();
        return $result;
    }

    /**
     * function update untuk query memperbarui data
     * 
     * @param object $profil ($profil adalah query dari form edit)
     * 
     * @return MYSQL affected_rows
     */
    function update($post){
        //memanggil variabel public
        $mysql = $this->db;
        
        $id = $mysql->real_escape_string($post['id']);
        $nama_products = $mysql->real_escape_string($post['nama_products']);
        $harga = $mysql->real_escape_string($post['harga']);
        $total = $mysql->real_escape_string($post['total']);
        $status = $mysql->real_escape_string($post['status']);
        $date_m = time();

        $mysql->query("UPDATE products SET nama_products = '$nama_products', harga = '$harga', total = '$total', status = '$status', date_m = '$date_m' WHERE id_products = '$id'");
        return $mysql->affected_rows;
    
    }

    /**
     * function tabel untuk mengecek eksistensi tabel
     * jika null = create tabel user
     * 
     * 
     * @return string nama dan total_column
     */
    function tabel(){
        //memanggil variabel public
        $mysql = $this->db;
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

    /**
     * function limit untuk tampilan drop-down limit column
     * 
     * @return string drop-down menu
     */
    function limit(){
        $limit = $_GET['limit']??self::LIMIT;
        $array = array(5,10,15);
        $result = "";

        foreach($array as $key){
            $result .=  "<li><a class='dropdown-item' href='?limit=".$key."'>".$key." / page</a></li>";
        }

        return  "<div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle mx-2' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        ".$limit." / page
                    </button>
                    <ul class='dropdown-menu'>
                        ".$result."
                    </ul>
                </div>";
    }

    /**
     * function count untuk menampilkan total column
     * 
     * @return string|int total column
     */
    function count(){
        $mysql = $this->db;
        $search = $this->search;

        $query = "SELECT * FROM products $search";
        $result = $mysql->query($query)->num_rows;

        return $result;
    }

    /**
     * function header untuk tampilan header tabel
     * 
     * @return string header tabel
     */
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

    /**
     * function list untuk mengirim query untuk menampilkan data
     * 
     * @return $this->view($result->fetch_all(MYSQLI_ASSOC))
     */
    function list(){
        $number = $_GET['limit']??self::LIMIT;
        $page = $this->page;
        $mysql = $this->db;
        $search = $this->search;

        $limit = $number*$page;
        $query =    "SELECT 
                        (@no:=@no+1) AS nomor, 
                        products.id_products, 
                        products.nama_products, 
                        products.harga, 
                        products.total, 
                    IF
                        (status = 1, 'aktif', 'tidak aktif') AS status, 
                        products.date_c, 
                        products.date_m 
                    FROM 
                        products, 
                        (SELECT @no:=$limit) AS number $search
                    GROUP BY
                        products.id_products
                    ORDER BY 
                        id_products LIMIT $limit,$number";
                    
        $result = $mysql->query($query);

        $this->array = $result->num_rows;
        return $this->view($result->fetch_all(MYSQLI_ASSOC));
    }

    /**
     * function view untuk mengubah data query menjadi string
     * 
     * @param object $array
     * 
     * @return string tabel html
     */ 
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

    /**
     * function delete untuk query menghapus data
     * 
     * @param string|int $id_user ($id_user adalah query id)
     * 
     * @return MYSQL affected_rows
     */
    function delete($id_products){
        $mysql = $this->db;

        $id = $mysql->real_escape_string($id_products);

        $mysql->query("DELETE FROM products WHERE id_products='$id' ");
        return $mysql->affected_rows;
        
    }

    /**
     * function search untuk konfigurasi filter
     * 
     * @param string|int $search ($search adalah query search)
     * 
     */  
    function search($search){
        $this->input = $search;
        $this->search = "WHERE products.nama_products LIKE '%$search%'";
    }

    /**
     * function url untuk mengubah array request method get menjadi string
     * 
     * @return string url
     */
    function url(){
        $url = array();
        $url['db'] = "products";
        $url['page'] = 0;

        $search = "products.php?".http_build_query($url);

        return $search;
    }

    /**
     * function nav untuk menampilkan navigasi button page
     * 
     * @return string navigasi button
     */
    function nav(){
        $page = (int) $this->page;
        $count = (int) $this->count();
        $array = (int) $this->array;
        $search = $this->input;

        $limit = $_GET['limit']??self::LIMIT;
        $range = $count/$limit;

        if($range > round($range)){
            $range = round($range)+1;
        }

        $nav = "";

        $nav .= "<a class='btn mx-2 ".($page==0?'btn-primary':'btn-secondary')."' href='user.php?limit=".$limit."&page=0&search=".$search."'> First </a>";

        foreach(range($page-2,$page+2) as $key){
            if(($key+1) > 0 && $key < $range){
                $class = $key==$page?"btn-primary":"btn-secondary";

                $nav .= "<a class='btn ".$class." mx-1' href='products.php?limit=".$limit."&page=".$key."&search=".$search."'> ".($key+1)." </a>";
            }
        }

        $nav .= "<a class='btn mx-2 ".($page==($range-1)?'btn-primary':'btn-secondary')."' href='products.php?limit=".$limit."&page=".($range-1)."&search=".$search."'> Last </a>";


        return $nav;
    }

    /**
     * function prev untuk menampilkan navigasi button prev
     * 
     * @return string navigasi button prev
     */
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

    /**
     * function next untuk menampilkan navigasi button next
     * 
     * @return string navigasi button next
     */
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

class Status extends Database{
    const LIMIT = 5;
    const DB = "status";
    public $mysql;
    public $page;
    public $array;
    public $input;
    public $search;

    /**
     * Create class form 
     * 
     * @param MYSQL $mysql ($mysql adalah koneksi mysql)
     * @param string|int $page ($page adalah mengatur halaman tabel)
     * 
     * @return menampilkan sidebar
     */
    function __construct($page){
        parent::__construct();
        $this->page=$page;

        login_status();
    }

    /**
     * function new untuk tampilan tombol tambah data
     * 
     * @return string button-action
     */
    function __destruct(){
    }

    /**
     * function new untuk tampilan tombol tambah data
     * 
     * @return string button-action
     */
    function new(){
        return  "<a class='btn btn-primary' href='form.php?page=create&db=status'>
                    <span class='fa-solid fa-plus'></span>    
                    Tambah Data
                </a>";
    }

    /**
     * function json untuk mengambil data dari Tabel status
     * 
     * @param object $mysql ($mysql adalah koneksi mysql)
     * 
     * @return MYSQL fetch_all(MYSQLI_ASSOC)
     */
    static function json($mysql){
        $query = "SELECT * FROM status";
        $result = $mysql->query($query)->fetch_all(MYSQLI_ASSOC);
        
        return $result;
    }

    /**
     * function insert untuk mengirim query data baru
     * 
     * @param object $post ($post adalah query dari form input)
     * 
     * @return MYSQL affected_rows
     */
    function insert($post){
        //memanggil variabel public
        $mysql = $this->db;

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
        $mysql = $this->db;

        $id = $mysql->real_escape_string($id_status);
        $query = "SELECT title, level FROM status WHERE id_status = '$id'";
        $result = $mysql->query($query)->fetch_assoc();
        return $result;
    }

    function update($profil){
        //memanggil variabel public
        $mysql = $this->db;
        
        $id = $mysql->real_escape_string($profil['id']);
        $nama = $mysql->real_escape_string($profil['title']);
        $level = $mysql->real_escape_string($profil['level']);

        $mysql->query("UPDATE status SET title = '$nama', level = '$level' WHERE id_status = '$id'");
        return $mysql->affected_rows;
    
    }

    function tabel(){
        //memanggil variabel public
        $mysql = $this->db;
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

    /**
     * function limit untuk tampilan drop-down limit column
     * 
     * @return string drop-down menu
     */
    function limit(){
        $limit = $_GET['limit']??self::LIMIT;
        $array = array(5,10,15);
        $result = "";

        foreach($array as $key){
            $result .=  "<li><a class='dropdown-item' href='?limit=".$key."'>".$key." / page</a></li>";
        }

        return  "<div class='dropdown'>
                    <button class='btn btn-secondary dropdown-toggle mx-2' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        ".$limit." / page
                    </button>
                    <ul class='dropdown-menu'>
                        ".$result."
                    </ul>
                </div>";
    }

    function count(){
        //memanggil variabel public
        $mysql = $this->db;

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

    /**
     * function list untuk mengirim query untuk menampilkan data
     * 
     * @return $this->view($result->fetch_all(MYSQLI_ASSOC))
     */
    function list(){
        $number = $_GET['limit']??self::LIMIT;
        $page = $this->page;
        $mysql = $this->db;
        $search = $this->search;

        $limit = $number*$page;
        $query = "SELECT 
                    (@no:=@no+1) AS nomor, 
                    status.id_status, 
                    status.title, 
                    status.level 
                FROM 
                    status, 
                    (SELECT @no:=$limit) AS number $search
                GROUP BY
                    status.id_status
                ORDER BY 
                    status.id_status LIMIT $limit,$number";
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
        $mysql = $this->db;

        $id = $mysql->real_escape_string($id_status);

        //perulangan untuk mencegah hapus id/akun yg digunakan untuk login
        if($id == $_SESSION['id_status']){
            return 0;
        }else{
            $mysql->query("DELETE FROM status WHERE id_status='$id' ");
            return $mysql->affected_rows;
        }
    }

    /**
     * function search untuk konfigurasi filter
     * 
     * @param string|int $search ($search adalah query search)
     * 
     */  
    function search($search){
        $this->input = $search;
        $this->search = "WHERE status.title LIKE '%$search%'";
    }

    /**
     * function url untuk mengubah array request method get menjadi string
     * 
     * @return string url
     */
    function url(){
        $url = array();
        $url['db'] = "user";
        $url['page'] = 0;

        $search = "status.php?".http_build_query($url);

        return $search;
    }

    /**
     * function nav untuk menampilkan navigasi button page
     * 
     * @return string navigasi button
     */
    function nav(){
        $page = $this->page;
        $count = $this->count();
        $array = $this->array;
        $search = $this->input;

        $limit = $_GET['limit']??self::LIMIT;
        $range = $count/$limit;

        if($range > round($range)){
            $range = round($range)+1;
        }

        $nav = "";

        $nav .= "<a class='btn mx-2 ".($page==0?'btn-primary':'btn-secondary')."' href='status.php?limit=".$limit."&page=0&search=".$search."'> First </a>";

        foreach(range($page-2,$page+2) as $key){
            if(($key+1) > 0 && $key < $range){
                $class = $key==$page?"btn-primary":"btn-secondary";

                $nav .= "<a class='btn ".$class." mx-1' href='status.php?limit=".$limit."&page=".$key."&search=".$search."'> ".($key+1)." </a>";
            }
        }

        $nav .= "<a class='btn mx-2 ".($page==($range-1)?'btn-primary':'btn-secondary')."' href='status.php?limit=".$limit."&page=".($range-1)."&search=".$search."'> Last </a>";


        return $nav;
    }

    function prev(){
        $page = $this->page;

        $limit = $_GET['limit']??self::LIMIT;
        $prev = "";
        $url = array();
        $url['db'] = "status";
        $url['page'] = $page-1;
        $url['limit'] = $limit;

        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        if(!$page){
            $prev = "<a class='btn btn-primary disabled me-2' href='$search'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }else{
            $prev = "<a class='btn btn-primary me-2' href='$search'> <span class='fa-solid fa-chevron-left'></span> </a>";
        }

        return $prev;
    }

    function next(){
        $count = $this->count();
        $page = $this->page;

        $limit = $_GET['limit']??self::LIMIT;
        $next = "";
        $url = array();
        $url['db'] = "status";
        $url['page'] = $page+1;
        $url['limit'] = $limit;

        if($this->input){
            $url['search'] = $this->input;
        }

        $search = "?".http_build_query($url);

        if($this->array >= self::LIMIT && ($this->array*($page+1))!=$count){
            $next = "<a class='btn btn-primary mx-2' href='$search'> <span class='fa-solid fa-chevron-right'></span> </a>";
        }else{
            $next = "<a class='btn btn-primary mx-2 disabled' href='$search'> <span class='fa-solid fa-chevron-right'></span> </a>";

        }

        return $next;
    }

}

/**
* class form adalah action dari create, delete, dan update
*/ 
class Form extends Database{
    public $tabel;

    /**
     * Create class form 
     * 
     * @param string $db ($db adalah nama tabel)
     * 
     * @return $this->db = $db
     */
    function __construct($tabel){
        parent::__construct();
        $this->tabel=$tabel;
    }

    function __destruct(){
        //echo "test destruct";
    }

    /**
     * function create untuk menampilkan form input
     * 
     * @return string form input
     */
    function create(){
        //jika session tersimpan, perintah dibawah akan dijalankan
        login_status();

        //memanggil variabel public
        $tabel = $this->tabel;
        $input = "";

        switch($tabel){
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

        return "<main class='col-10 p-3 ms-auto'>
                    <section class='countainer'>
                        <div class='row'>
                            <div class='col-12'>
                                <form class='card' action='?page=insert&db=".$this->tabel."' method='POST' >
                                    <div class='card-header'>
                                        <h3>Form Input <span class='text-danger text-uppercase'>".$this->tabel."</span></h3>
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

    /**
     * function insert untuk menyimpan data
     * 
     * @param MYSQL $mysql
     * @param object $post
     * 
     * @return MYSQL AFFECTED ROWS
     * 
     */
    function insert($post){
        $tabel = $this->tabel;
        $query = "";
        $result = "";
            switch($tabel){
                case "user":
                    $query = new User(0);
                    $result = $query->insert($post);
                break;

                case "status":
                    $query = new Status(0);
                    $result = $query->insert($post);
                break;

                case "products":
                    $query = new Products(0);
                    $result = $query->insert($post);
                break;

                default:
                break;
            }

            if($result){
                //perintah untuk redirect
                header("Location: ".$this->tabel.".php?db=".$this->tabel);

            }else{
                //notifikasi saat data yg di input sama
                print "<script>alert('nama atau email sudah digunakan!')</script>";

                //memanggil file form_input.php
                include "../template/form_input.php";
            }

    }

    /**
     * function delete untuk menghapus data
     * 
     * @param MYSQL $mysql
     * @param string $id
     * 
     * @return MYSQL AFFECTED ROWS
     */
    function delete($id){
        $tabel = $this->tabel;
        $query = "";
        $result = "";
        switch($tabel){
            case 'user':
                $query = new User(0);
                $result = $query->delete($id);
            break;
            
            case "status":
                $query = new Status(0);
                $result = $query->delete($id);
            break;

            case "products":
                $query = new Products(0);
                $result = $query->delete($id);
            break;

            default:
            break;
        }
        
        if($result){
            //notifikasi saat data berhasil dihapus
            print "<script>alert('data berhasil dihapus!')</script>";
        }else{
            //notifikasi saat data gagal dihapus
            print "<script>alert('data gagal dihapus!')</script>";
        }
    }

    /**
     * function edit untuk mengubah data
     * 
     * @param MYSQL $mysql
     * @param string $id
     * 
     * @return form edit
     */
    function edit($id){
        $tabel = $this->tabel;
        $query = "";
        $result = "";
        switch($tabel){
            case "user":
                $query = new User(0);
                $result = $query->detail($id);
                $list_status = Status::json($this->db);

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
                $query = new Status(0);
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
                $query = new Products(0);
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