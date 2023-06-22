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
    $query = "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'project_2'";
    $result = $mysql->query($query);

    //check $result berhasil/tdk
    //print json_encode($result->fetch_all());

    if(!empty($result->fetch_row())){
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
?>