<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

include '../../../conexion.php';

$response = ["success" => false];

try {

    if (empty($_POST['id_mantenimiento'])) {
        throw new Exception("Falta id_mantenimiento");
    }

    $id_mantenimiento = intval($_POST['id_mantenimiento']);

    $id_tipo_mantenimiento     = intval($_POST['id_tipo_mantenimiento'] ?? 0);
    $id_estatus_mantenimiento  = intval($_POST['id_estatus_mantenimiento'] ?? 1);
    $fecha_ingreso             = $_POST['fecha_ingreso'] ?? null;
    $fecha_salida              = $_POST['fecha_salida'] ?? null;
    $taller                    = $_POST['taller'] ?? null;
    $costo_estimado            = is_numeric($_POST['costo_estimado'] ?? null) ? floatval($_POST['costo_estimado']) : 0;
    $descripcion_trabajo       = $_POST['descripcion_trabajo'] ?? '';
    $proximo_km                = is_numeric($_POST['proximo_km'] ?? null) ? intval($_POST['proximo_km']) : 0;
    $proximo_fecha             = $_POST['proximo_fecha'] ?? null;
    $km_actual                 = is_numeric($_POST['km_actual'] ?? null) ? intval($_POST['km_actual']) : 0;
    $km_manual                 = is_numeric($_POST['km_manual'] ?? null) ? intval($_POST['km_manual']) : 0;

    // =============================
    // SUBIR FACTURA
    // =============================
    $nombreFactura = null;

    if (isset($_FILES['factura']) && $_FILES['factura']['error'] === 0) {

        $carpeta = "../../../archivos/files/files_mantenimientos_flotilla/facturas_mantenimientos_flotilla/";

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $extension = pathinfo($_FILES["factura"]["name"], PATHINFO_EXTENSION);
        $nombreFactura = "factura_" . $id_mantenimiento . "_" . time() . "." . $extension;

        $rutaFinal = $carpeta . $nombreFactura;

        if (!move_uploaded_file($_FILES["factura"]["tmp_name"], $rutaFinal)) {
            throw new Exception("Error al guardar la factura.");
        }
    }

    // Si ya tenía km_actual (telemetría), no tocar km_manual
    if ($km_actual > 0 && $km_manual > 0) {
        $km_manual = 0;
    }

    // =============================
    // SQL
    // =============================
    $sql = "UPDATE mantenimientos_flotilla SET 
        id_tipo_mantenimiento = ?, 
        id_estatus_mantenimiento = ?, 
        fecha_ingreso = ?, 
        fecha_salida = ?, 
        taller = ?, 
        costo_estimado = ?, 
        descripcion_trabajo = ?, 
        proximo_km = ?, 
        proximo_fecha = ?, 
        km_actual = ?, 
        km_manual = ?";

    if ($nombreFactura !== null) {
        $sql .= ", factura = ?";
    }

    $sql .= " WHERE id_mantenimiento = ?";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error prepare: " . $conexion->error);
    }

    // =============================
    // BIND PARAMS
    // =============================

    if ($nombreFactura !== null) {

        $stmt->bind_param(
            "iisssdsisiisi",
            $id_tipo_mantenimiento,
            $id_estatus_mantenimiento,
            $fecha_ingreso,
            $fecha_salida,
            $taller,
            $costo_estimado,
            $descripcion_trabajo,
            $proximo_km,
            $proximo_fecha,
            $km_actual,
            $km_manual,
            $nombreFactura,
            $id_mantenimiento
        );
    } else {

        $stmt->bind_param(
            "iisssdsisiii",
            $id_tipo_mantenimiento,
            $id_estatus_mantenimiento,
            $fecha_ingreso,
            $fecha_salida,
            $taller,
            $costo_estimado,
            $descripcion_trabajo,
            $proximo_km,
            $proximo_fecha,
            $km_actual,
            $km_manual,
            $id_mantenimiento
        );
    }

    if (!$stmt->execute()) {
        throw new Exception("Error execute: " . $stmt->error);
    }

    $response["success"] = true;
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
