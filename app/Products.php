<?php

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

?>