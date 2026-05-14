<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../../Servidor/conexion.php");
header('Content-Type: application/json');


// Obtener unidades demo con kilometraje de telematics
$sql_unidades = "SELECT 
        u.id_unidad,
        u.id_modelo,
        u.ultimo_kilometraje,
        m.km_mantenimiento
    FROM unidades u
    INNER JOIN modelos m ON m.id_modelo = u.id_modelo
    WHERE u.ultimo_kilometraje IS NOT NULL
      AND u.ultimo_kilometraje > 0
      AND u.id_tipo_unidad = 3
";
$res_unidades = $conexion->query($sql_unidades);

if (!$res_unidades) {
    echo json_encode(["success" => false, "message" => "Error consultando unidades: " . $conexion->error]);
    exit;
}

$generados = 0;
$intervalo = 10000; // cada 10,000 km

while ($u = $res_unidades->fetch_assoc()) {
    $id_unidad = (int)$u['id_unidad'];
    $km_actual = (float)$u['ultimo_kilometraje']; // ← Telematics
    $km_inicio = (float)($u['km_mantenimiento'] ?? 0);

    // Calcular próximo mantenimiento
    $proximo_km = $km_inicio;
    while ($proximo_km <= $km_actual) {
        $proximo_km += $intervalo;
    }

    // Verificar si ya existe mantenimiento pendiente o en proceso
    $check = $conexion->prepare("SELECT COUNT(*) 
        FROM mantenimientos_demo 
        WHERE id_unidad = ? 
          AND id_estatus_mantenimiento IN (2,3)
    ");
    $check->bind_param("i", $id_unidad);
    $check->execute();
    $check->bind_result($existe);
    $check->fetch();
    $check->close();

    // Si no hay mantenimiento activo, se crea uno nuevo automático (Telematics)
    if ($existe == 0) {
        $stmt_insert = $conexion->prepare("INSERT INTO mantenimientos_demo (
                id_unidad,
                id_tipo_mantenimiento,
                id_estatus_mantenimiento,
                taller,
                descripcion_trabajo,
                km_actual,
                proximo_km
            ) VALUES (?, 1, 3, 'Sin taller', 'Mantenimiento automático (Telematics)', ?, ?)
        ");
        $stmt_insert->bind_param("iii", $id_unidad, $km_actual, $proximo_km);

        if ($stmt_insert->execute()) {
            $generados++;
        }
        $stmt_insert->close();
    }
}

echo json_encode([
    "success" => true,
    "message" => "Verificación completada correctamente",
    "mantenimientos_generados" => $generados
]);
?>
