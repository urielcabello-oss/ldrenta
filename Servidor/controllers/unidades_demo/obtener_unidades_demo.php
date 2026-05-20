<?php

require("../../conexion.php");
require("../../models/UnidadesDemoModel.php");

header('Content-Type: application/json');

try {

    $unidades = obtenerUnidadesDemo($conexion);

    echo json_encode([
        "status" => "success",
        "data" => $unidades
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);

}