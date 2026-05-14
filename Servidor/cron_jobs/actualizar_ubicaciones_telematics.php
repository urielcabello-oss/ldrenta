<?php
// Datos de la API
$apiUrl = 'https://www.telematicsadvance.com/api/v1/unit/list.json';
$apiKey = '763fcd49ab3a7bc87060e21d822c37e45d1ab780';

// Conexión a la base de datos
include("../../Servidor/conexion.php");

echo "Conectado a la base de datos<br>";

// Obtener datos de la API
$response = file_get_contents("$apiUrl?key=$apiKey");
if ($response === false) {
    die("Error al conectar con la API");
}

echo "Recibido respuesta de la API<br>";

$data = json_decode($response, true);
$unidades_api = $data['data']['units'] ?? [];

if (empty($unidades_api)) {
    die("No se encontraron unidades");
}

echo "Encontradas " . count($unidades_api) . " unidades en la API<br>";

// Obtener VINs desde la base de datos
$consulta = "SELECT vin FROM unidades";
$resultado = mysqli_query($conexion, $consulta);

$mis_vins = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $mis_vins[] = trim($fila['vin']);
}

echo "Se han obtenido " . count($mis_vins) . " VINs desde la base de datos<br>";

// Recorrer unidades de la API
foreach ($unidades_api as $unidad_api) {
    $vin_api = trim($unidad_api['vin'] ?? '');
    if (!in_array($vin_api, $mis_vins)) {
        continue;
    }

    $unit_id = $unidad_api['id'] ?? $unidad_api['unit_id'] ?? null;
    $lat = $unidad_api['lat'] ?? null;
    $lng = $unidad_api['lng'] ?? null;

    // Caso 1: Ya tiene lat/lng desde unit/list.json
    if ($lat && $lng) {
        echo "✅ VIN $vin_api -> LAT=$lat, LON=$lng (desde lista)<br>";
        $latlon = "$lat,$lng";
        $update = "UPDATE unidades SET ultima_ubicacion = '$latlon' WHERE vin = '$vin_api'";
        mysqli_query($conexion, $update);
        continue;
    }

    // Caso 2: No tiene lat/lng, intentar con last-position.json
    if ($unit_id) {
        $url_pos = "https://www.telematicsadvance.com/api/v1/unit/last-position.json?key=$apiKey&id=$unit_id";
        $response_pos = @file_get_contents($url_pos);

        if ($response_pos === false) {
            echo "❌ Error obteniendo la ubicación (404 o vacío) para VIN $vin_api con unit_id $unit_id<br>";
            continue;
        }

        $pos_data = json_decode($response_pos, true);
        $lat = $pos_data['data']['position']['lat'] ?? null;
        $lng = $pos_data['data']['position']['lon'] ?? null;

        if ($lat && $lng) {
            echo "✅ VIN $vin_api -> LAT=$lat, LON=$lng (desde last-position)<br>";
            $latlon = "$lat,$lng";
            $update = "UPDATE unidades SET ultima_ubicacion = '$latlon' WHERE vin = '$vin_api'";
            mysqli_query($conexion, $update);
        } else {
            echo "❌ Sin ubicación en last-position para VIN $vin_api<br>";
        }
    } else {
        echo "⚠️ VIN $vin_api no tiene unit_id válido<br>";
    }
}
?>
