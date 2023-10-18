<?php
    $server="localhost";
    $user="root";
    $pass="";
    $db="apotek";
    $con= mysqli_connect($server,$user,$pass,$db);

    if(mysqli_connect_errno()){
        echo "Koneksi gagal:". mysqli_connect_error();
    }
?>