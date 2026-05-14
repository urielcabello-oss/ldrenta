<?php
include("../../../conexion.php");

$sql = "SELECT id_tipo_mantenimiento, nombre_tipo_mantenimiento FROM tipo_mantenimiento ORDER BY id_tipo_mantenimiento ASC";
$result = $conexion->query($sql);

$data = [];
while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>