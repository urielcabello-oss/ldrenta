<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../../Servidor/conexion.php");

header('Content-Type: application/json');

if (!isset($_GET['idAsignacionUnidadDemo']) || !isset($_GET['fi']) || !isset($_GET['ff'])) {
    echo json_encode(['error' => 'Parámetros faltantes']);
    exit;
}

$idAsignacion = intval($_GET['idAsignacionUnidadDemo']);
$fechaInicio = $_GET['fi'];
$fechaFin = $_GET['ff'];

// 1. Buscar datos ya guardados en la BD para esta asignación y rango
$sql = "SELECT * FROM monitoreos_prueba_unidad_demos 
        WHERE id_asignacion_unidad_demo = ? AND fecha BETWEEN ? AND ? 
        ORDER BY fecha ASC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("iss", $idAsignacion, $fechaInicio, $fechaFin);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $datos = [];
    while ($row = $result->fetch_assoc()) {
        $datos[] = [
            'FECHA' => $row['fecha'],
            'consumoTotalComb' => floatval($row['consumo_combustible']),
            'distanciaTotalRec' => floatval($row['distancia_recorrida']),
            'hrmotorTotal' => floatval($row['horas_motor']),
            'hrmotorRelentiTotal' => floatval($row['horas_motor_ralenti']),
            'combustibleRelentiTotal' => floatval($row['combustible_ralenti']),
            'adbluelevel' => floatval($row['adblue_level']),
            'usoFrenoTotal' => floatval($row['uso_freno_total']),
            'precioCombustible' => floatval($row['precio_combustible']),
        ];
    }
    echo json_encode($datos);
    exit;
}

// 2. No hay datos guardados, obtener el id_telematics desde la relación unidad/asignación
$queryUnidad = "SELECT u.id_telematics FROM unidades u
                INNER JOIN asignacion_unidad_demo a ON u.id_unidad = a.id_unidad
                WHERE a.id_asignacion_unidad_demo = ? LIMIT 1";

$stmtUnidad = $conexion->prepare($queryUnidad);
$stmtUnidad->bind_param("i", $idAsignacion);
$stmtUnidad->execute();
$resultUnidad = $stmtUnidad->get_result();

if ($resultUnidad->num_rows === 0) {
    echo json_encode(['error' => 'No se encontró la unidad o su id_telematics']);
    exit;
}

$unidadData = $resultUnidad->fetch_assoc();
$idTelematics = $unidadData['id_telematics'];

// 3. Consultar API externa con id_telematics y fechas
$url = "http://advancedatalab.telematicsadvance.com.mx:3500/appi/rendimientoagrupadodia/{$idTelematics}&{$fechaInicio}&{$fechaFin}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if ($response === false) {
    echo json_encode(['error' => 'No se pudo conectar con la API externa']);
    exit;
}

curl_close($ch);

$data_api = json_decode($response, true);

if (!$data_api || !is_array($data_api)) {
    echo json_encode(['error' => 'Respuesta inválida de la API externa']);
    exit;
}

// 4. Insertar datos en BD para cachear y evitar futuras llamadas
$insert_sql = "INSERT INTO monitoreos_prueba_unidad_demos (
    id_asignacion_unidad_demo, fecha, consumo_combustible, distancia_recorrida,
    horas_motor, horas_motor_ralenti, combustible_ralenti, adblue_level,
    uso_freno_total, precio_combustible
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$insert_stmt = $conexion->prepare($insert_sql);

foreach ($data_api as $item) {
    $fecha = $item['FECHA'] ?? null;
    if (!$fecha) continue;

    $consumo = floatval($item['consumoTotalComb'] ?? 0);
    $distancia = floatval($item['distanciaTotalRec'] ?? 0);
    $horasMotor = floatval($item['hrmotorTotal'] ?? 0);
    $horasRalenti = floatval($item['hrmotorRelentiTotal'] ?? 0);
    $combRalenti = floatval($item['combustibleRelentiTotal'] ?? 0);
    $adblue = floatval($item['adbluelevel'] ?? 0);
    $usoFreno = floatval($item['usoFrenoTotal'] ?? 0);
    $precioComb = floatval($item['precioCombustible'] ?? 0);

    $insert_stmt->bind_param(
        "issddddddd",
        $idAsignacion,
        $fecha,
        $consumo,
        $distancia,
        $horasMotor,
        $horasRalenti,
        $combRalenti,
        $adblue,
        $usoFreno,
        $precioComb
    );
    $insert_stmt->execute();
}

// 5. Devolver datos para mostrar en frontend
echo json_encode($data_api);
exit;
