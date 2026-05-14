<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

include("../../Servidor/conexion.php");

$sql = "SELECT 
    cpd.id_asignacion_unidad_demo,
    cpd.fecha_prueba,
    aud.id_asignar_prueba_demo_master_driver AS instructor_id,
    col.numero_colaborador AS collaborator_number,
    CONCAT(col.nombre_1, ' ', col.apellido_paterno, ' ', col.apellido_materno) AS master_driver_nombre
FROM calendario_prueba_demo cpd
INNER JOIN asignacion_unidad_demo aud 
    ON cpd.id_asignacion_unidad_demo = aud.id_asignacion_unidad_demo
LEFT JOIN colaboradores col
    ON aud.id_asignar_prueba_demo_master_driver = col.id_colaborador
ORDER BY cpd.fecha_prueba ASC
";

$result = $conexion->query($sql);

$datos = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datos[] = [
            'id_asignacion_unidad_demo' => $row['id_asignacion_unidad_demo'],
            'fecha_prueba' => $row['fecha_prueba'],
            'instructor_id' => $row['instructor_id'] ?? null,
            'collaborator_number' => $row['collaborator_number'] ?? null,
            'master_driver_nombre' => $row['master_driver_nombre'] ?? null
        ];
    }
}

echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
