<?php

// Mulai session
session_start();

// Hapus session dengan nama 'username' (biasa di pakai pada kasus update)
//unset($_SESSION['username']);

// Hapus semua session (masih meninggalkan bekas sampah di cookie)
//session_unset();

// Hapus session dan hapus cookie yang terkait
session_destroy();

//perintah untuk redirect
header("Location: dashboard.php");

?>