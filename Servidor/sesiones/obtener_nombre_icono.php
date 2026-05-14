<?php


include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}

$id_colaborador = $_SESSION['id_colaborador'];

//query para obtener el nombre del usuario

$sql = "SELECT nombre_fav, apellido_paterno, apellido_materno FROM colaboradores WHERE id_colaborador = $id_colaborador";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();

    echo $fila['nombre_fav'] ;
}
