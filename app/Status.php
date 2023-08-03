<?php

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

?>