<?php
include("../../conexion.php");
if (!isset($_SESSION)) session_start();

$id_asignacion = $_POST['id_asignacion'] ?? null;
$id_colaborador = $_SESSION['id_colaborador'] ?? null;

if (!$id_asignacion || !$id_colaborador) {
    echo "Faltan datos necesarios";
    exit;
}

// Obtener la asignación (para saber si es persona física o moral)
$sql = "SELECT id_persona_fisica, id_persona_moral 
        FROM asignacion_unidad_demo 
        WHERE id_asignacion_unidad_demo = $id_asignacion";
$res = $conexion->query($sql);
$asignacion = $res->fetch_assoc();

if (!$asignacion) {
    echo "Asignación no encontrada";
    exit;
}

// Rutas base
$basePathFisica = "../../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/";
$basePathMoral = "../../../Servidor/archivos/files/files_asignacion_demo/personas_morales/";

// Asegurar que las carpetas existen
function asegurarCarpeta($ruta)
{
    if (!file_exists($ruta)) {
        mkdir($ruta, 0777, true);
    }
}

// Procesar los archivos recibidos
foreach ($_FILES as $inputName => $file) {
    if ($file['error'] !== UPLOAD_ERR_OK) continue;

    $campo = str_replace("archivo_actualizado_", "", $inputName);
    $nombreArchivo = basename($file['name']);

    // --- PERSONA FÍSICA ---
    if (!empty($asignacion['id_persona_fisica'])) {
        $id = $asignacion['id_persona_fisica'];

        $folder = match ($campo) {
            'archivo_ine' => 'files_ines/',
            'archivo_curp' => 'files_CURP/',
            'archivo_rfc' => 'files_RFC/',
            'archivo_domicilio', 'archivo_domicilio_resguardo_unidad' => 'files_domicilio/',
            default => ''
        };

        $rutaDestino = $basePathFisica . $folder;
        asegurarCarpeta($rutaDestino);

        if (move_uploaded_file($file['tmp_name'], $rutaDestino . $nombreArchivo)) {
            $sqlUpdate = "UPDATE personas_fisicas SET $campo = '$nombreArchivo' WHERE id_persona_fisica = $id";
            $conexion->query($sqlUpdate);
        }

        // --- PERSONA MORAL ---
    } elseif (!empty($asignacion['id_persona_moral'])) {
        $id = $asignacion['id_persona_moral'];

        $folder = match ($campo) {
            'archivo_identificacion_representante_legal' => 'files_id/',
            'archivo_poder_representante_legal' => 'files_poder/',
            'archivo_rfc_moral' => 'files_RFC/',
            'archivo_domiclio_moral' => 'files_domicilio/',
            'archivo_domicilio_resguardo_unidad' => 'files_domicilioresguardounidad/',
            default => ''
        };

        if ($folder) {
            $rutaDestino = $basePathMoral . $folder;
            asegurarCarpeta($rutaDestino);

            if (move_uploaded_file($file['tmp_name'], $rutaDestino . $nombreArchivo)) {
                $sqlUpdate = "UPDATE personas_morales SET $campo = '$nombreArchivo' WHERE id_persona_moral = $id";
                $conexion->query($sqlUpdate);
            }
        } else {
            // Escritura constitutiva
            if (str_starts_with($campo, "escritura_constitutiva")) {
                $rutaDestino = $basePathMoral . 'files_escrituraconstitutiva/';
                asegurarCarpeta($rutaDestino);
                move_uploaded_file($file['tmp_name'], $rutaDestino . $nombreArchivo);

                $sqlInsert = "INSERT INTO archivos_escritura_constitutiva (id_persona_moral, nombre_archivo)
                              VALUES ($id, '$nombreArchivo')";
                $conexion->query($sqlInsert);

                // Estatus sociales
            } elseif (str_starts_with($campo, "estatus_sociales")) {
                $rutaDestino = $basePathMoral . 'files_estatusociales/';
                asegurarCarpeta($rutaDestino);
                move_uploaded_file($file['tmp_name'], $rutaDestino . $nombreArchivo);

                $sqlInsert = "INSERT INTO archivos_escritura_estatus_sociales (id_persona_moral, nombre_archivo_estatus_sociales)
                              VALUES ($id, '$nombreArchivo')";
                $conexion->query($sqlInsert);
            }
        }
    }

    // Registrar la actualización en observaciones
    $comentario = $conexion->real_escape_string("Archivo '$campo' actualizado por colaborador $id_colaborador");
    $fecha = date("Y-m-d H:i:s");

    // Si ya existe una observación de ese campo, la actualizamos; si no, la insertamos
    $sqlCheck = "SELECT id_observacion 
             FROM observaciones_documentos_juridico 
             WHERE id_asignacion_unidad_demo = $id_asignacion 
             AND campo_archivo = '$campo'
             LIMIT 1";
    $resCheck = $conexion->query($sqlCheck);

    if ($resCheck->num_rows > 0) {
        $row = $resCheck->fetch_assoc();
        $idObs = $row['id_observacion'];

        $sqlUpdateObs = "UPDATE observaciones_documentos_juridico
                     SET comentario = '$comentario', fecha = '$fecha', id_colaborador_juridico = $id_colaborador, visto_por_usuario = 0
                     WHERE id_observacion = $idObs";
        $conexion->query($sqlUpdateObs);
    } else {
        $sqlInsertObs = "INSERT INTO observaciones_documentos_juridico 
                     (id_asignacion_unidad_demo, campo_archivo, comentario, fecha, id_colaborador_juridico, visto_por_usuario)
                     VALUES ($id_asignacion, '$campo', '$comentario', '$fecha', $id_colaborador, 0)";
        $conexion->query($sqlInsertObs);
    }
}

echo "ok";
