<?php
// Mostrar errores solo para depuración (elimina en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir conexión
include("../../../conexion.php");

// Forzar JSON
header('Content-Type: application/json');
session_start();

// Respuesta por defecto
$response = ["success" => false, "message" => "Error desconocido"];

try {
    // Validar sesión
    if (!isset($_SESSION['id_colaborador'])) {
        throw new Exception("Usuario no autenticado");
    }
    $id_usuario = $_SESSION['id_colaborador'];

    // Campos obligatorios
    $id_unidad = $_POST['id_unidad'] ?? null;
    $id_tipo_mantenimiento = $_POST['id_tipo_mantenimiento'] ?? null;
    $km_actual = $_POST['km_actual'] ?? null;
    $fecha_ingreso = $_POST['fecha_ingreso'] ?? null;

    if (!$id_unidad || !$id_tipo_mantenimiento || !$km_actual || !$fecha_ingreso) {
        throw new Exception("Faltan campos obligatorios");
    }

    // Campos opcionales
    $fecha_salida = $_POST['fecha_salida'] ?? null;
    $taller = $_POST['taller'] ?? null;
    $costo_estimado = isset($_POST['costo_estimado']) && $_POST['costo_estimado'] !== '' ? $_POST['costo_estimado'] : 0;
    $descripcion_trabajo = $_POST['descripcion_trabajo'] ?? null;
    $proximo_km = isset($_POST['proximo_km']) && $_POST['proximo_km'] !== '' ? $_POST['proximo_km'] : 0;
    $proximo_fecha = $_POST['proximo_fecha'] ?? null;

    // Estatus inicial
    $id_estatus = 2; // Pendiente

    // Preparar SQL
    $sql = "INSERT INTO mantenimientos_flotilla (
                id_unidad, id_tipo_mantenimiento, id_estatus_mantenimiento,
                fecha_ingreso, fecha_salida, taller, costo_estimado,
                descripcion_trabajo, proximo_km, proximo_fecha,
                fecha_registro, id_usuario_registra, km_manual
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";

    $stmt = $conexion->prepare($sql);
    if (!$stmt) throw new Exception("Error al preparar la consulta: " . $conexion->error);

    // bind_param: i=int, d=double, s=string
    $stmt->bind_param(
    "iiisssdssisi",
    $id_unidad,
    $id_tipo_mantenimiento,
    $id_estatus,
    $fecha_ingreso,
    $fecha_salida,
    $taller,
    $costo_estimado,
    $descripcion_trabajo,
    $proximo_km,
    $proximo_fecha,
    $id_usuario,
    $km_actual
);

    if ($stmt->execute()) {
        $response = ["success" => true, "message" => "Mantenimiento registrado correctamente"];
    } else {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

} catch (Exception $e) {
    $response = ["success" => false, "message" => $e->getMessage()];
}

// Devolver JSON limpio
echo json_encode($response);
exit;
?>