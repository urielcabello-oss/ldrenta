<?php

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../../conexion.php");

$response = [
    "success" => false,
    "unidades" => []
];

try {

    $query = "
        SELECT
            u.id_unidad,
            u.vin,
            u.placa,
            ma.nombre_marca,
            mo.nombre_modelo
        FROM unidades u
        INNER JOIN modelos mo
            ON u.id_modelo = mo.id_modelo
        INNER JOIN marcas ma
            ON mo.id_marca = ma.id_marca
        ORDER BY ma.nombre_marca ASC
    ";

    $resultado =
        mysqli_query($conexion, $query);

    if (!$resultado) {

        throw new Exception(
            mysqli_error($conexion)
        );

    }

    while ($fila = mysqli_fetch_assoc($resultado)) {

        $response["unidades"][] = $fila;

    }

    $response["success"] = true;

} catch (Exception $e) {

    $response["message"] =
        $e->getMessage();

}

echo json_encode($response);