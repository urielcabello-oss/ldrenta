<?php

include("../../conexion.php");

$response = [
    "success" => true,
    "incidencias" => []
];

$query = "

SELECT
i.*,
m.nombre_marca,
mo.nombre_modelo,

CONCAT(
    m.nombre_marca,
    ' ',
    mo.nombre_modelo
) AS modelo

FROM incidencias i

INNER JOIN unidades u
ON u.id_unidad = i.id_unidad

INNER JOIN modelos mo
ON mo.id_modelo = u.id_modelo

INNER JOIN marcas m
ON m.id_marca = mo.id_marca

ORDER BY i.id_incidencia DESC

";

$resultado = mysqli_query($conexion, $query);

while ($fila = mysqli_fetch_assoc($resultado)) {

    $response["incidencias"][] = $fila;

}

echo json_encode($response);