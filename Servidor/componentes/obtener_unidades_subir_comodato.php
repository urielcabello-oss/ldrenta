<?php 
//query para obtener las unidades a las que se les va a subir el comodato del lado de juridico

include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}

$sqlobtenerunidadsubircomodato = "SELECT unid.img_unidad,
            unidasigcolab.id_asignaciones,
            unidasigcolab.id_unidad,
            unidasigcolab.id_colaborador,
            unidasigcolab.id_usuario_externo,
            unidasigcolab.id_estatus_comodato,
            colab.nombre_1 AS nombre1colaborador,
            colab.nombre_2 AS nombre2colaborador,
            colab.apellido_paterno AS apellidopaterno_colaborador,
            colab.apellido_materno AS apellidomaterno_colaborador,
            usuexterno.nombre_1 AS nombre1usuario,
            usuexterno.nombre_2 AS nombre2usuario,
            usuexterno.apellido_paterno AS apellidopaterno_usuario,
            usuexterno.apellido_materno AS apellidomaterno_usuario,
            model.nombre_modelo,
            unid.placa,
            estatuscomodato.estatus_comodato,
            unidasigcolab.fecha_asignacion,
            unidasigcolab.fecha_devolucion
        FROM asignacion_unidad_colaborador AS unidasigcolab
        LEFT JOIN unidades AS unid 
        ON unidasigcolab.id_unidad = unid.id_unidad
        LEFT JOIN modelos AS model 
        ON unid.id_modelo = model.id_modelo 
        LEFT JOIN estatus_comodato AS estatuscomodato
        ON unidasigcolab.id_estatus_comodato = estatuscomodato.id_estatus_comodato
        LEFT JOIN colaboradores AS colab 
        ON unidasigcolab.id_colaborador = colab.id_colaborador
        LEFT JOIN usuarios_externos AS usuexterno
        ON unidasigcolab.id_usuario_externo = usuexterno.id_usuario_externo";
$resultado = $conexion->query($sqlobtenerunidadsubircomodato);


// Contenedor de Cards
echo '<div id="vistaCards">';
while ($fila = $resultado->fetch_assoc()) {
    if ($fila['id_estatus_comodato'] != 1 && $fila['id_estatus_comodato'] != 4 && $fila['id_estatus_comodato'] != 5) {
        echo '<div class="card mb-3">';
        if ($fila['id_estatus_comodato'] == 3) {
            echo '<div class="alerta d-flex align-items-center"">
                <img src="../../Cliente/videos/succes-green.gif" class="me-2 imgalertasucces> 
                <h6 class="txtvalidacioncomodato"><b>Comodato subido</b></h6>
                </div>';
        }elseif($fila['id_estatus_comodato'] == 7) {
            echo '<div class="alerta d-flex align-items-center">
                <img src="../../Cliente/videos/warning-red.gif" class="me-2 imgalertasucces"> 
                <h6 class="txtvalidacioncomodato"><b>Comodato regresado</b></h6>
                </div>';
        }

        echo '<div class="cardheader">
                <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" onerror="this.src=\'../../Cliente/img/unidades/carro_desconocido.png\'" class="card-img-top img-fluid imgcard" alt="..." >
            </div>
            <div class="card-body">
            <h6 class="card-title" txteatlevalidacioncomodato><b>' . 
                ($fila['id_colaborador'] ? 
                    $fila['nombre1colaborador'] . ' ' . $fila['nombre2colaborador'] . ' ' . $fila['apellidopaterno_colaborador'] . ' ' . $fila['apellidomaterno_colaborador'] : 
                    $fila['nombre1usuario'] . ' ' . $fila['nombre2usuario'] . ' ' . $fila['apellidopaterno_usuario'] . ' ' . $fila['apellidomaterno_usuario']) .
                '</b></h6>
                <h5 class="card-title txteatlevalidacioncomodato"><strong>' . $fila['nombre_modelo'] . '</strong></h5>
                <h6 class="card-text txtvalidacioncomodato"><i class="fas fa-car me-2"></i><strong>Placa: </strong>' . $fila['placa'] . '</h6>
                <h6 class="card-text txtvalidacioncomodato"><i class="fas fa-calendar-check me-2"></i><strong>Asignación: </strong>' . $fila['fecha_asignacion'] . '</h6>
                <h6 class="text txtvalidacioncomodato"><i class="fas fa-undo-alt me-2"></i><strong>Devolución: </strong>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</h6>
                <button type="button" id="btnmosrarmodalunidadcomodato" data-idunidad="' . $fila['id_unidad'] . '" data-id="' . $fila['id_asignaciones'] . '" data-idcolaborador="' . $fila['id_colaborador'] . '" data-idusuario="' . $fila['id_usuario_externo'] . '" class="btn mt-3 btnmosrarmodalunidadcomodato">Subir COMODATO</button>
            </div>
        </div>';
    }
}
echo '</div>'; // Fin contenedor de cards

