<?php

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 0);

include("../../conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        "success" => false,
        "message" => "Método no permitido"
    ]);

    exit;
}

$id_incidencia = $_POST['id_incidencia'] ?? null;
$estatus = $_POST['estatus'] ?? null;
$observaciones = $_POST['observaciones'] ?? '';

if (!$id_incidencia || !$estatus) {

    echo json_encode([
        "success" => false,
        "message" => "Datos incompletos"
    ]);

    exit;
}

//=====================================================
// ACTUALIZAR INCIDENCIA
//=====================================================

$query = "
UPDATE incidencias
SET
    estatus = ?
WHERE id_incidencia = ?
";

$stmt = $conexion->prepare($query);

$stmt->bind_param(
    "si",
    $estatus,
    $id_incidencia
);

//=====================================================
// EJECUTAR
//=====================================================

if ($stmt->execute()) {

    //=================================================
    // HISTORIAL
    //=================================================

    $queryHistorial = "
    INSERT INTO incidencias_historial
    (
        id_incidencia,
        id_colaborador,
        accion,
        comentario
    )
    VALUES
    (
        ?,
        ?,
        ?,
        ?
    )
    ";

    $stmtHistorial =
        $conexion->prepare($queryHistorial);

    $id_colaborador = 1;
    $accion = "ACTUALIZACION DE ESTATUS";

    $stmtHistorial->bind_param(
        "iiss",
        $id_incidencia,
        $id_colaborador,
        $accion,
        $observaciones
    );

    $stmtHistorial->execute();

    echo json_encode([
        "success" => true
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Error al actualizar"
    ]);

}