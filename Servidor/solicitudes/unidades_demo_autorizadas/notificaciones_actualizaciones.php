<?php
include("../../conexion.php");

// Contamos las actualizaciones no vistas por Jurídico
$sql = "SELECT id_asignacion_unidad_demo, COUNT(*) AS pendientes
        FROM observaciones_documentos_juridico
        WHERE visto_por_usuario = 0
        GROUP BY id_asignacion_unidad_demo";

$result = $conexion->query($sql);

$notificaciones = [];

while ($row = $result->fetch_assoc()) {
    $notificaciones[] = [
        'id_asignacion_unidad_demo' => $row['id_asignacion_unidad_demo'],
        'pendientes' => $row['pendientes']
    ];
}

echo json_encode(['notificaciones' => $notificaciones]);
?>
