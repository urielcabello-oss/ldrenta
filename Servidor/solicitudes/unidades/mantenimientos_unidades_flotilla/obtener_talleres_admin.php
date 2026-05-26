<?php

header('Content-Type: application/json');

include("../../../conexion.php");

$sql = "
SELECT
    id_taller,
    nombre_taller,
    direccion,
    telefono,
    contacto,
    estatus,
    fecha_registro
FROM talleres
ORDER BY nombre_taller ASC
";

$resultado = $conexion->query($sql);

$data = [];

while($row = $resultado->fetch_assoc()){

    $data[] = $row;

}

echo json_encode($data);