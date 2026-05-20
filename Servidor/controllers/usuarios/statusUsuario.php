<?php

require_once('../conexion.php');

$idusuario = $_POST['idusuario'];
$status = $_POST['status'];

$sql = "
    UPDATE usuarios
    SET status = '$status'
    WHERE id_usuario = '$idusuario'
";

$query = $conexion->query($sql);

if($query){

    echo json_encode([
        'status' => true,
        'msg' => 'Estatus actualizado'
    ]);

}else{

    echo json_encode([
        'status' => false,
        'msg' => 'Error al actualizar'
    ]);
}