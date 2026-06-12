<?php
include("../../Servidor/conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

/* ===========================
   CONSULTA
=========================== */

$sqlobtenerunidadesdemoautorizadas = "
SELECT 
    unid.img_unidad,
    uda.id_asignacion_unidad_demo,
    uda.id_unidad,
    uda.id_colaborador_que_asigna,
    uda.id_persona_fisica,
    uda.id_persona_moral,
    pf.nombre_1,
    pf.nombre_2,
    pf.apellido_paterno,
    pf.apellido_materno,
    pm.organizacion_institucion,
    model.nombre_modelo,
    unid.placa,
    unid.vin,
    unid.vin,
    unid.numero_motor,
    uda.fecha_prestamo,
    uda.fecha_devolucion,
    uda.estado,
    ca.nombre_1 AS nombre1colaborador,
    ca.nombre_2 AS nombre2colaborador,
    ca.apellido_paterno AS apellidopcolaborador,
    ca.apellido_materno AS apellidomcolaborador,
    usr.avatar AS avatar_colaborador
FROM asignacion_unidad_demo AS uda
LEFT JOIN unidades AS unid ON uda.id_unidad = unid.id_unidad
LEFT JOIN modelos AS model ON unid.id_modelo = model.id_modelo
LEFT JOIN personas_fisicas AS pf ON uda.id_persona_fisica = pf.id_persona_fisica
LEFT JOIN personas_morales AS pm ON uda.id_persona_moral = pm.id_persona_moral
INNER JOIN colaboradores AS ca ON uda.id_colaborador_que_asigna = ca.id_colaborador
INNER JOIN usuarios AS usr ON usr.id_colaborador = ca.id_colaborador
ORDER BY uda.id_asignacion_unidad_demo DESC
";

$resultado = $conexion->query($sqlobtenerunidadesdemoautorizadas);

/* ======================================================
   1️⃣ TABLA (VISIBLE POR DEFECTO)
====================================================== */

echo '<div id="vistaTabla">
<div class="table-responsive">
<table class="table align-middle ldr-table" id="tablaUnidades">
<thead class="table-light">
<tr>
    <th>Nombre</th>
    <th>Modelo</th>
    <th>Número motor</th>
    <th>VIN</th>
    <th>Placa</th>
    <th>Asignación</th>
    <th>Devolución</th>
    <th>Ubicación</th>
    <th>Colaborador</th>
    <th>Estado</th>
</tr>
</thead>
<tbody>';

while ($fila = $resultado->fetch_assoc()) {

    if (($fila['id_persona_fisica'] || $fila['id_persona_moral'])) {

        $tipo_solicitante = $fila['id_persona_fisica'] ? 'fisica' : 'moral';

        $nombreSolicitante = $fila['id_persona_fisica']
            ? $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno']
            : $fila['organizacion_institucion'];

        $avatar = empty($fila["avatar_colaborador"])
            ? "../../Cliente/img/default_avatar.png"
            : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"] . ".png";

        echo '
        <tr class="fila-solicitante tipo-' . $tipo_solicitante . '">
            <td>' . $nombreSolicitante . '</td>
            <td>' . $fila['nombre_modelo'] . '</td>
            <td>' . $fila['numero_motor'] . '</td>
            <td>' . $fila['vin'] . '</td>
            <td>' . $fila['placa'] . '</td>
            <td>' . $fila['fecha_prestamo'] . '</td>
            <td>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-mapa btnubicacionunidad" data-vin="' . $fila['vin'] . '">
                    <i class="fa-solid fa-location-dot"></i>
                </button>
            </td>
            <td>
                <img src="' . $avatar . '" 
                class="rounded-circle me-2" 
                style="width:30px;height:30px;object-fit:cover;">
                ' . $fila['nombre1colaborador'] . ' ' .
            $fila['nombre2colaborador'] . ' ' .
            $fila['apellidopcolaborador'] . ' ' .
            $fila['apellidomcolaborador'] . '
            </td>
            <td>';
        if ($fila['estado'] == 1) {
            echo '
    <button type="button"
        class="btn btn-warning btn-sm btn-devolver-unidad mt-1"
        data-id_asignacion="' . $fila['id_asignacion_unidad_demo'] . '"
        data-id_unidad="' . $fila['id_unidad'] . '">
        Devolver
    </button>';
        } else {
            echo '<span class="badge bg-success mt-1">Disponible</span>';
        }
        echo '
        </td>
        </tr>';
    }
}

echo '</tbody></table></div></div>';


/* ======================================================
   2️⃣ CARDS (OCULTAS)
====================================================== */

$resultado->data_seek(0);

echo '<div id="vistaCards" class="vista-cards-grid mt-4" style="display:none;">';

while ($fila = $resultado->fetch_assoc()) {

    if (($fila['id_persona_fisica'] || $fila['id_persona_moral'])) {

        $tipo_solicitante = $fila['id_persona_fisica'] ? 'fisica' : 'moral';

        $nombreSolicitante = $fila['id_persona_fisica']
            ? $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno']
            : $fila['organizacion_institucion'];

        $avatar = empty($fila["avatar_colaborador"])
            ? "../../Cliente/img/default_avatar.png"
            : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"] . ".png";

        echo '
            <div class="card card-solicitante tipo-' . $tipo_solicitante . '">
                <div class="cardheader">
                    <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" 
                    onerror="this.src=\'../../Cliente/img/unidades/silueta_tracto3.png\'"
                    class="card-img-top img-fluid imgcard">
                </div>

                <div class="card-body">
                    <h6><b>' . $nombreSolicitante . '</b></h6>
                    <h6><b>' . $fila['nombre_modelo'] . '</b></h6>

                    <h6>
                        <img src="' . $avatar . '" 
                        class="rounded-circle me-2" 
                        style="width:30px;height:30px;object-fit:cover;">
                        ' . $fila['nombre1colaborador'] . ' ' .
            $fila['nombre2colaborador'] . ' ' .
            $fila['apellidopcolaborador'] . ' ' .
            $fila['apellidomcolaborador'] . '
                    </h6>

                    <h6><b>VIN:</b> ' . $fila['vin'] . '</h6>
                    <h6><b>Paso dif.</b> ' . $fila['paso_diferencial'] . '</h6>
                    <h6><b>Placa:</b> ' . $fila['placa'] . '</h6>
                    <h6><b>Asignación:</b> ' . $fila['fecha_prestamo'] . '</h6>
                    <h6><b>Devolución:</b> ' .
            ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') .
            '</h6>

                    <button type="button"
                        class="btn btn-sm btn-mapa btnubicacionunidad"
                        data-vin="' . $fila['vin'] . '">
                        <i class="fa-solid fa-location-dot"></i>
                    </button>';
        if ($fila['estado'] == 1) {
            echo '
    <button type="button"
        class="btn btn-warning btn-sm btn-devolver-unidad mt-1"
        data-id_asignacion="' . $fila['id_asignacion_unidad_demo'] . '"
        data-id_unidad="' . $fila['id_unidad'] . '">
        Devolver
    </button>';
        } else {
            echo '<span class="badge bg-success mt-1">Disponible</span>';
        }

        echo '
                </div>
            </div>';
    }
}

echo '</div>';
