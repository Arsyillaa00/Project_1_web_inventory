<?php

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

?>