<?php
header('Content-Type: application/json');
include("../../../conexion.php");

// Obtener unidades tipo 3 (demo/pool) con info de modelo
$sql = "
SELECT u.id_unidad, u.vin, u.placa, u.ultimo_kilometraje, 
       m.nombre_modelo, m.id_marca
FROM unidades u
LEFT JOIN modelos m ON u.id_modelo = m.id_modelo
WHERE u.id_tipo_unidad = 1
ORDER BY u.id_unidad
";

$res = mysqli_query($conexion, $sql);

$unidades = [];
while ($row = mysqli_fetch_assoc($res)) {
    $row['tiene_telemetria'] = ($row['ultimo_kilometraje'] > 0) ? true : false;
    $unidades[] = $row;
}

echo json_encode($unidades);
