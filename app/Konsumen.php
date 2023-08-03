<?php

class Konsumen extends Database{
    const LIMIT = 12;
    public $mysql;
    public $page;
    public $array;
    public $input;

    function __construct($page){
        parent::__construct();
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
        $limit = self::LIMIT*$page;
        $number = self::LIMIT;
        $query = "SELECT (@no:=@no+1) AS nomor, id_products, nama_products, harga, total, date_m FROM products, (SELECT @no:=$limit) AS number WHERE status='1' $search ORDER BY id_products LIMIT $limit,$number";
        $result = $this->db->query($query);
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
                                <a class='btn btn-success' href='keranjang.php?add=".$key['id_products']."'>Tambah ke Keranjang</a>
                            </div>
                        </div>
                    </div>";
        };

        return $result;
    }

    function count(){

        $query = "SELECT COUNT(id_products) FROM products";
        $result = $this->db->query($query)->fetch_row();
        

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


?>