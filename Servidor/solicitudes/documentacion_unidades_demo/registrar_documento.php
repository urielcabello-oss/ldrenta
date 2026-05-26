<?php

header('Content-Type: application/json');

include("../../conexion.php");

session_start();

$response = ["success" => false];

try {

    $tipo_documento   = $_POST['tipo_documento'] ?? null;
    $categoria         = $_POST['categoria'] ?? null;
    $nombre_documento  = $_POST['nombre_documento'] ?? null;
    $folio             = $_POST['folio'] ?? null;
    $uuid              = $_POST['uuid'] ?? null;
    $rfc_emisor        = $_POST['rfc_emisor'] ?? null;
    $rfc_receptor      = $_POST['rfc_receptor'] ?? null;
    $subtotal          = $_POST['subtotal'] ?? 0;
    $iva               = $_POST['iva'] ?? 0;
    $total             = $_POST['total'] ?? 0;
    $total_comprobante = $_POST['total_comprobante'] ?? null;
    $fecha_documento   = $_POST['fecha_documento'] ?? null;
    $id_unidad         = $_POST['id_unidad'] ?: null;
    $observaciones     = $_POST['observaciones'] ?? null;

    // =================================================
    // XML
    // =================================================
    $archivo_xml = null;

    if (isset($_FILES['archivo_xml']) && $_FILES['archivo_xml']['error'] === 0) {

        $nombreOriginal = $_FILES['archivo_xml']['name'];
        $nombreLimpio = preg_replace('/[^A-Za-z0-9_\.\-]/', '_', $nombreOriginal);

        $nombre = time() . "_xml_" . $nombreLimpio;

        $ruta = "../../archivos/documentacion/xml/" . $nombre;

        if (!move_uploaded_file($_FILES['archivo_xml']['tmp_name'], $ruta)) {
            throw new Exception("Error al subir XML");
        }

        $archivo_xml = $nombre;
    }

    // =================================================
    // PDF
    // =================================================
    $archivo_pdf = null;

    if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] === 0) {

        $nombreOriginal = $_FILES['archivo_pdf']['name'];
        $nombreLimpio = preg_replace('/[^A-Za-z0-9_\.\-]/', '_', $nombreOriginal);

        $nombre = time() . "_pdf_" . $nombreLimpio;

        $ruta = "../../archivos/documentacion/pdf/" . $nombre;

        if (!move_uploaded_file($_FILES['archivo_pdf']['tmp_name'], $ruta)) {
            throw new Exception("Error al subir PDF");
        }

        $archivo_pdf = $nombre;
    }

    // =================================================
    // EVIDENCIA
    // =================================================

    $archivo_evidencia = null;

    if (isset($_FILES['archivo_evidencia']) && $_FILES['archivo_evidencia']['error'] === 0) {

        $nombreOriginal = $_FILES['archivo_evidencia']['name'];

        $nombreLimpio = preg_replace(
            '/[^A-Za-z0-9_\.\-]/',
            '_',
            $nombreOriginal
        );

        $nombre = time() . "_evidencia_" . $nombreLimpio;

        $ruta = "../../archivos/documentacion/pdf/" . $nombre;

        if (!move_uploaded_file(
            $_FILES['archivo_evidencia']['tmp_name'],
            $ruta
        )) {

            throw new Exception("Error al subir evidencia");
        }

        // reutilizamos archivo_pdf para guardar evidencia
        $archivo_pdf = $nombre;
    }

    // =================================================
    // COMPROBANTE
    // =================================================
    $archivo_comprobante = null;

    if (isset($_FILES['archivo_comprobante']) && $_FILES['archivo_comprobante']['error'] === 0) {

        $nombreOriginal = $_FILES['archivo_comprobante']['name'];
        $nombreLimpio = preg_replace('/[^A-Za-z0-9_\.\-]/', '_', $nombreOriginal);

        $nombre = time() . "_comp_" . $nombreLimpio;

        $ruta = "../../archivos/documentacion/comprobantes/" . $nombre;

        if (!move_uploaded_file($_FILES['archivo_comprobante']['tmp_name'], $ruta)) {
            throw new Exception("Error al subir comprobante");
        }

        $archivo_comprobante = $nombre;
    }

    // =================================================
    // INSERT
    // =================================================
    $sql = "INSERT INTO documentacion_unidades_demo (
        tipo_documento,
        categoria,
        nombre_documento,
        archivo_xml,
        archivo_pdf,
        archivo_comprobante,
        uuid,
        folio,
        rfc_emisor,
        rfc_receptor,
        subtotal,
        iva,
        total,
        fecha_documento,
        id_unidad,
        observaciones
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        throw new Exception($conexion->error);
    }

    $stmt->bind_param(
        "ssssssssssdddsss",
        $tipo_documento,
        $categoria,
        $nombre_documento,
        $archivo_xml,
        $archivo_pdf,
        $archivo_comprobante,
        $uuid,
        $folio,
        $rfc_emisor,
        $rfc_receptor,
        $subtotal,
        $iva,
        $total,
        $fecha_documento,
        $id_unidad,
        $observaciones
    );

    $stmt->execute();

    $response["success"] = true;
} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
