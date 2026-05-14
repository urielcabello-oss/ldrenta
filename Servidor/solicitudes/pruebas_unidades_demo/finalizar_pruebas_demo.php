<?php
include("../../conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['id_asignacion'])) {
    $id_asignacion = $_POST['id_asignacion'];

    $update = "UPDATE asignacion_unidad_demo SET id_estado_prueba_demo = 3 WHERE id_asignacion_unidad_demo = ?";
    $stmt = $conexion->prepare($update);
    $stmt->bind_param("i", $id_asignacion);

    if ($stmt->execute()) {
        echo "Prueba finalizada correctamente.";
    } else {
        echo "Error al finalizar prueba: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "ID de asignación no recibido.";
}
?>
