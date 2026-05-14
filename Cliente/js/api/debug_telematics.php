<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../../Servidor/conexion.php");

// Cambia este ID por el que quieres probar
$idAsignacionUnidadDemo = 22;

echo "<h2>Debug Telematics</h2>";

// 1. Verificar asignación
$queryAsignacion = "SELECT * FROM asignacion_unidad_demo WHERE id_asignacion_unidad_demo = ?";
$stmtAsign = $conexion->prepare($queryAsignacion);
$stmtAsign->bind_param("i", $idAsignacionUnidadDemo);
$stmtAsign->execute();
$resultAsign = $stmtAsign->get_result();

if ($resultAsign->num_rows === 0) {
    die("❌ No existe la asignación con ID: $idAsignacionUnidadDemo");
}

$asignacion = $resultAsign->fetch_assoc();
echo "✅ Asignación encontrada: <pre>" . print_r($asignacion, true) . "</pre>";

// 2. Obtener unidad relacionada
$idUnidad = $asignacion['id_unidad'];
$queryUnidad = "SELECT * FROM unidades WHERE id_unidad = ?";
$stmtUnidad = $conexion->prepare($queryUnidad);
$stmtUnidad->bind_param("i", $idUnidad);
$stmtUnidad->execute();
$resultUnidad = $stmtUnidad->get_result();

if ($resultUnidad->num_rows === 0) {
    die("❌ No existe unidad con ID: $idUnidad");
}

$unidad = $resultUnidad->fetch_assoc();
echo "✅ Unidad encontrada: <pre>" . print_r($unidad, true) . "</pre>";

// 3. Verificar id_telematics
$idTelematics = $unidad['id_telematics'] ?? null;
if (!$idTelematics) {
    die("❌ No hay id_telematics para esta unidad");
}
echo "✅ id_telematics encontrado: $idTelematics<br>";

// 4. Llamar a la API externa
$fechaInicio = '2025-07-01';
$fechaFin = '2025-07-03';
$url = "http://advancedatalab.telematicsadvance.com.mx:3500/appi/rendimientoagrupadodia/{$idTelematics}&{$fechaInicio}&{$fechaFin}";

echo "🔗 URL API: $url<br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "📌 Código HTTP: $httpCode<br>";
echo "📌 Respuesta de la API:<pre>$response</pre><br>";

$json = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "❌ Error JSON: " . json_last_error_msg();
} else {
    echo "✅ JSON válido recibido<br>";
    echo "<pre>" . print_r($json, true) . "</pre>";
}

?>
