<?php
include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}

// 🔔 IDs de asignaciones con archivos actualizados por solicitante no vistos por jurídico
$actualizaciones = [];
$sqlNotif = "SELECT DISTINCT id_asignacion_unidad_demo 
             FROM observaciones_documentos_juridico 
             WHERE visto_por_usuario = 0
             AND comentario LIKE '%actualizado%'";
$resNotif = $conexion->query($sqlNotif);
while ($row = $resNotif->fetch_assoc()) {
    $actualizaciones[] = $row['id_asignacion_unidad_demo'];
}

// Consulta principal de unidades
$sqlobtenerunidadsubircomodato = "SELECT unid.img_unidad,
                uda.id_asignacion_unidad_demo,
                uda.id_unidad,
                uda.id_colaborador_que_asigna,
                uda.id_autorizador,
                uda.id_persona_fisica,
                uda.autorizacion,
                uda.id_estatus_comodato_demo,
                pf.id_persona_fisica,
                pf.nombre_1,
                pf.nombre_2,
                pf.apellido_paterno,
                pf.apellido_materno,
                pm.id_persona_moral,
                pm.organizacion_institucion,
                model.nombre_modelo,
                unid.placa,
                estatuscomodato.estatus_comodato,
                uda.fecha_prestamo,
                uda.fecha_devolucion,
                uda.id_colaborador_que_asigna,
                ca.nombre_1 AS nombre1colaborador,
                ca.nombre_2 AS nombre2colaborador,
                ca.apellido_paterno AS apellidopcolaborador,
                ca.apellido_materno AS apellidomcolaborador,
                aud.nombre_1 AS nombre1autorizador,
                aud.nombre_2 AS nombre2autorizador,
                aud.apellido_paterno AS apellidopaternoautorizador,
                aud.apellido_materno AS apellidomaternoautorizador,
                usr.avatar AS avatar_colaborador,
                usr_aut.avatar AS avatar_autorizador,
                jdc.nombre_1 AS nombre1jefe,
                jdc.nombre_2 AS nombre2jefe,
                jdc.apellido_paterno AS apellidopjefe,
                jdc.apellido_materno AS apellidomjefe,
                usrc.avatar AS avatar_jefe_directo
            FROM asignacion_unidad_demo AS uda
                LEFT JOIN unidades AS unid ON uda.id_unidad = unid.id_unidad
                LEFT JOIN modelos AS model ON unid.id_modelo = model.id_modelo
                LEFT JOIN estatus_comodato AS estatuscomodato ON uda.id_estatus_comodato_demo = estatuscomodato.id_estatus_comodato
                LEFT JOIN personas_fisicas AS pf ON uda.id_persona_fisica = pf.id_persona_fisica
                LEFT JOIN personas_morales AS pm ON uda.id_persona_moral = pm.id_persona_moral
                INNER JOIN colaboradores AS ca ON uda.id_colaborador_que_asigna = ca.id_colaborador
                INNER JOIN colaboradores AS aud ON uda.id_autorizador = aud.id_colaborador
                INNER JOIN usuarios AS usr ON usr.id_colaborador = ca.id_colaborador
                LEFT JOIN usuarios AS usr_aut ON usr_aut.id_colaborador = uda.id_autorizador
                LEFT JOIN jefes_directos AS jd ON uda.id_autorizacion_jefe_directo = jd.id_jefe_directo
                LEFT JOIN colaboradores AS jdc ON jd.id_colaborador = jdc.id_colaborador
                LEFT JOIN usuarios AS usrc ON usrc.id_colaborador = jdc.id_colaborador
            WHERE uda.autorizacion = 'APROVADO'
            ORDER BY uda.id_asignacion_unidad_demo DESC";
$resultado = $conexion->query($sqlobtenerunidadsubircomodato);

