<?php
include("../../conexion.php");
if (!isset($_SESSION)) session_start();

$id_asignacion = $_GET['id_asignacion_demo'] ?? null;
if (!$id_asignacion) {
    echo "<p class='text-danger'>Faltan datos de asignación.</p>";
    exit;
}

// Traer observaciones junto con el archivo
$sql = "SELECT campo_archivo, comentario, fecha 
        FROM observaciones_documentos_juridico 
        WHERE id_asignacion_unidad_demo = $id_asignacion
        ORDER BY fecha DESC";

$res = $conexion->query($sql);
if ($res->num_rows === 0) {
    echo "<p>No hay observaciones aún.</p>";
    exit;
}

// Traer información de la asignación para saber si es persona física o moral
$sqlAsign = "SELECT id_persona_fisica, id_persona_moral 
             FROM asignacion_unidad_demo 
             WHERE id_asignacion_unidad_demo = $id_asignacion";
$resAsign = $conexion->query($sqlAsign);
$asign = $resAsign->fetch_assoc();
$tipo = $asign['id_persona_fisica'] ? 'fisica' : 'moral';

echo "<ul class='list-group'>";

while ($row = $res->fetch_assoc()) {
    $campo = $row['campo_archivo'];

    // Determinar ruta según tipo de persona y campo
    $ruta = '';
    if ($tipo === 'fisica') {
        $base = '../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/';
        $rutasCampos = [
            'archivo_ine' => 'files_ines/',
            'archivo_curp' => 'files_CURP/',
            'archivo_rfc' => 'files_RFC/',
            'archivo_domicilio' => 'files_domicilio/',
            'archivo_domicilio_resguardo_unidad' => 'files_domicilio/'
        ];
    } else {
        $base = '../../Servidor/archivos/files/files_asignacion_demo/personas_morales/';
        $rutasCampos = [
            'archivo_identificacion_representante_legal' => 'files_id/',
            'archivo_poder_representante_legal' => 'files_poder/',
            'archivo_rfc_moral' => 'files_RFC/',
            'archivo_domiclio_moral' => 'files_domicilio/',
            'archivo_domicilio_resguardo_unidad' => 'files_domicilioresguardounidad/',
            'escritura_constitutiva' => 'files_escrituraconstitutiva/',
            'estatus_sociales' => 'files_estatusociales/'
        ];
    }

    if (isset($rutasCampos[$campo])) {
        $ruta .= $base . $rutasCampos[$campo];
    } else {
        $ruta .= $base; // fallback
    }

    // Traer nombre real del archivo desde la tabla correspondiente
    $archivoReal = '';
    if ($tipo === 'fisica') {
        $sqlArchivo = "SELECT $campo FROM personas_fisicas 
                       WHERE id_persona_fisica = ".$asign['id_persona_fisica'];
        $resArchivo = $conexion->query($sqlArchivo);
        $archivoReal = $resArchivo->fetch_assoc()[$campo] ?? '';
    } else {
        if ($campo == 'escritura_constitutiva') {
            $sqlArchivo = "SELECT nombre_archivo FROM archivos_escritura_constitutiva
                           WHERE id_persona_moral = ".$asign['id_persona_moral']." LIMIT 1";
            $resArchivo = $conexion->query($sqlArchivo);
            $archivoReal = $resArchivo->fetch_assoc()['nombre_archivo'] ?? '';
        } elseif ($campo == 'estatus_sociales') {
            $sqlArchivo = "SELECT nombre_archivo_estatus_sociales FROM archivos_escritura_estatus_sociales
                           WHERE id_persona_moral = ".$asign['id_persona_moral']." LIMIT 1";
            $resArchivo = $conexion->query($sqlArchivo);
            $archivoReal = $resArchivo->fetch_assoc()['nombre_archivo_estatus_sociales'] ?? '';
        } else {
            $sqlArchivo = "SELECT $campo FROM personas_morales 
                           WHERE id_persona_moral = ".$asign['id_persona_moral'];
            $resArchivo = $conexion->query($sqlArchivo);
            $archivoReal = $resArchivo->fetch_assoc()[$campo] ?? '';
        }
    }

    echo "<li class='list-group-item'>
            <div class='mb-2'>
                <strong>Archivo: </strong>{$campo}
                <br>
                <a href='{$ruta}{$archivoReal}' target='_blank'>Ver archivo</a>
            </div>
            <div class='mb-2'>
                <strong>Comentario: </strong>
                <textarea class='form-control archivo-observado' data-campo='{$campo}' readonly>{$row['comentario']}</textarea>
            </div>
            <small class='text-muted'>".date("d/m/Y H:i", strtotime($row['fecha']))."</small>
          </li>";
}

echo "</ul>";
?>
