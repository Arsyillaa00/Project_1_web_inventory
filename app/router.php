<?php

function dashboard(){

    print "DATABASE EXISTS";

    //tombol untuk pindah ke halaman admin / ke file dashboard.php
    print "<br>";
    print "<a href='admin/dashboard.php'> pindah halaman admin </a>";

    //tombol untuk pindah ke halaman user / ke file user.php
    print "<br>";
    print "<a href='admin/user.php'> pindah halaman user </a>";
    

}

//fungsi untuk 
function no_database(){

    print "DATABASE NO EXIST";
    print "<br>";

    print "<a href=''> klik untuk membuat database </a>";

}

?>