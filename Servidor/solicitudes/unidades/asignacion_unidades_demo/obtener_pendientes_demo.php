<?php

include("../../../conexion.php");

$sql = "SELECT 
        uda.id_asignacion_unidad_demo,
        uda.autorizacion,
        uda.fecha_prestamo,
        uda.fecha_devolucion,

        unid.placa,
        model.nombre_modelo,

        pf.nombre_1,
        pf.apellido_paterno,

        pm.organizacion_institucion,

        ca.nombre_1 AS solicitante_nombre,
        ca.apellido_paterno AS solicitante_apellido,

        p.nombre_puesto AS puesto_solicitante,

        ar.nombre_area AS area_solicitante,

        jdc.nombre_1 AS jefe_nombre,
        jdc.apellido_paterno AS jefe_apellido,

        aud.nombre_1 AS admin_nombre,
        aud.apellido_paterno AS admin_apellido

FROM asignacion_unidad_demo AS uda

LEFT JOIN unidades AS unid 
ON uda.id_unidad = unid.id_unidad

LEFT JOIN modelos AS model 
ON unid.id_modelo = model.id_modelo

LEFT JOIN personas_fisicas AS pf 
ON uda.id_persona_fisica = pf.id_persona_fisica

LEFT JOIN personas_morales AS pm 
ON uda.id_persona_moral = pm.id_persona_moral

INNER JOIN colaboradores AS ca 
ON uda.id_colaborador_que_asigna = ca.id_colaborador

LEFT JOIN puestos AS p
ON ca.id_puesto = p.id_puesto

LEFT JOIN areas AS ar
ON p.id_area = ar.id_area

LEFT JOIN jefes_directos AS jd 
ON uda.id_autorizacion_jefe_directo = jd.id_jefe_directo

LEFT JOIN colaboradores AS jdc 
ON jd.id_colaborador = jdc.id_colaborador

LEFT JOIN colaboradores AS aud 
ON uda.id_autorizador = aud.id_colaborador

WHERE uda.autorizacion != 'APROVADO'

ORDER BY uda.id_asignacion_unidad_demo DESC";

$result = $conexion->query($sql);

echo '<div class="lista-pendientes-demo">';

while ($row = $result->fetch_assoc()) {

    $persona = $row['organizacion_institucion']
        ? $row['organizacion_institucion']
        : $row['nombre_1'] . " " . $row['apellido_paterno'];



    /* ESTATUS */

    if ($row['autorizacion'] == "PENDIENTE") {

        $jefe = '<span class="badge-pendiente">⏳ Jefe directo</span>';
        $admin = '<span class="badge bg-secondary">Autorizador</span>';
    } elseif ($row['autorizacion'] == "AUTORIZADO JEFE DIRECTO") {

        $jefe = '<span class="badge-aprobado">
✔ '.$row['jefe_nombre'].' '.$row['jefe_apellido'].'
</span>';

        $admin = '<span class="badge bg-warning">⏳ Autorizador</span>';
    } else {

        $jefe = '<span class="badge bg-success">
✔ ' . $row['jefe_nombre'] . ' ' . $row['jefe_apellido'] . '
</span>';

        $admin = '<span class="badge-admin">Autorizador</span>';
    }



    echo '

<div class="pendiente-demo-item">

    <div class="pendiente-header">
        <span class="pendiente-unidad">
            🚛 '.$row['nombre_modelo'].'
        </span>
    </div>

    <div class="pendiente-info">

        <div>
            <b>Solicitante:</b> 
            '.$row['solicitante_nombre'].' '.$row['solicitante_apellido'].' | '.$row['puesto_solicitante'].' | '.$row['area_solicitante'].'
        </div>

        <div>
            <b>Asignado a:</b> 
            '.$persona.'
        </div>

        <div>
            <b>Periodo:</b> 
            '.$row['fecha_prestamo'].' → '.$row['fecha_devolucion'].'
        </div>

    </div>

    <div class="pendiente-flujo">

        '.$jefe.'

        <i class="fa-solid fa-arrow-right flecha-aprobacion"></i>

        '.$admin.'

    </div>

</div>

';
}

echo '</div>';
