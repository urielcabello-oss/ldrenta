<?php

header('Content-Type: application/json');

require("../../conexion.php");

try {

    $id_unidad = intval($_POST['id_unidad']);

    $placa = trim($_POST['placa']);
    $vin = trim($_POST['vin']);
    $motor = trim($_POST['motor']);
    $km = floatval($_POST['kilometraje']);

    $sql = "UPDATE unidades SET

                placa = ?,
                vin = ?,
                numero_motor = ?,
                ultimo_kilometraje = ?

            WHERE id_unidad = ?";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "sssdi",
        $placa,
        $vin,
        $motor,
        $km,
        $id_unidad
    );

    $stmt->execute();

    echo json_encode([
        "status" => "success",
        "message" => "Unidad actualizada correctamente"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);

}