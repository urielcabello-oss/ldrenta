<?php

header('Content-Type: application/json');

include("../../conexion.php");

$response = ["success" => false];

try {

    $id = $_GET['id'];

    $sql = "SELECT * FROM documentacion_unidades_demo
            WHERE id_documento = ?";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    $documento = $result->fetch_assoc();

    $response["success"] = true;
    $response["documento"] = $documento;

} catch (Exception $e) {

    $response["message"] = $e->getMessage();

}

echo json_encode($response);