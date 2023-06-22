<?php

// Mulai session
session_start();

// Hapus session dengan nama 'username'
//unset($_SESSION['username']);

// Hapus semua session
//session_unset();

// Hapus session dan hapus cookie yang terkait
session_destroy();

//perintah untuk redirect
header("Location: dashboard.php");

?>