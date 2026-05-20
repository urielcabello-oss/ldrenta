<?php

include("../../../conexion.php");

$sql = "
SELECT 
    id_taller,
    nombre_taller
FROM talleres
WHERE estatus = 1
ORDER BY nombre_taller ASC
";

$resultado = $conexion->query($sql);

$talleres = [];

while($fila = $resultado->fetch_assoc()){

    $talleres[] = $fila;
}

echo json_encode($talleres);