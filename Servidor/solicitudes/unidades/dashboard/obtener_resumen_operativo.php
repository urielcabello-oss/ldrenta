<?php
header('Content-Type: application/json');

include '../../../conexion.php';

$response = [
    "success" => false
];

try {

    // ============================
    // UNIDADES DISPONIBLES
    // id_estado_unidad = 1
    // ============================
    $sqlUnidades = "
        SELECT COUNT(*) AS total
        FROM unidades
        WHERE id_estado_unidad = 1
    ";

    $resUnidades = $conexion->query($sqlUnidades);

    $unidadesDisponibles = 0;

    if ($resUnidades && $row = $resUnidades->fetch_assoc()) {
        $unidadesDisponibles = intval($row['total']);
    }

    // ============================
    // CONTRATOS
    // id_estatus_comodato_demo = 3
    // (ajústalo al estatus real)
    // ============================
    $sqlContratos = "
        SELECT COUNT(*) AS total
        FROM asignacion_unidad_demo
        WHERE archivo_comodato_firmado IS NOT NULL
        AND archivo_comodato_firmado <> ''
    ";

    $resContratos = $conexion->query($sqlContratos);

    $contratos = 0;

    if ($resContratos && $row = $resContratos->fetch_assoc()) {
        $contratos = intval($row['total']);
    }

    // ============================
    // ASIGNACIONES ACTIVAS
    // estado = 1
    // ============================
    $sqlAsignaciones = "
        SELECT COUNT(*) AS total
        FROM asignacion_unidad_demo
        WHERE estado = 1
    ";

    $resAsignaciones = $conexion->query($sqlAsignaciones);

    $asignaciones = 0;

    if ($resAsignaciones && $row = $resAsignaciones->fetch_assoc()) {
        $asignaciones = intval($row['total']);
    }

    // ============================
    // MANTENIMIENTOS
    // ============================
    $sqlMantenimientos = "
        SELECT COUNT(*) AS total
        FROM mantenimientos_flotilla
    ";

    $resMantenimientos = $conexion->query($sqlMantenimientos);

    $mantenimientos = 0;

    if ($resMantenimientos && $row = $resMantenimientos->fetch_assoc()) {
        $mantenimientos = intval($row['total']);
    }

    $response["success"] = true;

    $response["data"] = [
        "unidades_disponibles" => $unidadesDisponibles,
        "contratos" => $contratos,
        "asignaciones_activas" => $asignaciones,
        "mantenimientos" => $mantenimientos
    ];

} catch (Exception $e) {

    $response["message"] = $e->getMessage();
}

echo json_encode($response);