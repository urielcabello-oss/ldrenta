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
    uda.autorizacion,
    pf.nombre_1,
    pf.nombre_2,
    pf.apellido_paterno,
    pf.apellido_materno,
    pm.organizacion_institucion,
    model.nombre_modelo,
    unid.placa,
    unid.vin,
    unid.vin,
    unid.paso_diferencial,
    uda.fecha_prestamo,
    uda.fecha_devolucion,
    uda.impacto_atencion,
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
WHERE uda.autorizacion = 'APROVADO'
ORDER BY uda.id_asignacion_unidad_demo DESC
";

$resultado = $conexion->query($sqlobtenerunidadesdemoautorizadas);

/* ======================================================
   1️⃣ TABLA (VISIBLE POR DEFECTO)
====================================================== */

echo '

<div id="vistaTabla">

    <div class="table-responsive">

        <table class="table align-middle ldr-table" id="tablaUnidades">

            <thead>
                <tr>
                    <th>Impacto</th>
                    <th>Prioridad</th>
                    <th>Solicitante</th>
                    <th>Modelo</th>
                    <th>Paso diferencial</th>
                    <th>VIN</th>
                    <th>Placa</th>
                    <th>Asignación</th>
                    <th>Devolución</th>
                    <th>Maps</th>
                    <th>Colaborador</th>
                    <th>Reporte</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
';

function obtenerSemaforo($impacto)
{

    switch ($impacto) {

        case 1:
            return '<span class="badge bg-success">Bajo</span>';

        case 2:
            return '<span class="badge bg-warning text-dark">Medio</span>';

        case 3:
            return '<span class="badge bg-danger">Alto</span>';

        default:
            return '<span class="badge bg-secondary">Sin definir</span>';
    }
}

