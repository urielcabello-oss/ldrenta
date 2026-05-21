<?php
include("../../Servidor/conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

/* =========================================================
   NOTIFICACIONES
========================================================= */

$actualizaciones = [];

$sqlNotif = "SELECT DISTINCT id_asignacion_unidad_demo
             FROM observaciones_documentos_juridico
             WHERE visto_por_usuario = 0";

$resNotif = $conexion->query($sqlNotif);

if ($resNotif && $resNotif->num_rows > 0) {

    while ($row = $resNotif->fetch_assoc()) {

        $actualizaciones[] = $row['id_asignacion_unidad_demo'];
    }
}

/* =========================================================
   CONSULTA PRINCIPAL
========================================================= */

$sql = "SELECT
            uda.id_asignacion_unidad_demo,
            uda.id_unidad,
            uda.id_colaborador_que_asigna,
            uda.id_persona_fisica,
            uda.id_persona_moral,
            uda.fecha_prestamo,
            uda.fecha_devolucion,
            uda.id_estatus_comodato_demo,
            uda.archivo_comodato_firmado,

            unid.img_unidad,
            unid.placa,
            unid.vin,

            model.nombre_modelo,

            estatuscomodato.estatus_comodato,

            pf.nombre_1,
            pf.nombre_2,
            pf.apellido_paterno,
            pf.apellido_materno,

            pm.organizacion_institucion,

            col.nombre_1 AS nombre_colaborador_1,
            col.nombre_2 AS nombre_colaborador_2,
            col.apellido_paterno AS apellido_colaborador_p,
            col.apellido_materno AS apellido_colaborador_m,

            usr.avatar AS avatar_colaborador

        FROM asignacion_unidad_demo AS uda

        LEFT JOIN unidades AS unid
            ON uda.id_unidad = unid.id_unidad

        LEFT JOIN modelos AS model
            ON unid.id_modelo = model.id_modelo

        LEFT JOIN estatus_comodato AS estatuscomodato
            ON uda.id_estatus_comodato_demo = estatuscomodato.id_estatus_comodato

        LEFT JOIN personas_fisicas AS pf
            ON uda.id_persona_fisica = pf.id_persona_fisica

        LEFT JOIN personas_morales AS pm
            ON uda.id_persona_moral = pm.id_persona_moral

        LEFT JOIN colaboradores AS col
            ON uda.id_colaborador_que_asigna = col.id_colaborador

        LEFT JOIN usuarios AS usr
            ON usr.id_colaborador = col.id_colaborador

        WHERE uda.estado = 1

        ORDER BY uda.id_asignacion_unidad_demo DESC";

$resultado = $conexion->query($sql);

if (!$resultado) {

    die("Error en la consulta: " . $conexion->error);
}

/* =========================================================
   CONTENEDOR
========================================================= */

echo '
<div class="container-fluid">

    <div class="row g-4">
';

/* =========================================================
   RECORRER CARDS
========================================================= */

while ($fila = $resultado->fetch_assoc()) {

    $idAsignacion = $fila['id_asignacion_unidad_demo'];

    $tieneActualizacion = in_array($idAsignacion, $actualizaciones);

    /* =========================================================
       SOLICITANTE
    ========================================================= */

    $nombreSolicitante = '';

    if (!empty($fila['id_persona_fisica'])) {

        $nombreSolicitante = trim(
            $fila['nombre_1'] . ' ' .
            $fila['nombre_2'] . ' ' .
            $fila['apellido_paterno'] . ' ' .
            $fila['apellido_materno']
        );

        $badgeTipo = '
            <span class="badge bg-primary">
                Persona Física
            </span>
        ';

    } else {

        $nombreSolicitante = $fila['organizacion_institucion'];

        $badgeTipo = '
            <span class="badge bg-dark">
                Persona Moral
            </span>
        ';
    }

    /* =========================================================
       COLABORADOR
    ========================================================= */

    $nombreColaborador = trim(
        $fila['nombre_colaborador_1'] . ' ' .
        $fila['nombre_colaborador_2'] . ' ' .
        $fila['apellido_colaborador_p'] . ' ' .
        $fila['apellido_colaborador_m']
    );

    $avatar = !empty($fila['avatar_colaborador'])
        ? "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila['avatar_colaborador'] . ".png"
        : "../../Cliente/img/iconos/default_avatar.png";

    /* =========================================================
       ESTATUS
    ========================================================= */

    $estatusBadge = '';

    switch ($fila['id_estatus_comodato_demo']) {

        case 3:

            $estatusBadge = '
                <span class="badge bg-success">
                    COMODATO SUBIDO
                </span>
            ';
        break;

        case 7:

            $estatusBadge = '
                <span class="badge bg-warning text-dark">
                    COMODATO REGRESADO
                </span>
            ';
        break;

        default:

            $estatusBadge = '
                <span class="badge bg-secondary">
                    ' . $fila['estatus_comodato'] . '
                </span>
            ';
        break;
    }

    /* =========================================================
       CARD
    ========================================================= */

    echo '

<div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">

    <div class="card border-0 shadow rounded-4 overflow-hidden carddemo h-100" style="border:1px solid #f1f1f1;">

        <!-- IMAGE -->
        <div class="position-relative">

            <img 
                src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '"

                onerror="this.src=\'../../Cliente/img/unidades/silueta_tracto3.png\'"

                class="w-100"

                style="
                    height:110px;
                    object-fit:contain;
                    background:#f8f9fa;
                    padding:6px;
                "
            >

            <!-- BADGE TIPO -->
            <div class="position-absolute top-0 start-0 p-2">
                ' . $badgeTipo . '
            </div>

            <!-- BADGE NUEVO -->
    ';

    if ($tieneActualizacion) {

        echo '

            <div class="position-absolute top-0 end-0 p-2">

                <span class="badge bg-danger">
                    ¡Nuevo!
                </span>

            </div>
        ';
    }

    echo '

        </div>

        <!-- BODY -->
        <div class="card-body p-2 d-flex flex-column">

            <!-- TITULO -->
            <h6 class="fw-semibold text-dark mb-0 text-truncate small">
                ' . $fila['nombre_modelo'] . '
            </h6>

            <!-- SOLICITANTE -->
            <small class="text-muted text-truncate d-block mb-1" style="font-size:11px;">
                ' . $nombreSolicitante . '
            </small>

            <!-- ESTATUS -->
            <div class="mb-3">
                ' . $estatusBadge . '
            </div>

            <!-- INFO -->
            <div class="mb-3 small">

                <div class="d-flex justify-content-between mb-1">

                    <span class="text-muted">
                        Placa
                    </span>

                    <strong>
                        ' . $fila['placa'] . '
                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-1">

                    <span class="text-muted">
                        VIN
                    </span>

                    <strong class="text-truncate ms-2">
                        ' . $fila['vin'] . '
                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-1">

                    <span class="text-muted">
                        Asignación
                    </span>

                    <strong>
                        ' . $fila['fecha_prestamo'] . '
                    </strong>

                </div>

                <div class="d-flex justify-content-between">

                    <span class="text-muted">
                        Devolución
                    </span>

                    <strong>
    ';

    echo ($fila['fecha_devolucion'] != '0000-00-00')
        ? $fila['fecha_devolucion']
        : 'Sin fecha';

    echo '

                    </strong>

                </div>

            </div>

            <!-- COLABORADOR -->
            <div class="d-flex align-items-center gap-2 mb-2">

                <img 
                    src="' . $avatar . '"

                    style="
                        width:38px;
                        height:38px;
                        object-fit:cover;
                        border-radius:50%;
                    "
                >

                <div class="flex-grow-1 overflow-hidden">

                    <small class="text-muted d-block">
                        Solicitante
                    </small>

                    <strong class="small text-truncate d-block">
                        ' . $nombreColaborador . '
                    </strong>

                </div>

            </div>

            <!-- BOTONES -->
            <div class="mt-auto">

                <div class="d-flex gap-2">

                    <!-- SUBIR -->
                    <button 
                        type="button"

                        class="btn btn-primary btn-sm py-1 flex-fill btnmosrarmodalunidadcomodatodemo"

                        data-idunidad="' . $fila['id_unidad'] . '"
                        data-idasignacion="' . $fila['id_asignacion_unidad_demo'] . '"
                        data-idcolaborador="' . $fila['id_colaborador_que_asigna'] . '"

                        title="Subir COMODATO"
                    >

                        <i class="fa-solid fa-upload"></i>

                    </button>

                    <!-- ARCHIVOS -->
                    <button 
                        type="button"

                        class="btn btn-dark btn-sm flex-fill btnverarchivos"

                        data-idunidad="' . $fila['id_unidad'] . '"
                        data-idasignacion="' . $fila['id_asignacion_unidad_demo'] . '"
                        data-idcolaborador="' . $fila['id_colaborador_que_asigna'] . '"

                        title="Ver archivos"
                    >

                        <i class="fa-solid fa-folder-open"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>
';
}

/* =========================================================
   CIERRE
========================================================= */

echo '
    </div>
</div>
';
?>