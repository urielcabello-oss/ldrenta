<?php
// Datos de la API
$apiUrl = 'https://www.telematicsadvance.com/api/v1/unit/list.json';
$apiKey = '763fcd49ab3a7bc87060e21d822c37e45d1ab780';

// Conexión a la base de datos
include("../../Servidor/conexion.php");

echo "Conectado a la base de datos\n";

// Obtener datos de la API
$response = file_get_contents("$apiUrl?key=$apiKey");

if ($response === false) {
    die("Error al conectar con la API");
}

echo "Recibido respuesta de la API\n";

$data = json_decode($response, true);

// Verifica que haya unidades
if (!isset($data['data']['units'])) {
    die("No se encontraron unidades");
}

echo "Encontradas " . count($data['data']['units']) . " unidades\n";

foreach ($data['data']['units'] as $unit) {
    $vin = isset($unit['vin']) ? $unit['vin'] : null;
    $kilometraje = isset($unit['mileage']) ? $unit['mileage'] / 1000 : null; // Convertir a km

    echo "Procesando unidad con VIN $vin\n";

    if ($vin && is_numeric($kilometraje)) {
        // Opcional: solo actualiza si el nuevo kilometraje es mayor
        $stmtCheck = $conexion->prepare("SELECT ultimo_kilometraje FROM unidades WHERE vin = ?");
        $stmtCheck->bind_param("s", $vin);
        $stmtCheck->execute();
        $stmtCheck->bind_result($kmActual);
        $stmtCheck->fetch();
        $stmtCheck->close();

        echo "Kilometraje actual en la base de datos: $kmActual\n";

        if ($kmActual === null || $kilometraje > $kmActual) {
            $stmt = $conexion->prepare("UPDATE unidades SET ultimo_kilometraje = ? WHERE vin = ?");
            $stmt->bind_param("ds", $kilometraje, $vin);
            $stmt->execute();
            file_put_contents('log_kilometraje.txt', "[" . date('Y-m-d H:i:s') . "] VIN $vin actualizado a $kilometraje km\n", FILE_APPEND);
            $stmt->close();
            echo "Actualizado el kilometraje de la unidad con VIN $vin\n";
        }
    }
}

$conexion->close();
echo "Actualización completa.\n";
?>

