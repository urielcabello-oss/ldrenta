<?php
include("../../../conexion.php");
if (!isset($_SESSION)) session_start();

$id_unidad = $_POST['id_unidad'];
$id_asignacion = $_POST['id_asignacion'];

// Obtener asignación
$sql = "SELECT id_persona_fisica, id_persona_moral FROM asignacion_unidad_demo WHERE id_asignacion_unidad_demo = $id_asignacion";
$res = $conexion->query($sql);
$asignacion = $res->fetch_assoc();

$html = '<form id="formComentarios">';

if ($asignacion['id_persona_fisica']) {
    $id = $asignacion['id_persona_fisica'];
    $sqlArchivos = "SELECT archivo_ine, archivo_curp, archivo_rfc, archivo_domicilio, archivo_domicilio_resguardo_unidad 
                    FROM personas_fisicas WHERE id_persona_fisica = $id";
    $result = $conexion->query($sqlArchivos);
    $row = $result->fetch_assoc();

    $html .= '<h5>Persona Física</h5><ul>';
    foreach ($row as $key => $archivo) {
        if ($archivo) {
            // Mapear carpetas correctas
            $ruta = match($key) {
                'archivo_ine' => '../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_ines/' . $archivo,
                'archivo_curp' => '../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_CURP/' . $archivo,
                'archivo_rfc' => '../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_RFC/' . $archivo,
                'archivo_domicilio' => '../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_domicilio/' . $archivo,
                'archivo_domicilio_resguardo_unidad' => '../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_domicilio/' . $archivo,
                default => '../../Servidor/archivos_colaboradores/' . $archivo
            };
            $html .= '<li><a href="' . $ruta . '" target="_blank">' . $key . '</a>
                      <textarea name="comentarios['.$key.']" class="form-control mb-2" placeholder="Agregar comentario"></textarea></li>';
        }
    }
    $html .= '</ul>';

} elseif ($asignacion['id_persona_moral']) {
    $id = $asignacion['id_persona_moral'];

    $sqlArchivos = "SELECT archivo_identificacion_representante_legal, archivo_poder_representante_legal, archivo_rfc_moral, archivo_domiclio_moral, archivo_domicilio_resguardo_unidad 
                    FROM personas_morales WHERE id_persona_moral = $id";
    $result = $conexion->query($sqlArchivos);
    $row = $result->fetch_assoc();

    $html .= '<h5>Persona Moral</h5><ul>';
    foreach ($row as $key => $archivo) {
        if ($archivo) {
            $ruta = match($key) {
                'archivo_identificacion_representante_legal' => '../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_id/' . $archivo,
                'archivo_poder_representante_legal' => '../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_poder/' . $archivo,
                'archivo_rfc_moral' => '../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_RFC/' . $archivo,
                'archivo_domiclio_moral' => '../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_domicilio/' . $archivo,
                'archivo_domicilio_resguardo_unidad' => '../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_domicilioresguardounidad/' . $archivo,
                default => '../../Servidor/archivos_colaboradores/' . $archivo
            };
            $html .= '<li><a href="' . $ruta . '" target="_blank">' . $key . '</a>
                      <textarea name="comentarios['.$key.']" class="form-control mb-2" placeholder="Agregar comentario"></textarea></li>';
        }
    }

    // Archivos adicionales de constitución
    $sqlExtras = "SELECT nombre_archivo FROM archivos_escritura_constitutiva WHERE id_persona_moral = $id";
    $resExtras = $conexion->query($sqlExtras);
    while ($extra = $resExtras->fetch_assoc()) {
        $archivo = $extra['nombre_archivo'];
        $ruta = '../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_escrituraconstitutiva/' . $archivo;
        $html .= '<li><a href="'.$ruta.'" target="_blank">Escritura Constitutiva</a>
                  <textarea name="comentarios[escritura_constitutiva][]" class="form-control mb-2" placeholder="Agregar comentario"></textarea></li>';
    }

    // Archivos adicionales de estatus sociales
    $sqlExtras2 = "SELECT nombre_archivo_estatus_sociales FROM archivos_escritura_estatus_sociales WHERE id_persona_moral = $id";
    $resExtras2 = $conexion->query($sqlExtras2);
    while ($extra2 = $resExtras2->fetch_assoc()) {
        $archivo = $extra2['nombre_archivo_estatus_sociales'];
        $ruta = '../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_estatusociales/' . $archivo;
        $html .= '<li><a href="'.$ruta.'" target="_blank">Estatus Sociales</a>
                  <textarea name="comentarios[estatus_sociales][]" class="form-control mb-2" placeholder="Agregar comentario"></textarea></li>';
    }

    $html .= '</ul>';
}

$html .= '<input type="hidden" name="id_asignacion" value="' . $id_asignacion . '">';
$html .= '</form>';

echo $html;