// Contenedor de Cards
echo '<div id="vistaCards">';
while ($fila = $resultado->fetch_assoc()) {
    if (($fila['id_persona_fisica'] || $fila['id_persona_moral']) && $fila['autorizacion'] === 'APROVADO') {
        $tipo_solicitante = isset($fila['id_persona_fisica']) && $fila['id_persona_fisica'] ? 'fisica' : 'moral';
        $nombreJefe = trim($fila['nombre1jefe'] . ' ' . $fila['nombre2jefe'] . ' ' . $fila['apellidopjefe'] . ' ' . $fila['apellidomjefe']);
        $idAsignacion = $fila['id_asignacion_unidad_demo'];
        $tieneActualizacion = in_array($idAsignacion, $actualizaciones);

        if ($fila['id_estatus_comodato_demo'] != 1 && $fila['id_estatus_comodato_demo'] != 4 && $fila['id_estatus_comodato_demo'] != 5) {
            echo '<div class="card mb-3  tipo-' . $tipo_solicitante . '">';

            // 🔴 Badge solo si hay actualización
            if ($tieneActualizacion) {
                echo '<span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger" style="font-size:0.8rem;z-index:10;">¡Nuevo!</span>';
            }

            if ($fila['id_estatus_comodato_demo'] == 3) {
                echo '<div class="alerta d-flex align-items-center">
                <img src="../../Cliente/videos/succes-green.gif" class="me-2 imgalertasucces"> 
                <h6 class="txtvalidacioncomodato"><b>Comodato subido</b></h6>
                </div>';
            } elseif ($fila['id_estatus_comodato_demo'] == 7) {
                echo '<div class="alerta d-flex align-items-center">
                <img src="../../Cliente/videos/warning-red.gif" class="me-2 imgalertasucces"> 
                <h6 class="txtvalidacioncomodato"><b>Comodato regresado</b></h6>
                </div>';
            }

            echo '<div class="cardheader">
                <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" onerror="this.src=\'../../Cliente/img/unidades/silueta_tracto3.png\'" class="card-img-top img-fluid imgcard" alt="...">
            </div>
            <div class="card-body">';

            if (isset($fila['id_persona_fisica']) && $fila['id_persona_fisica']) {
                echo '<h6 class="card-title"><b>' . $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'] . '</b></h6>';
            } elseif (isset($fila['organizacion_institucion'])) {
                echo '<h6 class="card-title"><b>' . $fila['organizacion_institucion'] . '</b></h6>';
            }

            echo '<h5 class="card-title txteatlevalidacioncomodato"><strong>' . $fila['nombre_modelo'] . '</strong></h5>
                  <h6 class="card-text txtvalidacioncomodato"><b>Solicitante: </b><br>
                  <img src="' . (empty($fila["avatar_colaborador"]) ? "../../Cliente/img/iconos/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"]) . '.png"
                        class="rounded-circle me-2" style="margin-top: 5px; width: 30px; height: 30px; object-fit: cover;" alt="avatar">
                  ' . $fila['nombre1colaborador'] . ' ' . $fila['nombre2colaborador'] . ' ' . $fila['apellidopcolaborador'] . ' ' . $fila['apellidomcolaborador'] . '</h6>';

            if (!empty($nombreJefe)) {
                echo '<h6 class="card-text txtvalidacioncomodato"><b>Jefe directo que autorizó: </b><br>
                      <img src="' . (empty($fila["avatar_jefe_directo"]) ? "../../Cliente/img/iconos/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_jefe_directo"]) . '.png"
                      class="rounded-circle me-2" style="margin-top: 5px; width: 30px; height: 30px; object-fit: cover;" alt="avatar">' . $nombreJefe . '</h6>';
            }

            echo '<h6 class="card-text txtvalidacioncomodato"><b>Autorizador: </b><br>
                  <img src="' . (empty($fila["avatar_autorizador"]) ? "../../Cliente/img/iconos/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_autorizador"]) . '.png"
                  class="rounded-circle me-2" style="margin-top: 5px; width: 30px; height: 30px; object-fit: cover;" alt="avatar">
                  ' . $fila['nombre1autorizador'] . ' ' . $fila['nombre2autorizador'] . ' ' . $fila['apellidopaternoautorizador'] . ' ' . $fila['apellidomaternoautorizador'] . '</h6>';

            echo '<h6 class="card-text txtvalidacioncomodato"><i class="fas fa-car me-2"></i><strong>Placa: </strong>' . $fila['placa'] . '</h6>
                  <h6 class="card-text txtvalidacioncomodato"><i class="fas fa-calendar-check me-2"></i><strong>Asignación: </strong>' . $fila['fecha_prestamo'] . '</h6>
                  <h6 class="text txtvalidacioncomodato"><i class="fas fa-undo-alt me-2"></i><strong>Devolución: </strong>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</h6>
                  
                  <button type="button" 
                        data-idunidad="' . $fila['id_unidad'] . '" 
                        data-idasignacion="' . $fila['id_asignacion_unidad_demo'] . '" 
                        data-idcolaborador="' . $fila['id_colaborador_que_asigna'] . '"  
                        class="btn mt-3 btnmosrarmodalunidadcomodatodemo">Subir COMODATO</button>

                  <button type="button" 
                        data-idunidad="' . $fila['id_unidad'] . '" 
                        data-idasignacion="' . $fila['id_asignacion_unidad_demo'] . '" 
                        data-idcolaborador="' . $fila['id_colaborador_que_asigna'] . '"  
                        class="btn mt-3 btnverarchivos">Archivos</button>';

            echo '</div></div>';
        }
    }
}
echo '</div>'; // Fin contenedor de cards



