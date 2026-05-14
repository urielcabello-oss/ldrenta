<?php
header('Content-Type: application/json');
include("../../conexion.php");

if (!isset($_GET['vin'])) {
    echo json_encode(["error" => "Falta el VIN"]);
    exit;
}

$vin = $_GET['vin'];

// Buscar la ubicación en la tabla `unidades`
$stmt = $conexion->prepare("SELECT ultima_ubicacion FROM unidades WHERE vin = ?");
$stmt->bind_param("s", $vin);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $ubicacion = $fila['ultima_ubicacion'];

    if ($ubicacion && strpos($ubicacion, ',') !== false) {
        list($lat, $lng) = explode(',', $ubicacion);
        echo json_encode([
            "lat" => (float)$lat,
            "lng" => (float)$lng
        ]);
    } else {
        echo json_encode(["error" => "Ubicación no disponible"]);
    }
} else {
    echo json_encode(["error" => "VIN no encontrado"]);
}
?>
