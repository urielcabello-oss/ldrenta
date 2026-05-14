<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include("../../../conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_POST['id_asignacion']) || !isset($_POST['id_unidad'])) {
    echo json_encode(["status" => false, "msg" => "Datos incompletos"]);
    exit;
}

$idAsignacion = intval($_POST['id_asignacion']);
$idUnidad     = intval($_POST['id_unidad']);

$conexion->begin_transaction();

try {

    /* ===============================
       1️⃣ ACTUALIZAR ASIGNACIÓN DEMO
    ================================ */

    $sql1 = "UPDATE asignacion_unidad_demo
             SET estado = 2,
                 fecha_devolucion = NOW()
             WHERE id_asignacion_unidad_demo = ?";

    $stmt1 = $conexion->prepare($sql1);
    $stmt1->bind_param("i", $idAsignacion);
    $stmt1->execute();

    /* ===============================
       2️⃣ ACTUALIZAR ESTADO UNIDAD
    ================================ */

    $sql2 = "UPDATE unidades
             SET id_estado_unidad = 1
             WHERE id_unidad = ?";

    $stmt2 = $conexion->prepare($sql2);
    $stmt2->bind_param("i", $idUnidad);
    $stmt2->execute();

    /* ===============================
       3️⃣ CONFIRMAR
    ================================ */

    $conexion->commit();

    echo json_encode([
        "status" => true,
        "msg" => "Unidad demo devuelta correctamente"
    ]);

} catch (Throwable $e) {

    $conexion->rollback();

    echo json_encode([
        "status" => false,
        "msg" => "Error al devolver unidad",
        "error" => $e->getMessage()
    ]);
}