$resultado->data_seek(0);

// 🔔 IDs de asignaciones con archivos actualizados por solicitante no vistos por jurídico
$actualizaciones = [];
$sqlNotif = "SELECT DISTINCT id_asignacion_unidad_demo 
             FROM observaciones_documentos_juridico 
             WHERE visto_por_usuario = 0
             AND comentario LIKE '%actualizado%'";
$resNotif = $conexion->query($sqlNotif);
while ($row = $resNotif->fetch_assoc()) {
    $actualizaciones[] = $row['id_asignacion_unidad_demo'];
}


echo '<div id="vistaTabla" style="display: none;">
    <div class="table-responsive">
        <table class="table table-hover tablaunidades" id="tablaUnidades">
            <thead class="table-light">
                <tr>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-user me-2"></i>Nombre del usuario/empresa</th>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-car-side me-2"></i>Modelo</th>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-car me-2"></i>Placa</th>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-calendar-check me-2"></i>Asignación</th>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-undo-alt me-2"></i>Devolución</th>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-file-contract me-2"></i>Subir comodato</th>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-file-contract me-2"></i>Archivos</th>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-user-tie me-2"></i>Solicitante</th>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-user-check me-2"></i>Jefe directo aurorización</th>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-user-check me-2"></i>Autorizador</th>
                    <th class="titulostablaverificarcomodatodemo"><i class="fas fa-file-signature me-2"></i>Estado</th>
                </tr>
            </thead>
            <tbody>';

