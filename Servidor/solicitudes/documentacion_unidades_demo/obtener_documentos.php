<?php

header('Content-Type: application/json');

include("../../conexion.php");

$response = [
    "success" => false,
    "documentos" => []
];

try {

    $sql = "
        SELECT 
            d.id_documento,
            d.tipo_documento,
            d.nombre_documento,
            d.uuid,
            d.folio,
            d.total,
            d.fecha_documento,
            d.archivo_xml,
            d.archivo_pdf,
            d.archivo_comprobante,
            d.subtotal,
            u.placa,
            u.vin
        FROM documentacion_unidades_demo d
        LEFT JOIN unidades u 
            ON u.id_unidad = d.id_unidad
        ORDER BY d.id_documento DESC
    ";

    $result = $conexion->query($sql);

    if (!$result) {
        throw new Exception($conexion->error);
    }

    while ($row = $result->fetch_assoc()) {
        $response["documentos"][] = $row;
    }

    $response["success"] = true;

} catch (Exception $e) {

    $response["message"] = $e->getMessage();

}

echo json_encode($response);