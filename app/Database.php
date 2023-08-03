<?php

class Database{
    const HOST = "localhost";
    const USER = "root";
    const TABEL = "project_2";
    const PASSWORD = "";
    public $db;

    /**
     * Create class form 
     * 
     * @param MYSQL $mysql ($mysql adalah koneksi mysql)
     * @param string|int $page ($page adalah mengatur halaman tabel)
     * 
     * @return menampilkan sidebar
     */
    function __construct(){
    $conn = new mysqli(self::HOST, self::USER, self::PASSWORD, self::TABEL);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $this->db = $conn;
}
}

?>