<?php

$host = "193.203.166.27";
$database = "u546825723_dbfotontru";
$user = "u546825723_admin_fotontru";
$pass = "Felurn1@n80";

$conexion_tru = mysqli_connect($host, $user, $pass, $database);

if (mysqli_connect_errno()) {
    echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
}else{
    echo "Conexion exitosa";
}