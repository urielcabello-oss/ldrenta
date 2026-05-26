<?php

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 0);

include("../../conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

$response = [
    "success" => false,
    "message" => ""
];

try {

    //========================================================
    // VALIDAR SESION
    //========================================================

    if (!isset($_SESSION['id_colaborador'])) {

        throw new Exception("Sesión no válida");
    }

    $id_colaborador =
        $_SESSION['id_colaborador'];

    //========================================================
    // OBTENER DATOS
    //========================================================

    $id_unidad =
        $_POST['id_unidad'] ?? null;

    $tipo_incidencia =
        trim($_POST['tipo_incidencia'] ?? '');

    $prioridad =
        trim($_POST['prioridad'] ?? 'MEDIA');

    $fecha_incidencia =
        $_POST['fecha_incidencia'] ?? null;

    $ubicacion =
        trim($_POST['ubicacion'] ?? '');

    $titulo =
        trim($_POST['titulo'] ?? '');

    $descripcion =
        trim($_POST['descripcion'] ?? '');

    $requiere_taller =
        isset($_POST['requiere_taller']) ? 1 : 0;

    $requiere_seguro =
        isset($_POST['requiere_seguro']) ? 1 : 0;

    $requiere_juridico =
        isset($_POST['requiere_juridico']) ? 1 : 0;

    //========================================================
    // VALIDACIONES
    //========================================================

    if (empty($id_unidad)) {

        throw new Exception("Seleccione una unidad");
    }

    if (empty($titulo)) {

        throw new Exception("Ingrese un título");
    }

    //========================================================
    // GENERAR FOLIO
    //========================================================

    $folio =
        "INC-" .
        date("Ymd") .
        "-" .
        strtoupper(substr(uniqid(), -5));

    //========================================================
    // INICIAR TRANSACCION
    //========================================================

    mysqli_begin_transaction($conexion);

    //========================================================
    // INSERTAR INCIDENCIA
    //========================================================

    $query = "
        INSERT INTO incidencias (
            folio_incidencia,
            id_unidad,
            id_colaborador_reporta,
            tipo_incidencia,
            prioridad,
            titulo,
            descripcion,
            fecha_incidencia,
            ubicacion,
            requiere_taller,
            requiere_seguro,
            requiere_juridico
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
    ";

    $stmt =
        mysqli_prepare($conexion, $query);
    if (!$stmt) {
        throw new Exception(mysqli_error($conexion));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "siissssssiii",
        $folio,
        $id_unidad,
        $id_colaborador,
        $tipo_incidencia,
        $prioridad,
        $titulo,
        $descripcion,
        $fecha_incidencia,
        $ubicacion,
        $requiere_taller,
        $requiere_seguro,
        $requiere_juridico
    );

    if (!mysqli_stmt_execute($stmt)) {

        throw new Exception(
            "Error al registrar incidencia"
        );
    }

    $id_incidencia =
        mysqli_insert_id($conexion);

    //========================================================
    // SUBIR EVIDENCIAS
    //========================================================

    if (
        isset($_FILES['evidencias']) &&
        !empty($_FILES['evidencias']['name'][0])
    ) {

        $rutaBase =
            "../../evidencias/files/incidencias/";

        // crear carpeta si no existe
        if (!file_exists($rutaBase)) {

            mkdir($rutaBase, 0777, true);
        }

        foreach ($_FILES['evidencias']['tmp_name'] as $index => $tmpName) {

            if ($_FILES['evidencias']['error'][$index] === 0) {

                $nombreOriginal =
                    $_FILES['evidencias']['name'][$index];

                $tipoArchivo =
                    $_FILES['evidencias']['type'][$index];

                $extension =
                    pathinfo(
                        $nombreOriginal,
                        PATHINFO_EXTENSION
                    );

                $nombreArchivo =
                    "INC_" .
                    $id_incidencia .
                    "_" .
                    uniqid() .
                    "." .
                    $extension;

                $rutaFisica =
                    $rutaBase .
                    $nombreArchivo;

                // ruta para navegador
                $rutaBD =
                    "Servidor/evidencias/files/incidencias/" .
                    $nombreArchivo;

                if (
                    move_uploaded_file(
                        $tmpName,
                        $rutaFisica
                    )
                ) {

                    $queryEvidencia = "
        INSERT INTO incidencias_evidencias (
            id_incidencia,
            nombre_archivo,
            ruta_archivo,
            tipo_archivo
        )
        VALUES (?, ?, ?, ?)
    ";

                    $stmtEvidencia =
                        mysqli_prepare(
                            $conexion,
                            $queryEvidencia
                        );

                    mysqli_stmt_bind_param(
                        $stmtEvidencia,
                        "isss",
                        $id_incidencia,
                        $nombreOriginal,
                        $rutaBD,
                        $tipoArchivo
                    );

                    mysqli_stmt_execute(
                        $stmtEvidencia
                    );
                }
            }
        }
    }

    //========================================================
    // INSERTAR HISTORIAL
    //========================================================

    $accion =
        "INCIDENCIA REGISTRADA";

    $comentario =
        "Se registró la incidencia con folio " .
        $folio;

    $queryHistorial = "
        INSERT INTO incidencias_historial (
            id_incidencia,
            id_colaborador,
            accion,
            comentario
        )
        VALUES (?, ?, ?, ?)
    ";

    $stmtHistorial =
        mysqli_prepare(
            $conexion,
            $queryHistorial
        );

    mysqli_stmt_bind_param(
        $stmtHistorial,
        "iiss",
        $id_incidencia,
        $id_colaborador,
        $accion,
        $comentario
    );

    mysqli_stmt_execute(
        $stmtHistorial
    );

    //========================================================
    // CONFIRMAR TRANSACCION
    //========================================================

    mysqli_commit($conexion);

    $response["success"] = true;
    $response["message"] = "Incidencia registrada";
    $response["folio"] = $folio;
} catch (Exception $e) {

    mysqli_rollback($conexion);

    $response["message"] =
        $e->getMessage();
}

echo json_encode($response);
