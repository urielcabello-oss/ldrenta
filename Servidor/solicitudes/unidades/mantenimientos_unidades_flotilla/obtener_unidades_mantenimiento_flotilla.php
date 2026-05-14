<?php
// obtener_unidades_mantenimiento_demo.php
header('Content-Type: application/json; charset=utf-8');

// Ajusta la ruta al archivo de conexión según tu estructura
include("../../../conexion.php");

// Si tu conexion usa otra variable ($conexion) adapta $conexion abajo
// Por ejemplo: $conexion = $conexion;
if (!isset($conexion) && isset($conexion)) $conexion = $conexion;

// recibir parámetro de búsqueda opcional q
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT 
          u.id_unidad,
          u.placa,
          u.vin,
          u.numero_motor,
          u.costo_neto,
          u.id_modelo,
          m.nombre_modelo,
          m.id_marca,
          mar.nombre_marca,
          u.id_estado_unidad,
          u.id_estatus_unidad,
          u.id_sede,
          u.id_tipo_unidad
        FROM unidades u
        LEFT JOIN modelos m ON u.id_modelo = m.id_modelo
        LEFT JOIN marcas mar ON m.id_marca = mar.id_marca
        WHERE u.id_tipo_unidad = 1";

// Si viene query q => filtrar por VIN, placa, número de motor o modelo/marca
if ($q !== '') {
    // seguridad básica
    $like = '%' . $q . '%';
    $sql .= " AND (u.vin LIKE ? OR u.placa LIKE ? OR u.numero_motor LIKE ? OR m.nombre_modelo LIKE ? OR mar.nombre_marca LIKE ?)
              LIMIT 20";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssss", $like, $like, $like, $like, $like);
    $stmt->execute();
    $res = $stmt->get_result();
} else {
    // sin filtro: devolver hasta 200 filas (ajusta si quieres)
    $sql .= " ORDER BY u.placa ASC LIMIT 200";
    $res = $conexion->query($sql);
    if (!$res) {
        echo json_encode(["error" => $conexion->error]);
        exit;
    }
}

// recolectar resultados
$data = [];
while ($row = $res->fetch_assoc()) {
    // normalizar nombres nulos
    $row['modelo'] = $row['nombre_modelo'] ?? '';
    $row['marca']  = $row['nombre_marca'] ?? '';
    $row['placas']  = $row['placa'] ?? '';
    $data[] = $row;
}

echo json_encode($data);
