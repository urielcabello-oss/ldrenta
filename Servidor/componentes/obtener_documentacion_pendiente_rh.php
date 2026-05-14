<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../../Servidor/conexion.php");

$query = "

SELECT 
  t.id_tenencias AS id,
  NULL AS numero_licencia,
  NULL AS fecha_emision,
  t.fecha_vencimiento,
  NULL AS licencia_permanente,
  'tenencia' AS tipo,
  CONVERT(u.placa USING utf8mb4) AS unidad,
  CONVERT(CONCAT('../../Servidor/archivos/files/files_unidades/polizas_tenencias/', t.documento_tenencia) USING utf8mb4) AS ruta
FROM tenencias t
INNER JOIN unidades u ON u.id_unidad = t.id_unidad
WHERE t.estado_validacion = 0

UNION ALL

SELECT 
  v.id_verificaciones AS id,
  NULL AS numero_licencia,
  v.fecha_verificacion AS fecha_emision,
  v.fecha_siguiente_verificacion AS fecha_vencimiento,
  NULL AS licencia_permanente,
  'verificacion' AS tipo,
  CONVERT(u.placa USING utf8mb4) AS unidad,
  CONVERT(CONCAT('../../Servidor/archivos/files/files_unidades/polizas_verificaciones/', v.archivo_verificacion) USING utf8mb4) AS ruta
FROM verificaciones v
INNER JOIN unidades u ON u.id_unidad = v.id_unidad
WHERE v.estado_validacion = 0

UNION ALL

SELECT 
  l.id_licencia AS id,
  CONVERT(l.numero_licencia USING utf8mb4),
  l.fecha_emision,
  l.fecha_vencimiento,
  CONVERT(l.licencia_permanente USING utf8mb4),
  'licencia' AS tipo,
  CONVERT(CONCAT(
    c.nombre_1, ' ',
    IFNULL(c.nombre_2, ''), ' ',
    c.apellido_paterno, ' ',
    IFNULL(c.apellido_materno, '')
  ) USING utf8mb4) AS unidad,
  CONVERT(CONCAT('../../Servidor/archivos/files/files_licencias_conducir/', l.archivo_licencia) USING utf8mb4) AS ruta
FROM licencias_conducir l
INNER JOIN colaboradores c 
  ON c.id_colaborador = l.id_colaborador
WHERE l.estado_validacion = 0

";
$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en query: " . mysqli_error($conexion));
}

$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);

exit;
?>