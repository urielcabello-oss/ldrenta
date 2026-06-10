<?php

header('Content-Type: application/json');

include("../../conexion.php");

$response = [
    "success" => false
];

try {

    $id = $_POST['id_unidad_sustituto'];

    mysqli_query(
        $conexion,
        "DELETE FROM unidades_sustituto
         WHERE id_unidad_sustituto = '$id'"
    );

    $response["success"] = true;
    $response["mensaje"] = "Relación eliminada correctamente.";

} catch(Exception $e) {

    $response["mensaje"] = $e->getMessage();
}

echo json_encode($response);