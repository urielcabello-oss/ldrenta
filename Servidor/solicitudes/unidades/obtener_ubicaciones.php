<?php
include("../../conexion.php");

$sql = "SELECT id_ubicacion, ubicacion_unidad FROM ubicaciones WHERE activo = 1";
$result = $conexion->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);