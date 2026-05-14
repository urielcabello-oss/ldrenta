<?php
include("../../../conexion.php");

$sql = "SELECT id_estatus_mantenimiento, estatus FROM estatus_mantenimiento ORDER BY id_estatus_mantenimiento ASC";
$result = $conexion->query($sql);

$data = [];
while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>