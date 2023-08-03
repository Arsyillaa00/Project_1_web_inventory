<?php

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