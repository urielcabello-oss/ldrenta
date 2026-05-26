<?php

header('Content-Type: application/json');

include("../../conexion.php");

session_start();

$response = ["success" => false];

try {

    //=================================================
    // VARIABLES
    //=================================================

    $id_documento      = $_POST['id_documento'];

    $tipo_documento    = $_POST['tipo_documento'] ?? null;
    $categoria         = $_POST['categoria'] ?? null;
    $nombre_documento  = $_POST['nombre_documento'] ?? null;
    $folio             = $_POST['folio'] ?? null;
    $uuid              = $_POST['uuid'] ?? null;
    $rfc_emisor        = $_POST['rfc_emisor'] ?? null;
    $rfc_receptor      = $_POST['rfc_receptor'] ?? null;
    $subtotal          = $_POST['subtotal'] ?? 0;
    $iva               = $_POST['iva'] ?? 0;
    $total             = $_POST['total'] ?? 0;
    $fecha_documento   = $_POST['fecha_documento'] ?? null;
    $id_unidad         = $_POST['id_unidad'] ?: null;
    $observaciones     = $_POST['observaciones'] ?? null;

    //=================================================
    // OBTENER ARCHIVOS ACTUALES
    //=================================================

    $sqlActual = "SELECT
                    archivo_xml,
                    archivo_pdf,
                    archivo_comprobante
                  FROM documentacion_unidades_demo
                  WHERE id_documento = ?";

    $stmtActual = $conexion->prepare($sqlActual);

    $stmtActual->bind_param("i", $id_documento);

    $stmtActual->execute();

    $actual = $stmtActual
        ->get_result()
        ->fetch_assoc();

    $archivo_xml          = $actual['archivo_xml'];
    $archivo_pdf          = $actual['archivo_pdf'];
    $archivo_comprobante  = $actual['archivo_comprobante'];

    //=================================================
    // XML
    //=================================================

    if (
        isset($_FILES['archivo_xml']) &&
        $_FILES['archivo_xml']['error'] === 0
    ) {

        $nombreOriginal = $_FILES['archivo_xml']['name'];

        $nombreLimpio = preg_replace(
            '/[^A-Za-z0-9_\.\-]/',
            '_',
            $nombreOriginal
        );

        $nombre = time() . "_xml_" . $nombreLimpio;

        $ruta = "../../archivos/documentacion/xml/" . $nombre;

        if (!move_uploaded_file(
            $_FILES['archivo_xml']['tmp_name'],
            $ruta
        )) {

            throw new Exception("Error al subir XML");
        }

        $archivo_xml = $nombre;
    }

    //=================================================
    // PDF
    //=================================================

    if (
        isset($_FILES['archivo_pdf']) &&
        $_FILES['archivo_pdf']['error'] === 0
    ) {

        $nombreOriginal = $_FILES['archivo_pdf']['name'];

        $nombreLimpio = preg_replace(
            '/[^A-Za-z0-9_\.\-]/',
            '_',
            $nombreOriginal
        );

        $nombre = time() . "_pdf_" . $nombreLimpio;

        $ruta = "../../archivos/documentacion/pdf/" . $nombre;

        if (!move_uploaded_file(
            $_FILES['archivo_pdf']['tmp_name'],
            $ruta
        )) {

            throw new Exception("Error al subir PDF");
        }

        $archivo_pdf = $nombre;
    }

    //=================================================
    // EVIDENCIA
    //=================================================

    if (
        isset($_FILES['archivo_evidencia']) &&
        $_FILES['archivo_evidencia']['error'] === 0
    ) {

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

        // reutilizamos archivo_pdf
        $archivo_pdf = $nombre;
    }

    //=================================================
    // COMPROBANTE
    //=================================================

    if (
        isset($_FILES['archivo_comprobante']) &&
        $_FILES['archivo_comprobante']['error'] === 0
    ) {

        $nombreOriginal = $_FILES['archivo_comprobante']['name'];

        $nombreLimpio = preg_replace(
            '/[^A-Za-z0-9_\.\-]/',
            '_',
            $nombreOriginal
        );

        $nombre = time() . "_comp_" . $nombreLimpio;

        $ruta = "../../archivos/documentacion/comprobantes/" . $nombre;

        if (!move_uploaded_file(
            $_FILES['archivo_comprobante']['tmp_name'],
            $ruta
        )) {

            throw new Exception("Error al subir comprobante");
        }

        $archivo_comprobante = $nombre;
    }

    //=================================================
    // UPDATE
    //=================================================

    $sql = "UPDATE documentacion_unidades_demo
            SET
                tipo_documento = ?,
                categoria = ?,
                nombre_documento = ?,
                archivo_xml = ?,
                archivo_pdf = ?,
                archivo_comprobante = ?,
                uuid = ?,
                folio = ?,
                rfc_emisor = ?,
                rfc_receptor = ?,
                subtotal = ?,
                iva = ?,
                total = ?,
                fecha_documento = ?,
                id_unidad = ?,
                observaciones = ?
            WHERE id_documento = ?";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        throw new Exception($conexion->error);
    }

    $stmt->bind_param(
        "ssssssssssdddsssi",
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
        $observaciones,
        $id_documento
    );

    $stmt->execute();

    $response["success"] = true;

} catch (Exception $e) {

    $response["message"] = $e->getMessage();

}

echo json_encode($response);