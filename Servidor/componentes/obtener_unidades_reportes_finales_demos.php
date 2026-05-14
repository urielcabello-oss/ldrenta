<?php
include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}
        //uda = Unidad Demo Autorizada
        //pf = Persona Fisica
        //pm = Persona Moral
        //ca = Colaborador que Asigna

            $sqlobtenerunidadesdemoautorizadas = "SELECT unid.img_unidad,
                uda.id_asignacion_unidad_demo,
                uda.id_unidad,
                uda.id_colaborador_que_asigna,
                uda.id_persona_fisica,
                uda.autorizacion,
                uda.solicitar_master_driver,
                uda.id_estado_prueba_demo,
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
                uda.fecha_prestamo,
                uda.fecha_devolucion,
                uda.id_colaborador_que_asigna,
                ca.nombre_1 AS nombre1colaborador,
                ca.nombre_2 AS nombre2colaborador,
                ca.apellido_paterno AS apellidopcolaborador,
                ca.apellido_materno AS apellidomcolaborador,
                usr.avatar AS avatar_colaborador
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
            INNER JOIN usuarios AS usr 
            ON usr.id_colaborador = ca.id_colaborador
            WHERE uda.autorizacion = 'APROVADO'
            AND uda.solicitar_master_driver = 1
            AND uda.id_estado_prueba_demo IN (4, 5)
            order by uda.id_asignacion_unidad_demo ASC";

$resultado = $conexion->query($sqlobtenerunidadesdemoautorizadas);


echo '<div id="vistaCards">';
while ($fila = $resultado->fetch_assoc()) {
    if (($fila['id_persona_fisica'] || $fila['id_persona_moral']) && $fila['autorizacion'] === 'APROVADO') {
        $tipo_solicitante = isset($fila['id_persona_fisica']) && $fila['id_persona_fisica'] ? 'fisica' : 'moral';
        echo '<div class="card mb-3 card-solicitante tipo-' . $tipo_solicitante . '">';
        echo '<div class="cardheader">
            <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" onerror="this.src=\'../../Cliente/img/unidades/silueta_tracto3.png\'" class="card-img-top img-fluid imgcard" alt="...">
        </div>
        <div class="card-body">';
        if (isset($fila['id_persona_fisica']) && $fila['id_persona_fisica']) {
            echo '<h6 class="card-title"><b>' .
                $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'] .
                '</b></h6>';
        } elseif (isset($fila['organizacion_institucion'])) {
            echo '<h6 class="card-title"><b>' . $fila['organizacion_institucion'] . '</b></h6>';
        } else {
            echo '<h6 class="card-title text-danger"><b>Sin datos del solicitante</b></h6>';
        }
        echo '<h6 class="card-title"><b>' . $fila['nombre_modelo'] . '</b></h6>
            <h6 class="card-text"><b>Solicitante: </b><br><img src="' . (empty($fila["avatar_colaborador"]) ? "../../Cliente/img/iconos/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"]) . '.png"
            class="rounded-circle me-2" style="margin-top: 5px; width: 30px; height: 30px; object-fit: cover;" alt="avatar">
            ' . $fila['nombre1colaborador'] . ' ' . $fila['nombre2colaborador'] . ' ' . $fila['apellidopcolaborador'] . ' ' . $fila['apellidomcolaborador'] . '</h6>
            <h6 class="card-text"><i class="fas fa-car me-2"></i><b>Placa: </b>' . $fila['placa'] . '</h6>
            <h6 class="card-text"><i class="fas fa-calendar-check me-2"></i><b>Asignación: </b>' . $fila['fecha_prestamo'] . '</h6>
            <h6 class="card-text"><i class="fas fa-undo-alt me-2"></i><b>Devolución: </b>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') .
            '</h6>
            <button type="button" class="btn btn-primary btn-sm btnreportefinalunidademo" data-id_asignacion_demo="' . $fila['id_asignacion_unidad_demo'] . '">Reporte</button>
            <button type="button" class="btn btn-sm btn-mapa btnubicacionunidad" data-vin="' . $fila['vin'] . '">
                            <i class="fa-solid fa-location-dot"></i> 
        </div>
        </div>';
    }
}
echo '</div>';

$resultado->data_seek(0);

echo '<div id="vistaTabla" style="display: none;">
    <div class="table-responsive">
        <table class="table table-hover tablaunidades" id="tablaUnidades">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <th>Nombre del usuario/empresa</th>
                    <th>Modelo</th>
                    <th>Placa</th>
                    <th>Asignación</th>
                    <th>Devolución</th>
                    <th>Ubicación</th>
                    <th>Solicitante</th>
                </tr>
            </thead>
            <tbody>';

while ($fila = $resultado->fetch_assoc()) {
    if (($fila['id_persona_fisica'] || $fila['id_persona_moral']) && $fila['autorizacion'] === 'APROVADO') {
        $nombre = $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'] . ' ' . $fila['organizacion_institucion'];
        $tipo_solicitante = isset($fila['id_persona_fisica']) && $fila['id_persona_fisica'] ? 'fisica' : 'moral';
        echo '<tr class="fila-solicitante tipo-' . $tipo_solicitante . '">';
        echo '
            <td></td>
            <td>' . $nombre . '</td>
            <td>' . $fila['nombre_modelo'] . '</td>
            <td>' . $fila['placa'] . '</td>
            <td>' . $fila['fecha_prestamo'] . '</td>
            <td>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</td>
            <td style="text-align: center;">
                <button type="button" class="btn btn-sm btn-mapa btnubicacionunidad" data-vin="' . $fila['vin'] . '">
                            <i class="fa-solid fa-location-dot"></i> 
                        </button></td>
            <td style="text-align: center;"><img src="' . (empty($fila["avatar_colaborador"]) ? "../../Cliente/img/default_avatar.png" : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"]) . '.png"
                class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;" alt="avatar"></td>
            <td>' . $fila['nombre1colaborador'] . ' ' . $fila['nombre2colaborador'] . ' ' . $fila['apellidopcolaborador'] . ' ' . $fila['apellidomcolaborador'] . '            </td>
        </tr>';
        echo '<?php';
?>
        </td>
        </tr>
<?php
    }
}
?>
</tbody>
</table>
</div>