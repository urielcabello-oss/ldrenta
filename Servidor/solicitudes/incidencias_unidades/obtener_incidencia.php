<?php

include("../../conexion.php");

$response = [
    "success" => false
];

if (!isset($_GET["id"])) {

    echo json_encode($response);
    exit;
}

$id = $_GET["id"];

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

WHERE i.id_incidencia = '$id'

LIMIT 1

";

$resultado = mysqli_query($conexion, $query);

if ($fila = mysqli_fetch_assoc($resultado)) {

    $response["success"] = true;
    $response["incidencia"] = $fila;

    //=====================================================
    // OBTENER EVIDENCIAS
    //=====================================================

    $queryEvidencias = "

SELECT
id_evidencia,
nombre_archivo,
ruta_archivo,
tipo_archivo

FROM incidencias_evidencias

WHERE id_incidencia = '$id'

";

    $resultadoEvidencias =
        mysqli_query(
            $conexion,
            $queryEvidencias
        );

    $evidencias = [];   

    while (
        $evidencia =
        mysqli_fetch_assoc(
            $resultadoEvidencias
        )
    ) {

        $evidencias[] =
            $evidencia;
    }

    $response["evidencias"] =
        $evidencias;
}

echo json_encode($response);
