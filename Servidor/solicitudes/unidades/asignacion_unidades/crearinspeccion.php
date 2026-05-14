<?php

include("../../../conexion.php");
session_start();
$id_isnpector = $_SESSION['id_colaborador'];


if (isset($_POST['idunidadasignar']) && isset($_POST['colaboradorasignacion']) && isset($_POST['fechainspeccion']) && isset($_POST['estatusinspeccion'])) {
    $idUnidad = $_POST['idunidadasignar'];
    $idColaborador = $_POST['colaboradorasignacion'];
    $estatusinspeccion = $_POST['estatusinspeccion'];
    $fechainspeccion = $_POST['fechainspeccion'];

    //verificar si ya existe una inspeccion para la unidad y el colaborador y id_estatus_inspeccion != 1 y fecha_asignacion 1= 
    $queryInspeccion = "SELECT * FROM inspecciones WHERE id_unidad = $idUnidad AND id_inspector = $id_isnpector AND id_solicitante = $idColaborador AND id_estatus_inspeccion != 1";
    $resultInspeccion = $conexion->query($queryInspeccion);
    if ($resultInspeccion->num_rows > 0) {
        $inspeccion = $resultInspeccion->fetch_assoc();
        if ($inspeccion['id_estatus_inspeccion'] == 2) {
            echo "existe";
            exit();
        }
    }

    $queryCrearInspeccion = $insertQuery = "INSERT INTO inspecciones (id_unidad, id_inspector, id_solicitante, fecha_inspeccion, id_estatus_inspeccion) 
                                            VALUES ($idUnidad, $id_isnpector, $idColaborador, CURDATE(), 2)";

    $resultCrearInspeccion = $conexion->query($queryCrearInspeccion);
    if ($resultCrearInspeccion) {
        echo "correcto";
    }else{
        echo "error";
    }
}
?>
