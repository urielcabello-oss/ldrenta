<?php

header('Content-Type: application/json');

include("../../conexion.php");

$id_incidencia = $_POST['id_incidencia'];

$query = "
UPDATE incidencias
SET
    prioridad = ?,
    tipo_incidencia = ?,
    titulo = ?,
    descripcion = ?,
    ubicacion = ?,
    requiere_taller = ?,
    requiere_seguro = ?,
    requiere_juridico = ?
WHERE id_incidencia = ?
";

$stmt = $conexion->prepare($query);

$stmt->bind_param(
    "sssssiiii",
    $_POST['prioridad'],
    $_POST['tipo_incidencia'],
    $_POST['titulo'],
    $_POST['descripcion'],
    $_POST['ubicacion'],
    $_POST['requiere_taller'],
    $_POST['requiere_seguro'],
    $_POST['requiere_juridico'],
    $id_incidencia
);

if ($stmt->execute()) {
    //=====================================================
    // SUBIR NUEVAS EVIDENCIAS
    //=====================================================

    if (isset($_FILES['evidencias'])) {

        $carpeta = "../../evidencias/files/incidencias/";

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        foreach ($_FILES['evidencias']['tmp_name'] as $key => $tmp_name) {

            $nombreOriginal =
                $_FILES['evidencias']['name'][$key];

            $tipo =
                $_FILES['evidencias']['type'][$key];

            $extension =
                pathinfo(
                    $nombreOriginal,
                    PATHINFO_EXTENSION
                );

            // nombre físico REAL del servidor
            $nombreServidor =
                "INC_" .
                $id_incidencia .
                "_" .
                uniqid() .
                "." .
                $extension;

            $ruta_final =
                $carpeta .
                $nombreServidor;

            if (move_uploaded_file($tmp_name, $ruta_final)) {

                $ruta_bd =
                    "Servidor/evidencias/files/incidencias/" .
                    $nombreServidor;

                $insert = $conexion->prepare("
            INSERT INTO incidencias_evidencias
            (
                id_incidencia,
                nombre_archivo,
                ruta_archivo,
                tipo_archivo
            )
            VALUES (?, ?, ?, ?)
        ");

                $insert->bind_param(
                    "isss",
                    $id_incidencia,
                    $nombreOriginal,
                    $ruta_bd,
                    $tipo
                );

                $insert->execute();
            }
        }
    }

    echo json_encode([
        "success" => true
    ]);
} else {

    echo json_encode([
        "success" => false
    ]);
}
