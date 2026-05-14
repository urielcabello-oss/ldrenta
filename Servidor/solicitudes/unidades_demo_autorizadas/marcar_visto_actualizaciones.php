<?php
include("../../conexion.php");

if (isset($_POST['id_asignacion'])) {
    $id = intval($_POST['id_asignacion']);
    $sql = "UPDATE observaciones_documentos_juridico 
            SET visto_por_usuario = 1 
            WHERE id_asignacion_unidad_demo = $id";
    $conexion->query($sql);
    echo "ok";
}
?>
