<?php 
include("../../../Servidor/conexion.php");

if(isset($_POST['idasignacion']) && isset($_POST['descripciondenegacioncomodatousuario'])){

    $idasignacion = $_POST['idasignacion'];
    $descripciondenegacion = $_POST['descripciondenegacioncomodatousuario'];

    $query = "UPDATE asignacion_unidad_colaborador SET id_estatus_comodato = 7, motivo_rechazo_comodato = '$descripciondenegacion' WHERE id_asignaciones = '$idasignacion'";
    $ejecutar = mysqli_query($conexion, $query);


    
}


?>