// Reiniciar puntero y mostrar tabla
$resultado->data_seek(0);

echo '<div id="vistaTabla" style="display: none;">
    <div class="table-responsive">
        <table class="table table-hover tablaunidades" id="tablaUnidades">
            <thead class="table-light">
                <tr>
                    <th class="titulostablaverificarcomodato"><i class="fas fa-user me-2"></i>Nombre del colaborador</th>
                    <th class="titulostablaverificarcomodato"><i class="fas fa-car-side me-2"></i>Modelo</th>
                    <th class="titulostablaverificarcomodato"><i class="fas fa-car me-2"></i>Placa</th>
                    <th class="titulostablaverificarcomodato"><i class="fas fa-calendar-check me-2"></i>Asignación</th>
                    <th class="titulostablaverificarcomodato"><i class="fas fa-undo-alt me-2"></i>Devolución</th>
                    <th class="titulostablaverificarcomodato"><i class="fas fa-eye me-2"></i>Ver</th>
                    <th class="titulostablaverificarcomodato"><i class="fas fa-file-signature me-2"></i>Estado</th>
                </tr>
            </thead>
            <tbody>';

while ($fila = $resultado->fetch_assoc()) {
    if ($fila['id_estatus_comodato'] != 1 && $fila['id_estatus_comodato'] != 4) {
        $nombre = $fila['id_colaborador'] ? 
            $fila['nombre1colaborador'] . ' ' . $fila['nombre2colaborador'] . ' ' . $fila['apellidopaterno_colaborador'] . ' ' . $fila['apellidomaterno_colaborador'] : 
            $fila['nombre1usuario'] . ' ' . $fila['nombre2usuario'] . ' ' . $fila['apellidopaterno_usuario'] . ' ' . $fila['apellidomaterno_usuario'];
        echo '<tr>
            <td class="titulostablaverificarcomodato">' . $nombre . '</td>
            <td class="titulostablaverificarcomodato">' . $fila['nombre_modelo'] . '</td>
            <td class="titulostablaverificarcomodato">' . $fila['placa'] . '</td>
            <td class="titulostablaverificarcomodato">' . $fila['fecha_asignacion'] . '</td>
            <td class="titulostablaverificarcomodato">' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</td>
            <td><button type="button" id="btnmosrarmodalunidadcomodato" data-idunidad="' . $fila['id_unidad'] . '" data-id="' . $fila['id_asignaciones'] . '" data-idcolaborador="' . $fila['id_colaborador'] . '" data-idusuario="' . $fila['id_usuario_externo'] . '" class="btn mt-3 btntablaverificarcomodatojuridico btnmosrarmodalunidadcomodato">Subir COMODATO</button></td>
            <td class="titulostablaverificarcomodato">';
                echo '<?php';
                if ($fila['id_estatus_comodato'] == 3) {
                    echo '<div>
                    <div class="estadocomodato d-flex align-items-center">
    <img src="../../Cliente/videos/succes-green.gif" class="me-2 imgalertasuccestabla">
    <h6 class="txtvalidacioncomodato"><b>Comodato subido</b></h6>
</div>
</div>';
                } elseif ($fila['id_estatus_comodato'] == 7) {
                    echo '<div>
                    <div class="alerta d-flex align-items-center">
                            <img src="../../Cliente/videos/warning-red.gif" class="me-2 imgalertasuccestabla">
                            <h6 class="txtvalidacioncomodato"><b>Comodato regresado</b></h6>
                        </div>
                        </div>';
                } else {
                    echo $fila['fecha_asignacion'];
                }
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


