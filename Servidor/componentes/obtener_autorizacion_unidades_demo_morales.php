<?php 
include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}

// Consulta con DISTINCT para evitar duplicados
$sqlobtenerunidadpersonamoralautorizacion = "SELECT DISTINCT
    unid.img_unidad,
    aud.id_asignacion_unidad_demo,
    aud.id_unidad,
    aud.id_colaborador_que_asigna,
    aud.id_persona_moral,
    aud.autorizacion,
    pm.organizacion_institucion,
    model.nombre_modelo,
    unid.placa,
    aud.fecha_prestamo,
    aud.fecha_devolucion,

    -- Solicitante
    ca.nombre_1 AS nombre1colaborador,
    ca.nombre_2 AS nombre2colaborador,
    ca.apellido_paterno AS apellidopcolaborador,
    ca.apellido_materno AS apellidomcolaborador,
    usr.avatar AS avatar_colaborador,

    -- Jefe directo
    jdc.nombre_1 AS nombre1jefe,
    jdc.nombre_2 AS nombre2jefe,
    jdc.apellido_paterno AS apellidopjefe,
    jdc.apellido_materno AS apellidomjefe,
    usrc.avatar AS avatar_jefe_directo

FROM asignacion_unidad_demo AS aud
LEFT JOIN unidades AS unid 
    ON aud.id_unidad = unid.id_unidad
LEFT JOIN modelos AS model 
    ON unid.id_modelo = model.id_modelo 
LEFT JOIN personas_morales AS pm 
    ON aud.id_persona_moral = pm.id_persona_moral
INNER JOIN colaboradores AS ca
    ON aud.id_colaborador_que_asigna = ca.id_colaborador
INNER JOIN usuarios AS usr
    ON ca.id_colaborador = usr.id_colaborador
LEFT JOIN jefes_directos AS jd 
    ON aud.id_autorizacion_jefe_directo = jd.id_jefe_directo
LEFT JOIN colaboradores AS jdc 
    ON jd.id_colaborador = jdc.id_colaborador
LEFT JOIN usuarios AS usrc 
    ON usrc.id_colaborador = jdc.id_colaborador
ORDER BY aud.id_asignacion_unidad_demo DESC
";

$resultado = $conexion->query($sqlobtenerunidadpersonamoralautorizacion);

echo '<div id="vistaCards">';
while ($fila = $resultado->fetch_assoc()) {
    if ($fila['id_persona_moral'] && $fila['autorizacion'] != 'APROVADO') {
        $nombreJefe = trim($fila['nombre1jefe'] . ' ' . $fila['nombre2jefe'] . ' ' . $fila['apellidopjefe'] . ' ' . $fila['apellidomjefe']);
        $nombreJefe = !empty($nombreJefe) ? $nombreJefe : null;

        echo '<div class="card mb-3">';
        echo '<div class="cardheader">
            <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" onerror="this.src=\'../../Cliente/img/unidades/silueta_tracto3.png\'" class="card-img-top img-fluid imgcard" alt="...">
        </div>
        <div class="card-body">
            <h6 class="card-title txteatlevalidacioncomodato"><b>' . $fila['organizacion_institucion'] . '</b></h6>
            <h6 class="card-title txteatlevalidacioncomodato"><b>' . $fila['nombre_modelo'] . '</b></h6>
            <h6 class="card-text txtvalidacioncomodato"><b>Solicitante: </b><br>
                <img src="' . (empty($fila["avatar_colaborador"]) ? "../../Cliente/img/iconos/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"]) . '.png" class="rounded-circle me-2" style="margin-top:5px;width:30px;height:30px;object-fit:cover;" alt="avatar">
                ' . $fila['nombre1colaborador'] . ' ' . $fila['nombre2colaborador'] . ' ' . $fila['apellidopcolaborador'] . ' ' . $fila['apellidomcolaborador'] . '
            </h6>';

        echo '<h6 class="card-text txtvalidacioncomodato"><i class="fas fa-car me-2"></i><b>Placa: </b>' . $fila['placa'] . '</h6>';
        echo '<h6 class="card-text txtvalidacioncomodato"><i class="fas fa-calendar-check me-2"></i><b>Asignación: </b>' . $fila['fecha_prestamo'] . '</h6>';
        echo '<h6 class="card-text txtvalidacioncomodato"><i class="fas fa-undo-alt me-2"></i><b>Devolución: </b>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</h6>';

        if ($nombreJefe) {
            echo '<h6 class="card-text txtvalidacioncomodato"><b>Autorizó: </b><br>
                <img src="' . (empty($fila["avatar_jefe_directo"]) ? "../../Cliente/img/iconos/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_jefe_directo"]) . '.png" class="rounded-circle me-2" style="margin-top:5px;width:30px;height:30px;object-fit:cover;" alt="avatar"> ' . $nombreJefe . '</h6>';
        }

        echo '<button type="button" id="btnmosrarmodalunidadmoral" data-idunidad="' . $fila['id_unidad'] . '" data-id_asignacion_demo="' . $fila['id_asignacion_unidad_demo'] . '" data-id_persona_moral="' . $fila['id_persona_moral'] . '" class="btn btn-sm mt-3 btn-verunidad_autorizar_morales btnmosrarmodalunidadmoral">Verificar</button>
        </div></div>';
    }
}
echo '</div>';

