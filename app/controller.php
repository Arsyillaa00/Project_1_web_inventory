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

//===== fungsi untuk check tabel user ada isinya atau tidak ===== 
function check_tabel_user($mysql){
    //perintah utk check tabel
    $query = "SHOW TABLES LIKE 'user'";
    $result = $mysql->query($query)->num_rows;
    //check $result berhasil/tdk
    //print json_encode($result);

    if($result){
        return 1;
        
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
                return 1;
            }else{
                return 0;
            }
        }
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

//===== fungsi untuk check tabel status ada isinya atau tidak ===== 
function check_tabel_status($mysql){
    //perintah utk check tabel
    $query = "SHOW TABLES LIKE 'status'";
    $result = $mysql->query($query)->num_rows;
    //check $result berhasil/tdk
    //print json_encode($result);

    if($result){
        return 1;
        
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
                return 1;
            }else{
                return 0;
            }
        }
    }
}

//===== fungsi untuk check tabel products ada isinya atau tidak ===== 
function check_tabel_products($mysql){
    //perintah utk check tabel
    $query = "SHOW TABLES LIKE 'products'";
    $result = $mysql->query($query)->num_rows;
    //check $result berhasil/tdk
    //print json_encode($result);

    if($result){
        return 1;
        
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
                return 1;
            }else{
                return 0;
            }
        }
    }
}

//fungsi utk check total data user yg ada di tabel
function check_count_user($mysql){
    $query = "SELECT * FROM user";
    $result = $mysql->query($query)->num_rows;

    return $result;

}

//fungsi utk check total data status yg ada di tabel
function check_count_status($mysql){
    $query = "SELECT * FROM status";
    $result = $mysql->query($query)->num_rows;

    return "total tabel status: ".$result;
}

//fungsi utk check total data products yg ada di tabel
function check_count_products($mysql){
    $query = "SELECT COUNT(*), date_m FROM products ORDER BY date_m DESC LIMIT 1"; /*ASC = urutan dr kecil ke besar, DESC = urutan dr besar ke kecil */
    $result = $mysql->query($query)->fetch_row();
    $time = date("d-m-Y",$result[1]);

    return "total tabel products: ".$result[0]." terakhir update ".$time;
}

//fungsi untuk mengambil data di MYSQL, kemudian akan ditampilkan di file user.php
function tabel_user($mysql, $page){
    $limit = 4*$page;
    $query = "SELECT (@no:=@no+1) AS nomor, id_user, email, nama FROM user, (SELECT @no:=$limit) AS number ORDER BY id_user LIMIT $limit,4";
    $result = $mysql->query($query)->fetch_all(MYSQLI_ASSOC);

    return $result;

}

//fungsi untuk menambahkan data
function insert_user($mysql,$post){
    $nama = $mysql->real_escape_string($post['nama']);
    $email = $mysql->real_escape_string($post['email']);
    $password = $mysql->real_escape_string($post['password']);
    $password2 = $mysql->real_escape_string($post['password2']);


    //untuk konfirmasi ulang pass, jika nilai berbeda data tdk bisa diinput
    if($password == $password2){

        //cek ada data atau tdk
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

    //mecegah sql injection
    //$name = mysqli_real_escape_string($mysql, $name);
    //$name = $mysql->real_escape_string($name);
     
}

//fungsi untuk hapus data
function delete_user($mysql,$id_user){
    $id = $mysql->real_escape_string($id_user);

    //perulangan untuk mencegah hapus id/akun yg digunakan untuk login
    if($id == $_SESSION['id_user']){
        return 0;
    }else{
        $mysql->query("DELETE FROM user WHERE id_user='$id' ");
        return $mysql->affected_rows;
    }

    
}

//fungsi untuk fitur profil
function detail_user($mysql,$id_user){
    $id = $mysql->real_escape_string($id_user);
    $query = "SELECT nama, email, status FROM user WHERE id_user = '$id'";
    $result = $mysql->query($query)->fetch_assoc();
    return $result;

}

//fungsi untuk update data
function update_user($mysql,$profil){
    $id = $mysql->real_escape_string($profil['id']);
    $nama = $mysql->real_escape_string($profil['nama']);
    $email = $mysql->real_escape_string($profil['email']);
    $status = $mysql->real_escape_string($profil['status']);

    $mysql->query("UPDATE user SET nama = '$nama', email = '$email', status = '$status' WHERE id_user = '$id'");
    return $mysql->affected_rows;

}

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

//
function list_status($mysql){
    $query = "SELECT * FROM status";
    $result = $mysql->query($query)->fetch_all(MYSQLI_ASSOC);

    return $result;
}

//fungsi untuk nilai di bagian status
function get_status($mysql,$id_status){
    $id = $mysql->real_escape_string($id_status);

    $query = "SELECT title FROM status WHERE id_status = '$id'";
    $result = $mysql->query($query)->fetch_assoc();

    return $result;
}
?>