<?php

include("../../conexion.php");

$response = [
    "success" => false,
    "mensaje" => ""
];

try {

    $id_unidad = $_POST['id_unidad'];
    $unidades_sustitutas = $_POST['unidades_sustitutas'];

    mysqli_begin_transaction($conexion);

    mysqli_query(
        $conexion,
        "DELETE FROM unidades_sustituto
         WHERE id_unidad = '$id_unidad'"
    );

    foreach($unidades_sustitutas as $id_sustituta)
    {
        mysqli_query(
            $conexion,
            "INSERT INTO unidades_sustituto
            (
                id_unidad,
                id_unidad_sustituta,
                estado
            )
            VALUES
            (
                '$id_unidad',
                '$id_sustituta',
                1
            )"
        );
    }

    mysqli_commit($conexion);

    $response["success"] = true;
    $response["mensaje"] = "Asignaciones guardadas correctamente.";

}
catch(Exception $e){

    mysqli_rollback($conexion);

    $response["mensaje"] = $e->getMessage();
}

echo json_encode($response);