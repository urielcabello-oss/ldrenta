<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include("../../conexion.php");

$response = [
    "success" => true,
    "total" => 0,
    "abiertas" => 0,
    "proceso" => 0,
    "finalizadas" => 0,
    "criticas" => 0,
    "accidentes" => 0,
    "robos" => 0
];

//=====================================================
// TOTAL
//=====================================================

$query = mysqli_query(
    $conexion,
    "SELECT COUNT(*) AS total
     FROM incidencias"
);

$response["total"] =
    mysqli_fetch_assoc($query)['total'];


//=====================================================
// ABIERTAS
//=====================================================

$query = mysqli_query(
    $conexion,
    "SELECT COUNT(*) AS total
     FROM incidencias
     WHERE estatus = 'ABIERTA'"
);

$response["abiertas"] =
    mysqli_fetch_assoc($query)['total'];


//=====================================================
// EN PROCESO
//=====================================================

$query = mysqli_query(
    $conexion,
    "SELECT COUNT(*) AS total
     FROM incidencias
     WHERE estatus = 'EN_PROCESO'"
);

$response["proceso"] =
    mysqli_fetch_assoc($query)['total'];


//=====================================================
// FINALIZADAS
//=====================================================

$query = mysqli_query(
    $conexion,
    "SELECT COUNT(*) AS total
     FROM incidencias
     WHERE estatus IN ('RESUELTA','CERRADA')"
);

$response["finalizadas"] =
    mysqli_fetch_assoc($query)['total'];


//=====================================================
// CRITICAS
//=====================================================

$query = mysqli_query(
    $conexion,
    "SELECT COUNT(*) AS total
     FROM incidencias
     WHERE prioridad IN ('ALTA','CRITICA')"
);

$response["criticas"] =
    mysqli_fetch_assoc($query)['total'];


//=====================================================
// ACCIDENTES
//=====================================================

$query = mysqli_query(
    $conexion,
    "SELECT COUNT(*) AS total
     FROM incidencias
     WHERE tipo_incidencia LIKE 'ACCIDENTE%'"
);

$response["accidentes"] =
    mysqli_fetch_assoc($query)['total'];


//=====================================================
// ROBOS
//=====================================================

$query = mysqli_query(
    $conexion,
    "SELECT COUNT(*) AS total
     FROM incidencias
     WHERE tipo_incidencia LIKE 'ROBO%'"
);

$response["robos"] =
    mysqli_fetch_assoc($query)['total'];

echo json_encode($response);