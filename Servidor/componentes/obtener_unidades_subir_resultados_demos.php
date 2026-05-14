<?php
include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}

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
                unid.vin,
                estatuscomodato.estatus_comodato,
                uda.fecha_prestamo,
                uda.fecha_devolucion,
                uda.id_estado_prueba_demo,
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
                epd.estado_prueba
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
                INNER JOIN colaboradores AS ca
                ON uda.id_colaborador_que_asigna = ca.id_colaborador
                INNER JOIN colaboradores AS aud
                ON uda.id_autorizador = aud.id_colaborador
                INNER JOIN usuarios AS usr 
                ON usr.id_colaborador = ca.id_colaborador
                LEFT JOIN usuarios AS usr_aut
                ON usr_aut.id_colaborador = aud.id_colaborador
                LEFT JOIN estado_pruebas_demos AS epd
                ON uda.id_estado_prueba_demo = epd.id_estado_prueba_demo
            WHERE uda.autorizacion = 'APROVADO' AND uda.id_estado_prueba_demo = 3";

$resultado = $conexion->query($sqlobtenerunidadsubircomodato);

echo '<div class="table-responsive">
    <table class="table table-hover tablaunidades" id="tablaUnidades">
        <thead class="table-light">
            <tr>
                <th class="titulostablaverificarcomodatodemo" style="text-align: center"><i class="fas fa-user me-2"></i></th>
                <th class="titulostablaverificarcomodatodemo" style="text-align: center"><i class="fas fa-route me-2"></i></th>
                <th class="titulostablaverificarcomodatodemo">Nombre del usuario/empresa</th>
                <th class="titulostablaverificarcomodatodemo">Modelo</th>
                <th class="titulostablaverificarcomodatodemo">Placa</th>
                <th class="titulostablaverificarcomodatodemo">Asignación</th>
                <th class="titulostablaverificarcomodatodemo">Devolución</th>
                <th class="titulostablaverificarcomodatodemo">Estado</th>
                <th class="titulostablaverificarcomodatodemo">Solicitante</th>
                <th class="titulostablaverificarcomodatodemo"></th>
                <th class="titulostablaverificarcomodatodemo">Autorizador</th>
                <th class="titulostablaverificarcomodatodemo"></th> 
                <th class="titulostablaverificarcomodatodemo">Verificar</th>
            </tr>
        </thead>
        <tbody>';

while ($fila = $resultado->fetch_assoc()) {
    if (($fila['id_persona_fisica'] || $fila['id_persona_moral']) && $fila['autorizacion'] === 'APROVADO') {
        $nombre = $fila['id_persona_fisica'] ? $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'] : $fila['organizacion_institucion'];
        $tipo_solicitante = $fila['id_persona_fisica'] ? 'fisica' : 'moral';

        echo '<tr class="fila-solicitante tipo-' . $tipo_solicitante . '">';
        echo '
            <td class="text-center">
                <button type="button" class="fas fa-eye btn btn-sm btn-outline-green btnmostrarinfodemo" data-infodemo="' . $fila['id_unidad'] . '"></button>
            </td>
            <td style="text-align: center;">
                <button type="button" class="btn btn-sm btn-mapa btnubicacionunidad" data-vin="' . $fila['vin'] . '">
                            <i class="fa-solid fa-location-dot"></i> 
                        </button></td>
            <td class="titulostablaverificarcomodatodemo">' . $nombre . '</td>
            <td class="titulostablaverificarcomodatodemo">' . $fila['nombre_modelo'] . '</td>
            <td class="titulostablaverificarcomodatodemo">' . $fila['placa'] . '</td>
            <td class="titulostablaverificarcomodatodemo">' . $fila['fecha_prestamo'] . '</td>
            <td class="titulostablaverificarcomodatodemo">' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</td>
            <td class="titulostablaverificarcomodatodemo">';
            if ($fila['id_estado_prueba_demo'] == 3) {
                echo '<span class="text-success">FINALIZADA</span>';
                } else {
                    echo 'No hay pruebas';
                    }
                    echo '</td>
                    <td class="text-center">
                    <img src="' . (empty($fila["avatar_colaborador"]) ? "../../Cliente/img/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"]) . '.png"
                    class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;" alt="avatar">
                    </td>
                    <td class="titulostablaverificarcomodatodemo">' . $fila['nombre1colaborador'] . ' ' . $fila['nombre2colaborador'] . ' ' . $fila['apellidopcolaborador'] . ' ' . $fila['apellidomcolaborador'] . '</td>
                    <td class="text-center">
                    <img src="' . (empty($fila["avatar_autorizador"]) ? "../../Cliente/img/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_autorizador"]) . '.png"
                    class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;" alt="avatar">
                    </td>
                    <td class="titulostablaverificarcomodatodemo">' . $fila['nombre1autorizador'] . ' ' . $fila['nombre2autorizador'] . ' ' . $fila['apellidopaternoautorizador'] . ' ' . $fila['apellidomaternoautorizador'] . '</td>
                    <td class="text-center">
                        <button onclick="window.location.href = \'realizacion_prueba_demo.php?id_unidad=' . $fila['id_asignacion_unidad_demo'] . '\'" type="button" class="fas fa-car btn btntablaverificarcomodatodemojuridico""></button>
                    </td>
            </tr>';
    }
}

echo '</tbody></table></div>';
