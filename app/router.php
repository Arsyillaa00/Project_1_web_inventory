<?php

function dashboard(){

    include "template/home.php";
    

}

//fungsi untuk 
function no_database(){

    include "template/intro.php";

}

// function login
function login_status($profil){
    print $profil['id_user'];
    print "<br>";
    print $profil['nama'];
    print "<br>";
    print $profil['email'];
    print "<br>";
    print $profil['password'];
    print "<br>";
    print $profil['status'];

    print "<br>";
    print "<a href='logout.php'> logout </a>";
}

?>