<?php

function registrarUnidadDemo($conexion, $post, $files, $id_creador)
{

    try {

        // =========================================
        // VARIABLES
        // =========================================

        $modelo = intval($post['modelounidad']);
        $estado = intval($post['estadounidad']);
        $estatus = intval($post['estatusunidad']);
        $tipo = intval($post['tipounidad']);
        $tipo_adquisicion = intval($post['tipoadquisicion']);
        $sede = intval($post['sedeunidad']);

        $placa = trim($post['placaunidad']);
        $vin = trim($post['vin']);

        $motor = trim($post['motorunidad']);
        $costo = !empty($post['costoneto']) ? floatval($post['costoneto']) : null;

        $color = !empty($post['colorunidad']) ? intval($post['colorunidad']) : null;

        $fecha_adquisicion = !empty($post['fechaadquisicion'])
            ? $post['fechaadquisicion']
            : null;

        $anio = !empty($post['anounidad'])
            ? intval($post['anounidad'])
            : date('Y');

        $arrendadora = !empty($post['arrendadora'])
            ? intval($post['arrendadora'])
            : null;

        $folio_factura = !empty($post['foliofactura'])
            ? trim($post['foliofactura'])
            : 'SIN FACTURA';

        $paso_diferencial = !empty($post['pasodiferencial'])
            ? floatval($post['pasodiferencial'])
            : null;

        // =========================================
        // VALIDAR DUPLICADOS
        // =========================================

        $sqlExiste = "SELECT id_unidad
                      FROM unidades
                      WHERE vin = ?
                      OR placa = ?";

        $stmtExiste = $conexion->prepare($sqlExiste);

        $stmtExiste->bind_param("ss", $vin, $placa);

        $stmtExiste->execute();

        $resultadoExiste = $stmtExiste->get_result();

        if ($resultadoExiste->num_rows > 0) {

            return [
                "status" => "error",
                "message" => "La placa o VIN ya existen"
            ];
        }

        // =========================================
        // IMAGEN
        // =========================================

        $nombreImagen = null;

        if (
            isset($files['imagen_unidad']) &&
            $files['imagen_unidad']['error'] === 0
        ) {

            $directorio = "../../img/unidades/";

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $extension = pathinfo(
                $files['imagen_unidad']['name'],
                PATHINFO_EXTENSION
            );

            $nombreImagen = uniqid() . "." . $extension;

            $rutaDestino = $directorio . $nombreImagen;

            move_uploaded_file(
                $files['imagen_unidad']['tmp_name'],
                $rutaDestino
            );
        }

        // =========================================
        // INSERT
        // =========================================

        $sql = "INSERT INTO unidades (

            id_creador_unidad,
            id_modelo,
            fecha_alta,
            id_estado_unidad,
            id_estatus_unidad,
            id_tipo_unidad,
            id_tipo_adquisicion,
            id_sede,
            placa,
            vin,
            numero_motor,
            costo_neto,
            id_color,
            img_unidad,
            fecha_adquisicion,
            año_unidad,
            id_arrendadora,
            folio_factura,
            paso_diferencial

        ) VALUES (

            ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?

        )";

        $stmt = $conexion->prepare($sql);

       $stmt->bind_param(

    "iiiiiiisssdisisisd",

    $id_creador,
    $modelo,
    $estado,
    $estatus,
    $tipo,
    $tipo_adquisicion,
    $sede,
    $placa,
    $vin,
    $motor,
    $costo,
    $color,
    $nombreImagen,
    $fecha_adquisicion,
    $anio,
    $arrendadora,
    $folio_factura,
    $paso_diferencial
);

        $stmt->execute();

        return [
            "status" => "success",
            "message" => "La unidad fue registrada correctamente"
        ];
    } catch (Exception $e) {

        return [
            "status" => "error",
            "message" => $e->getMessage()
        ];
    }
}
