<?php

class Keranjang extends Database{

    function __construct(){
        parent::__construct();
    }

    function __destruct(){

    }

    /**
     * function add untuk input data ke keranjang
     * 
     * @param object $array [id, time]
     * 
     * @return $_SESSION['succes'] = true;
     */
    function add($array){
        /**
         * @var $cek adalah query MYSQL
         * @var $data adalah return data dari $cek
         * @var $ids adalah array_column dari $data berdasarkan ['id']
         * @var $array adalah filter dari $data berdasarkan $ids
         * @var $newdata adalah json_encode dari $array
         * @var $query adalah query MYSQL / memperbarui atau input data baru
         */
        $cek = $this->db->query("SELECT data FROM keranjang WHERE user = '1'");

        if($cek->num_rows){
            
            $data = json_decode($cek->fetch_row()[0]);

            array_push($data, $array);

            $ids = array_column($data, 'id');
            $ids = array_unique($ids);
            $array = array_filter($data, function ($key, $value) use ($ids) {
                return in_array($value, array_keys($ids));
            }, ARRAY_FILTER_USE_BOTH);
            $new_array = array_values($array);
            $newdata = json_encode($new_array);
            $query = "UPDATE keranjang SET data='$newdata' WHERE user = '1' ";
        }else{
            $data = array();
            array_push($data, $array);

            $newdata = json_encode($data);
            $query = "INSERT INTO keranjang(user,data) VALUES ('1','$newdata')";
        }

        $this->db->query($query);
        $_SESSION['succes'] = true;
    }

    function view(){
        /**
         * @var string $array adalah select data dari tabel keranjang
         * @var string $list_product adalah list html berdasarkan $array
         */
        $array= $this->db->query("SELECT 
                                    data 
                                FROM 
                                    keranjang 
                                WHERE 
                                    user='1' ")->fetch_row()[0];
        $list_products= "";

        foreach(json_decode($array) as $key){
            /**
             * @var $nama adalah memanggil fungsi get_name dengan parameter id dari $key
             * @var $tanggal adalah mengubah timestamp() menjadi datetime()
             */
            $nama = $this->get_name($key->id);
            $tanggal = date('d-m-Y', $key->time);
            $list_products.=    "
                                <div class='list-group-item list-group-item-action'>
                                    <strong>".$nama."</strong>
                                    <small>".$tanggal."</small>
                                </div>
                                ";
        }
        return $list_products;
    }

    /**
     * function get_name untuk menampilkan nama product berdasarkan id
     * 
     * @param $id adalah id product
     * 
     * @return nama product
     */
    function get_name($id){

        return $this->db->query("SELECT nama_products FROM products WHERE id_products='$id'")->fetch_row()[0];
    }
}

?>