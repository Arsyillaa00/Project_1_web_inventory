<?php
class Home extends Database{
    public $result;
    public $home;

    function __construct(){
        parent::__construct();

        //jika session tersimpan, perintah dibawah akan dijalankan
        login_status();

        $this->result = $this->db->query("SELECT TABLE_NAME AS name,TABLE_ROWS AS count FROM information_schema.tables WHERE table_schema = 'project_2';")->fetch_all(MYSQLI_ASSOC);
        //echo "test construct";
    }

    function login(){
        $mysql = $this->db;

        $email = $mysql->real_escape_string($_POST["email"]);
        $password = $mysql->real_escape_string($_POST["password"]);
    
        $query = $mysql->query("SELECT * FROM user WHERE email='$email' AND password='$password'")->fetch_assoc();

    
        if(!empty($query)){
            session_start();
            foreach($query AS $key => $value){
                $_SESSION[$key] = $value;
            }
    
            //perintah untuk redirect
            header("Location: dashboard.php");
        }
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
?>