while ($fila = $resultado->fetch_assoc()) {

    if (($fila['id_persona_fisica'] || $fila['id_persona_moral']) && $fila['autorizacion'] === 'APROVADO') {

        $tipo_solicitante = $fila['id_persona_fisica'] ? 'fisica' : 'moral';

        $nombreSolicitante = $fila['id_persona_fisica']
            ? $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno']
            : $fila['organizacion_institucion'];

        $avatar = empty($fila["avatar_colaborador"])
            ? "../../Cliente/img/default_avatar.png"
            : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"] . ".png";

        echo '
        <tr class="fila-solicitante tipo-' . $tipo_solicitante . '">
        <td style="min-width:140px;">
    <select class="form-select form-select-sm cambiar-impacto shadow-sm"
        data-id="' . $fila['id_asignacion_unidad_demo'] . '">

<option value="1" ' . ($fila['impacto_atencion'] == 1 ? 'selected' : '') . '>🟢 Bajo</option>
<option value="2" ' . ($fila['impacto_atencion'] == 2 ? 'selected' : '') . '>🟡 Medio</option>
<option value="3" ' . ($fila['impacto_atencion'] == 3 ? 'selected' : '') . '>🔴 Alto</option>

</select>
</td>
            <td class="col-impacto">' . obtenerSemaforo($fila['impacto_atencion']) . '</td>
            <td>' . $nombreSolicitante . '</td>
            <td>' . $fila['nombre_modelo'] . '</td>
            <td>' . $fila['paso_diferencial'] . '</td>
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
            <td>
                <button type="button" 
                    class="btn btn-primary btn-sm btnreportefinalunidademo"
                    data-id_asignacion_demo="' . $fila['id_asignacion_unidad_demo'] . '">
                    Reporte
                </button>
            </td>
            <td>';
        if ($fila['estado'] == 1) {
            echo '
    <button type="button"
        class="btn btn-outline-warning btn-sm btn-devolver-unidad"
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
   2️⃣ CARDS MODERNAS
====================================================== */

$resultado->data_seek(0);

echo '<div id="vistaCards" class="row g-4 mt-1" style="display:none;">';

while ($fila = $resultado->fetch_assoc()) {

    if (($fila['id_persona_fisica'] || $fila['id_persona_moral']) && $fila['autorizacion'] === 'APROVADO') {

        $tipo_solicitante = $fila['id_persona_fisica'] ? 'fisica' : 'moral';

        $nombreSolicitante = $fila['id_persona_fisica']
            ? $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno']
            : $fila['organizacion_institucion'];

        $avatar = empty($fila["avatar_colaborador"])
            ? "../../Cliente/img/default_avatar.png"
            : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"] . ".png";

        $imgUnidad = empty($fila['img_unidad'])
            ? "../../Cliente/img/unidades/silueta_tracto3.png"
            : "../../Servidor/archivos/imagenes/imagenes_unidades/" . $fila['img_unidad'];

        echo '

        <div class="col-12 col-md-6 col-xl-4 fila-solicitante tipo-' . $tipo_solicitante . '">

            <div class="ldr-renta-card h-100">

                <!-- imagen -->
                <div class="ldr-renta-img-container">

                    <img src="' . $imgUnidad . '"
                         class="ldr-renta-img"
                         onerror="this.src=\'../../Cliente/img/unidades/silueta_tracto3.png\'">

                    <div class="ldr-renta-badge-top">Demo</div>

                </div>

                <!-- contenido -->
                <div class="ldr-renta-body">

                    <!-- modelo -->
                    <div class="d-flex justify-content-between align-items-start mb-2">

                        <div>
                            <h4 class="ldr-renta-title">
                                ' . $fila['nombre_modelo'] . '
                            </h4>

                            <p class="ldr-renta-subtitle">
                                ' . $nombreSolicitante . '
                            </p>
                        </div>

                        <div>
                            ' . obtenerSemaforo($fila['impacto_atencion']) . '
                        </div>

                    </div>

                    <!-- datos -->
                    <div class="ldr-info-grid">

                        <div class="ldr-info-item">
                            <span>VIN</span>
                            <strong>' . $fila['vin'] . '</strong>
                        </div>

                        <div class="ldr-info-item">
                            <span>Placa</span>
                            <strong>' . $fila['placa'] . '</strong>
                        </div>

                        <div class="ldr-info-item">
                            <span>Paso dif.</span>
                            <strong>' . $fila['paso_diferencial'] . '</strong>
                        </div>

                        <div class="ldr-info-item">
                            <span>Asignación</span>
                            <strong>' . $fila['fecha_prestamo'] . '</strong>
                        </div>

                    </div>

                    <!-- colaborador -->
                    <div class="ldr-colaborador">

                        <img src="' . $avatar . '" class="ldr-avatar">

                        <div>
                            <small>Asignado por</small>

                            <div class="fw-semibold">
                                ' . $fila['nombre1colaborador'] . ' ' .
                                    $fila['apellidopcolaborador'] . '
                            </div>
                        </div>

                    </div>

                    <!-- acciones -->
                    <div class="ldr-actions">

                        <button type="button"
                            class="btn btn-primary btn-sm btnreportefinalunidademo"
                            data-id_asignacion_demo="' . $fila['id_asignacion_unidad_demo'] . '">

                            <i class="fas fa-chart-line me-1"></i>
                            Descripción

                        </button>

                        <button type="button"
                            class="btn btn-light btn-sm btnubicacionunidad"
                            data-vin="' . $fila['vin'] . '">

                            <i class="fa-solid fa-location-dot"></i>

                        </button>';

                        if ($fila['estado'] == 1) {

                            echo '

                            <button type="button"
                                class="btn btn-warning btn-sm btn-devolver-unidad"
                                data-id_asignacion="' . $fila['id_asignacion_unidad_demo'] . '"
                                data-id_unidad="' . $fila['id_unidad'] . '">

                                Devolver

                            </button>';
                        } else {

                            echo '
                            <span class="badge bg-success">
                                Disponible
                            </span>';
                        }

                        echo '

                    </div>

                </div>

            </div>

        </div>';
    }
}


echo '</div>';
