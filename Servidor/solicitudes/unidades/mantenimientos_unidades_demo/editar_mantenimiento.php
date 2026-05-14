<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include '../../../conexion.php';
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = ["success" => false, "message" => "Error desconocido"];

// ==============================
// Validar id_mantenimiento
// ==============================
$id_mantenimiento = $_POST['id_mantenimiento'] ?? null;
if (!$id_mantenimiento) {
    echo json_encode(["success" => false, "message" => "Falta id_mantenimiento"]);
    exit;
}

// ==============================
// Variables del formulario
// ==============================
$id_tipo_mantenimiento = intval($_POST['id_tipo_mantenimiento'] ?? 0);
$id_estatus_mantenimiento = intval($_POST['id_estatus_mantenimiento'] ?? 1);
$fecha_salida = !empty($_POST['fecha_salida']) ? $_POST['fecha_salida'] : null;
$taller = $_POST['taller'] ?? null;
$costo_estimado = is_numeric($_POST['costo_estimado']) ? floatval($_POST['costo_estimado']) : null;
$descripcion_trabajo = $_POST['descripcion_trabajo'] ?? '';
$proximo_km = is_numeric($_POST['proximo_km']) ? intval($_POST['proximo_km']) : null;
$proximo_fecha = !empty($_POST['proximo_fecha']) ? $_POST['proximo_fecha'] : null;
$km_actual = is_numeric($_POST['km_actual'] ?? null) ? intval($_POST['km_actual']) : null;
$km_manual = is_numeric($_POST['km_manual'] ?? null) ? intval($_POST['km_manual']) : null;

// ==============================
// Procesar archivo factura
// ==============================
$factura = null;
if (!empty($_FILES['factura']['name'])) {
    $targetDir = "../../../archivos/files/files_mantenimientos_demo/facturas_mantenimientos_demo/";
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

    $filename = time() . "_" . basename($_FILES["factura"]["name"]);
    $targetFile = $targetDir . $filename;

    if (move_uploaded_file($_FILES["factura"]["tmp_name"], $targetFile)) {
        $factura = $targetFile;
    }
}

// ==============================
// Construir SQL dinámico
// ==============================
$sql = "UPDATE mantenimientos_demo SET 
    id_tipo_mantenimiento = ?, 
    id_estatus_mantenimiento = ?, 
    fecha_salida = ?, 
    taller = ?, 
    costo_estimado = ?, 
    descripcion_trabajo = ?, 
    proximo_km = ?, 
    proximo_fecha = ?, 
    km_actual = ?, 
    km_manual = ?";

if ($factura) {
    $sql .= ", factura = ?";
}

$sql .= " WHERE id_mantenimiento = ?";

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Error prepare: " . $conexion->error]);
    exit;
}

// ==============================
// Vincular parámetros
// ==============================
if ($factura) {
    $stmt->bind_param(
        "iissdsisiisi",
        $id_tipo_mantenimiento,
        $id_estatus_mantenimiento,
        $fecha_salida,
        $taller,
        $costo_estimado,
        $descripcion_trabajo,
        $proximo_km,
        $proximo_fecha,
        $km_actual,
        $km_manual,
        $factura,
        $id_mantenimiento
    );
} else {
    $stmt->bind_param(
        "iissdsisiii",
        $id_tipo_mantenimiento,
        $id_estatus_mantenimiento,
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

// ==============================
// Ejecutar actualización
// ==============================
if ($stmt->execute()) {
    $response = ["success" => true, "message" => "Mantenimiento actualizado correctamente"];
} else {
    $response = ["success" => false, "message" => "Error execute: " . $stmt->error];
}

$stmt->close();
$conexion->close();

echo json_encode($response);
?>
