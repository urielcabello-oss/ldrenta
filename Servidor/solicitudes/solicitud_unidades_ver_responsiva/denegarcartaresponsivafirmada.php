<?php 
include("../../../Servidor/conexion.php");

if(isset($_POST['idasignacion']) && isset($_POST['descripciondenegacion'])){

    $idasignacion = $_POST['idasignacion'];
    $descripciondenegacion = $_POST['descripciondenegacion'];

    $query = "UPDATE asignacion_unidad_colaborador SET id_estatus_carta_responsiva = 3, motivo_rechazo = '$descripciondenegacion' WHERE id_asignaciones = '$idasignacion'";
    $ejecutar = mysqli_query($conexion, $query);


    
}


?>