// ---------- VISTA TABLA ----------
$resultado->data_seek(0);

echo '<div id="vistaTabla" style="display:none;">
<div class="table-responsive">
<table class="table table-hover tablaunidades" id="tablaUnidades">
    <thead class="table-light">
        <tr>
            <th>Nombre de la empresa o institución</th>
            <th>Modelo</th>
            <th>Placa</th>
            <th>Asignación</th>
            <th>Devolución</th>
            <th>Solicitante</th>
            <th>Jefe Directo</th>
            <th>Ver</th>
        </tr>
    </thead>
    <tbody>';

while ($fila = $resultado->fetch_assoc()) {
    if ($fila['id_persona_moral'] && $fila['autorizacion'] != 'APROVADO') {
        $nombre = $fila['organizacion_institucion'];
        $nombreJefe = trim($fila['nombre1jefe'] . ' ' . $fila['nombre2jefe'] . ' ' . $fila['apellidopjefe'] . ' ' . $fila['apellidomjefe']);
        $nombreJefe = !empty($nombreJefe) ? $nombreJefe : null;

        echo '<tr>
            <td>' . $nombre . '</td>
            <td>' . $fila['nombre_modelo'] . '</td>
            <td>' . $fila['placa'] . '</td>
            <td>' . $fila['fecha_prestamo'] . '</td>
            <td>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</td>
            <td style="text-align:center;">
                <img src="' . (empty($fila["avatar_colaborador"]) ? "../../Cliente/img/iconos/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"]) . '.png" class="rounded-circle me-2" style="margin-top:5px;width:30px;height:30px;object-fit:cover;" alt="avatar">
                ' . $fila['nombre1colaborador'] . ' ' . $fila['nombre2colaborador'] . ' ' . $fila['apellidopcolaborador'] . ' ' . $fila['apellidomcolaborador'] . '
            </td>
            <td style="text-align:center;">' . 
                ($nombreJefe
                    ? '<img src="' . (empty($fila["avatar_jefe_directo"]) ? "../../Cliente/img/iconos/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_jefe_directo"]) . '.png" class="rounded-circle me-2" style="margin-top:5px;width:30px;height:30px;object-fit:cover;" alt="avatar"> ' . $nombreJefe
                    : '---') . 
            '</td>
            <td><button type="button" class="btn btn-sm btn-verunidad_autorizar_morales btnmosrarmodalunidadmoral" data-idunidad="' . $fila['id_unidad'] . '" data-id_asignacion_demo="' . $fila['id_asignacion_unidad_demo'] . '" data-id_persona_moral="' . $fila['id_persona_moral'] . '">Verificar</button></td>
        </tr>';
    }
}

echo '</tbody>
</table>
</div>
</div>';
?>
