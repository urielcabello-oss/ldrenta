<?php

$host = "72.60.171.233";
$port = "3307";
$database = "dbldrsolutions";
$user = "adminrh";
$pass = "dbadminrh123";

$conexion_rh = mysqli_connect($host, $user, $pass, $database, $port);

if (mysqli_connect_errno()) {
    echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
}else{
    echo "Conexion exitosa";
}