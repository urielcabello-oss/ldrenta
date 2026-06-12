<?php
include("../../Servidor/conexion.php");

if (!isset($_SESSION)) {
    session_start();
}


// =====================================================
// CONSULTA
// =====================================================

$sql = "
SELECT 
    uda.id_asignacion_unidad_demo,
    uda.id_unidad,
    uda.id_persona_fisica,
    uda.id_persona_moral,
    uda.fecha_prestamo,
    uda.fecha_devolucion,
    uda.id_estatus_comodato_demo,

    unid.img_unidad,
    unid.placa,
    unid.vin,
    unid.paso_diferencial,

    model.nombre_modelo,

    pf.nombre_1,
    pf.nombre_2,
    pf.apellido_paterno,
    pf.apellido_materno,

    pm.organizacion_institucion,

    pru.id_prorroga_unidad_demo

FROM asignacion_unidad_demo AS uda

LEFT JOIN unidades AS unid
ON uda.id_unidad = unid.id_unidad

LEFT JOIN modelos AS model
ON unid.id_modelo = model.id_modelo

LEFT JOIN personas_fisicas AS pf
ON uda.id_persona_fisica = pf.id_persona_fisica

LEFT JOIN personas_morales AS pm
ON uda.id_persona_moral = pm.id_persona_moral

LEFT JOIN prorrogas_unidades_demo AS pru
ON pru.id_asignacion_unidad_demo = uda.id_asignacion_unidad_demo

ORDER BY uda.id_asignacion_unidad_demo DESC
";

$resultado = $conexion->query($sql);

if (!$resultado) {

    die("Error en consulta: " . $conexion->error);
}

// =====================================================
// CONTENEDOR
// =====================================================

echo '
<div class="container-fluid">

    <div class="row g-4">
';

// =====================================================
// CARDS
// =====================================================

while ($fila = $resultado->fetch_assoc()) {

    $id_asignacion_demo = $fila['id_asignacion_unidad_demo'];

    // =====================================================
    // NOMBRE SOLICITANTE
    // =====================================================

    $nombreSolicitante = '';

    if (!empty($fila['id_persona_fisica'])) {

        $nombreSolicitante =
            trim(
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

        $nombreSolicitante =
            $fila['organizacion_institucion'];

        $badgeTipo = '
            <span class="badge bg-dark">
                Persona Moral
            </span>
        ';
    }

    // =====================================================
    // OBSERVACIONES
    // =====================================================

    $sqlObs = "
        SELECT COUNT(*) AS total
        FROM observaciones_documentos_juridico
        WHERE id_asignacion_unidad_demo = '$id_asignacion_demo'
        AND comentario IS NOT NULL
        AND comentario != ''
    ";

    $resObs = $conexion->query($sqlObs);

    $obs = $resObs->fetch_assoc();

    $tieneObservaciones = $obs['total'] > 0;

    // =====================================================
    // STATUS COMODATO
    // =====================================================

    $estatusComodato = '';

    switch ($fila['id_estatus_comodato_demo']) {

        case 1:

            $estatusComodato = '
                <span class="badge bg-warning text-dark">
                    Pendiente Jurídico
                </span>
            ';
        break;

        case 2:

            $estatusComodato = '
                <span class="badge bg-info text-dark">
                    En revisión
                </span>
            ';
        break;

        case 3:

            $estatusComodato = '
                <span class="badge bg-success">
                    Comodato disponible
                </span>
            ';
        break;

        default:

            $estatusComodato = '
                <span class="badge bg-secondary">
                    Sin estatus
                </span>
            ';
        break;
    }

    // =====================================================
    // CARD
    // =====================================================

    echo '
<div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden carddemo h-100">

        <!-- IMAGE -->
        <div class="position-relative">

            <img 
                src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '"
                onerror="this.src=\'../../Cliente/img/unidades/silueta_tracto3.png\'"
                class="w-100"
                style="
                    height:120px;
                    object-fit:contain;
                    background:#f8f9fa;
                    padding:8px;
                "
            >

            <div class="position-absolute top-0 start-0 p-2">
                ' . $badgeTipo . '
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body p-2 d-flex flex-column">

            <h6 class="fw-bold text-dark mb-1 text-truncate">
                ' . $fila['nombre_modelo'] . '
            </h6>

            <small class="text-muted text-truncate d-block mb-2">
                ' . $nombreSolicitante . '
            </small>

            <!-- INFO -->
            <div class="mb-2 small">

                <div class="d-flex justify-content-between">
                    <span class="text-muted">
                        Placa
                    </span>

                    <strong>
                        ' . $fila['placa'] . '
                    </strong>
                </div>

                <div class="d-flex justify-content-between">
                    <span class="text-muted">
                        VIN
                    </span>

                    <strong class="text-truncate ms-2">
                        ' . $fila['vin'] . '
                    </strong>
                </div>

            </div>

            <!-- STATUS -->
            <div class="mb-2">
                ' . $estatusComodato . '
            </div>

            <!-- BOTONES -->
            <div class="mt-auto">

                <div class="d-flex justify-content-between gap-1">

';

if ($fila['id_estatus_comodato_demo'] == 3) {

    echo '
        <button 
            type="button"
            class="btn btn-success btn-sm flex-fill btnacciondemo btncomodatodemo"
            data-id_asignacion_demo="' . $id_asignacion_demo . '"
            title="Descargar comodato"
        >
            <i class="fa-solid fa-file-contract"></i>
        </button>
    ';
}

if ($tieneObservaciones) {

    echo '
        <button 
            type="button"
            class="btn btn-warning btn-sm flex-fill btnacciondemo btnVerObservaciones"
            data-id-asignacion-demo="' . $id_asignacion_demo . '"
            title="Observaciones"
        >
            <i class="fa-solid fa-comment"></i>
        </button>
    ';
}

echo '


                </div>

            </div>

        </div>

    </div>

</div>
';
}

// =====================================================
// CIERRE
// =====================================================

echo '
    </div>
</div>
';
?>