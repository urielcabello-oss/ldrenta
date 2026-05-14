<?php
$host = "localhost";
$user = "root";
$clave = "";
$bd = "ldrenta2";

$conexion = mysqli_connect($host, $user, $clave, $bd);
$conectar = new mysqli($host, $user, $clave, $bd);

if (mysqli_connect_errno()) {
    die("No se pudo conectar a la BD: " . mysqli_connect_error());
}

// FORZAR UTF8MB4
mysqli_set_charset($conexion, "utf8mb4");
$conectar->set_charset("utf8mb4");
?>