while ($fila = $resultado->fetch_assoc()) {
    if (($fila['id_persona_fisica'] || $fila['id_persona_moral']) && $fila['autorizacion'] === 'APROVADO') {
        $idAsignacion = $fila['id_asignacion_unidad_demo'];
        $tieneActualizacion = in_array($idAsignacion, $actualizaciones);

        // Nombre completo del solicitante
        $nombre = trim(
            ($fila['nombre_1'] ?? '') . ' ' .
            ($fila['nombre_2'] ?? '') . ' ' .
            ($fila['apellido_paterno'] ?? '') . ' ' .
            ($fila['apellido_materno'] ?? '') . ' ' .
            ($fila['organizacion_institucion'] ?? '')
        );

        // Tipo de solicitante
        $tipo_solicitante = isset($fila['id_persona_fisica']) && $fila['id_persona_fisica'] ? 'fisica' : 'moral';

        //nombre solicitante
        $solicitante = trim(
            ($fila['nombre1colaborador'] ?? '') . ' ' .
            ($fila['nombre2colaborador'] ?? '') . ' ' .
            ($fila['apellidopcolaborador'] ?? '') . ' ' .
            ($fila['apellidomcolaborador'] ?? '')
        );

        // Nombre jefe directo
        $nombreJefe = '';
        if (!empty($fila['nombre1jefe'])) {
            $nombreJefe = trim(
                ($fila['nombre1jefe'] ?? '') . ' ' .
                ($fila['nombre2jefe'] ?? '') . ' ' .
                ($fila['apellidopjefe'] ?? '') . ' ' .
                ($fila['apellidomjefe'] ?? '')
            );
        }

        echo '<tr class="fila-solicitante tipo-' . $tipo_solicitante . '">';
        echo '<td class="titulostablaverificarcomodatodemo">' . $nombre . '</td>';
        echo '<td class="titulostablaverificarcomodatodemo">' . $fila['nombre_modelo'] . '</td>';
        echo '<td class="titulostablaverificarcomodatodemo">' . $fila['placa'] . '</td>';
        echo '<td class="titulostablaverificarcomodatodemo">' . $fila['fecha_prestamo'] . '</td>';
        echo '<td class="titulostablaverificarcomodatodemo">' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</td>';

        // Botón subir comodato
        echo '<td style="text-align: center;">
                <button type="button" 
                    data-idunidad="' . $fila['id_unidad'] . '" 
                    data-idasignacion="' . $idAsignacion . '" 
                    data-idcolaborador="' . $fila['id_colaborador_que_asigna'] . '" 
                    class="fas fa-upload btn btntablaverificarcomodatodemojuridico btnmosrarmodalunidadcomodatodemo">
                </button>
              </td>';

        // Botón ver archivos + badge
        echo '<td style="text-align: center; position: relative;">
                <button type="button" 
                        data-idunidad="' . $fila['id_unidad'] . '" 
                        data-idasignacion="' . $idAsignacion . '" 
                        data-idcolaborador="' . $fila['id_colaborador_que_asigna'] . '"  
                        class="btn mt-1 btnverarchivos fas fa-folder"></button>';
        if ($tieneActualizacion) {
            echo '<span class="badge-actualizacion position-absolute top-0 start-100 translate-middle rounded-pill bg-danger" 
                        style="font-size:0.7rem; z-index:10; color:white;">¡Nuevo!</span>';
        }
        echo '</td>';

        // Avatar solicitante
        echo '<td class="titulostablaverificarcomodatodemo" style="text-align: center;">';
        if (!empty($solicitante)) {
                echo '<img src="' . (empty($fila["avatar_colaborador"]) ? "../../Cliente/img/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"] . '.png') . '" 
                     class="rounded-circle me-2" style="width: 25px; height: 25px; object-fit: cover;" alt="avatar">';
                     echo'<br>' . $solicitante;
            }else{
                echo '<span class="text-muted">Sin solicitante</span>';
            }
            echo '</td>';

        // Jefe directo
        echo '<td class="titulostablaverificarcomodatodemo" style="text-align: center;">';
        if (!empty($nombreJefe)) {
            echo '<img src="' . (empty($fila["avatar_jefe_directo"]) ? "../../Cliente/img/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_jefe_directo"] . '.png') . '" 
                        class="rounded-circle me-2" style="width: 25px; height: 25px; object-fit: cover;" alt="avatar">';
            echo '<br>' . $nombreJefe;
        } else {
            echo '<span class="text-muted">Sin jefe asignado</span>';
        }
        echo '</td>';

        // Autorizador
        echo '<td class="titulostablaverificarcomodatodemo" style="text-align: center;">
                <img src="' . (empty($fila["avatar_autorizador"]) ? "../../Cliente/img/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_autorizador"] . '.png') . '" 
                     class="rounded-circle me-2" style="width: 25px; height: 25px; object-fit: cover;" alt="avatar">
                     <br>' . $fila['nombre1autorizador'] . ' ' . $fila['nombre2autorizador'] . ' ' . $fila['apellidopaternoautorizador'] . ' ' . $fila['apellidomaternoautorizador'] . '
              </td>';

        // Estado comodato
        echo '<td class="titulostablaverificarcomodatodemo">';
        if ($fila['id_estatus_comodato_demo'] == 3) {
            echo '<div class="d-flex align-items-center">
                    <img src="../../Cliente/videos/succes-green.gif" class="me-2 imgalertasuccestabla">
                    <b>Comodato subido</b>
                  </div>';
        } elseif ($fila['id_estatus_comodato_demo'] == 7) {
            echo '<div class="d-flex align-items-center">
                    <img src="../../Cliente/videos/warning-red.gif" class="me-2 imgalertasuccestabla">
                    <b>Comodato regresado</b>
                  </div>';
        }
        echo '</td>';

        echo '</tr>';
    }
}
?>
</tbody>
</table>
</div>

<script>
// Función para marcar como visto y quitar badge
function marcarVisto(idAsignacion) {
    // AJAX
    fetch('../../Servidor/solicitudes/unidades_demo_autorizadas/marcar_visto_actualizaciones.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id_asignacion=' + idAsignacion
    })
    .then(response => response.text())
    .then(data => {
        if(data === 'ok') {
            // Quitar badge de la tabla
            document.querySelectorAll('.btnverarchivos').forEach(btn => {
                if(btn.dataset.idasignacion == idAsignacion) {
                    const badgeTabla = btn.nextElementSibling;
                    if(badgeTabla && badgeTabla.classList.contains('badge-actualizacion')) {
                        badgeTabla.remove();
                    }
                }
            });

            // Quitar badge de la card
            document.querySelectorAll('#vistaCards .card').forEach(card => {
                const cardId = card.querySelector('.btnmosrarmodalunidadcomodatodemo')?.dataset.idasignacion;
                if(cardId == idAsignacion) {
                    const badgeCard = card.querySelector('span.position-absolute.bg-danger');
                    if(badgeCard) badgeCard.remove();
                }
            });
        }
    });
}

// Evento para botones "Archivos" en tabla y cards
document.querySelectorAll('.btnverarchivos, #vistaCards .btnverarchivos').forEach(btn => {
    btn.addEventListener('click', function() {
        const idAsignacion = this.dataset.idasignacion;
        marcarVisto(idAsignacion);
    });
});
</script>
