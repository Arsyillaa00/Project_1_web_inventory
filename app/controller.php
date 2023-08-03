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

spl_autoload_register(function ($nama) { //
    require_once $nama.".php";
});

/*
- ASC = urutan dr kecil ke besar,
- DESC = urutan dr besar ke kecil 
   
===Mecegah SQL Injection===
    - $name = mysqli_real_escape_string($mysql, $name);
    - $name = $mysql->real_escape_string($name);
*/
?>