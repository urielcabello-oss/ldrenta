<?php

header('Content-Type: application/json');

include("../../conexion.php");

$response = [
    "success" => false,
    "message" => ""
];

try {

    if (!isset($_POST['id_evidencia'])) {
        throw new Exception("ID inválido");
    }

    $id_evidencia =
        intval($_POST['id_evidencia']);

    //=====================================================
    // OBTENER EVIDENCIA
    //=====================================================

    $query = $conexion->prepare("
        SELECT *
        FROM incidencias_evidencias
        WHERE id_evidencia = ?
    ");

    $query->bind_param(
        "i",
        $id_evidencia
    );

    $query->execute();

    $resultado =
        $query->get_result();

    if ($resultado->num_rows === 0) {

        throw new Exception(
            "Evidencia no encontrada"
        );
    }

    $evidencia =
        $resultado->fetch_assoc();

    //=====================================================
    // RUTA FISICA
    //=====================================================

    $rutaFisica =
        "../../" .
        str_replace(
            "Servidor/",
            "",
            $evidencia['ruta_archivo']
        );

    //=====================================================
    // ELIMINAR ARCHIVO
    //=====================================================

    if (file_exists($rutaFisica)) {

        unlink($rutaFisica);

    }

    //=====================================================
    // ELIMINAR BD
    //=====================================================

    $delete = $conexion->prepare("
        DELETE FROM incidencias_evidencias
        WHERE id_evidencia = ?
    ");

    $delete->bind_param(
        "i",
        $id_evidencia
    );

    $delete->execute();

    $response["success"] = true;

} catch (Exception $e) {

    $response["message"] =
        $e->getMessage();

}

echo json_encode($response);