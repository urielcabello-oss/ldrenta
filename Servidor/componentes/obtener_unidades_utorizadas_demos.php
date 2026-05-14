<?php
include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}
$id_colaborador_que_asigna = $_SESSION['id_colaborador'];

//uda = Unidad Demo Autorizada
//pf = Persona Fisica
//pm = Persona Moral
//ca = Colaborador que Asigna
//pru = Prorroga Unidad demo
$sqlobtenerunidadesdemoautorizadas = "SELECT unid.img_unidad,
                uda.id_asignacion_unidad_demo,
                uda.id_unidad,
                uda.id_colaborador_que_asigna,
                uda.id_persona_fisica,
                uda.autorizacion,
                uda.id_estado_prueba_demo,
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
                unid.paso_diferencial,
                unid.vin,
                uda.fecha_prestamo,
                uda.fecha_devolucion,
                uda.impacto_atencion,
                uda.id_colaborador_que_asigna,
                ca.nombre_1 AS nombre1colaborador,
                ca.nombre_2 AS nombre2colaborador,
                ca.apellido_paterno AS apellidopcolaborador,
                ca.apellido_materno AS apellidomcolaborador,
                aud.nombre_1 AS nombre1autorizador,
                aud.nombre_2 AS nombre2autorizador,
                aud.apellido_paterno AS apellidopautorizador,
                aud.apellido_materno AS apellidomautorizador,
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
            LEFT JOIN colaboradores AS aud
            ON uda.id_autorizador = aud.id_colaborador
            INNER JOIN colaboradores AS ca
            ON uda.id_colaborador_que_asigna = ca.id_colaborador
            LEFT JOIN prorrogas_unidades_demo AS pru
            ON pru.id_asignacion_unidad_demo = uda.id_asignacion_unidad_demo
            WHERE uda.autorizacion = 'APROVADO'
            AND uda.id_colaborador_que_asigna = $id_colaborador_que_asigna
            ORDER BY uda.id_asignacion_unidad_demo DESC";

$resultado = $conexion->query($sqlobtenerunidadesdemoautorizadas);


function obtenerSemaforoImpacto($impacto){

    if($impacto == 1){
        return '<span class="badge bg-success">Impacto Bajo</span>';
    }

    if($impacto == 2){
        return '<span class="badge bg-warning text-dark">Impacto Medio</span>';
    }

    if($impacto == 3){
        return '<span class="badge bg-danger">Impacto Alto</span>';
    }

    return '<span class="badge bg-secondary">Sin evaluar</span>';
}

echo '<div id="vistaCards">';
while ($fila = $resultado->fetch_assoc()) {

    $id_asignacion_demo = $fila['id_asignacion_unidad_demo'];

    // Verificar si existen observaciones
    $sqlObs = "SELECT COUNT(*) AS total_obs 
           FROM observaciones_documentos_juridico 
           WHERE id_asignacion_unidad_demo = $id_asignacion_demo 
           AND comentario IS NOT NULL 
           AND comentario != ''";
    $resObs = $conexion->query($sqlObs);
    $obsData = $resObs->fetch_assoc();
    $tieneObservaciones = $obsData['total_obs'] > 0;



    if (($fila['id_persona_fisica'] || $fila['id_persona_moral']) && $fila['autorizacion'] === 'APROVADO') {
        $tipo_solicitante = isset($fila['id_persona_fisica']) && $fila['id_persona_fisica'] ? 'fisica' : 'moral';
        echo '<div class="card mb-3 card-solicitante tipo-' . $tipo_solicitante . '">';
        if (!empty($fila['id_prorroga_unidad_demo']) && $fila['id_estado_prueba_demo'] != 5) {
            echo '<div class="alerta d-flex align-items-center">
                <img src="../../Cliente/videos/notificacion.gif" class="me-2 imgalertasucces">
                <h6 class="txtvalidacioncomodato"><b>Prórroga solicitada</b></h6>
            </div>';
        }
        echo '<div class="cardheader">';
        //--------------------------------habilitar y desabilitar botón de comodato solo si juridico ya lo subio-------------------------------------------------
        if ($fila['id_estatus_comodato_demo'] == 3) {
            echo '<button type="button" 
                            class="fa-solid fa-file me-2 btn btn-sm btn-success btncomodatodemo position-absolute top-0 end-0 mt-2 me-2" 
                            data-id_asignacion_demo="' . $fila['id_asignacion_unidad_demo'] . '">
                        </button>';
        }

        // ------------------------------------------------------------Botón para ver observaciones jurídicas------------------------------------
        if ($tieneObservaciones) {
            echo '<button type="button" 
                class="fa-solid fa-comment me-2 btn btn-warning btn-sm btnVerObservaciones position-absolute top-0 start-0 mt-2 ms-2" 
                data-id-asignacion-demo="' . $id_asignacion_demo . '">
          </button>';
        }


        echo '<img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" onerror="this.src=\'../../Cliente/img/unidades/silueta_tracto3.png\'" class="card-img-top img-fluid imgcard" alt="..."
            onclick="window.location.href = \'realizacion_prueba_demo.php?id_unidad=' . $fila['id_asignacion_unidad_demo'] . '\'">
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
            <div class="mb-2">'.obtenerSemaforoImpacto($fila['impacto_atencion']).'</div>
            <h6 class="card-text"><i class="fas fa-barcode me-2"></i><strong>VIN:</strong> ' . $fila['vin'] . '</h6>
            <h6 class="card-text"><i class="fas fa-road me-2"></i><strong>Paso dif.</strong> ' . $fila['paso_diferencial'] . '</h6>
            <h6 class="card-text"><i class="fas fa-car me-2"></i><b>Placa: </b>' . $fila['placa'] . '</h6>
            <h6 class="card-text"><i class="fas fa-calendar-check me-2"></i><b>Asignación: </b>' . $fila['fecha_prestamo'] . '</h6>
            <h6 class="card-text"><i class="fas fa-undo-alt me-2"></i><b>Devolución: </b>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</h6>';


        if ($fila['id_estado_prueba_demo'] != 3 && $fila['id_estado_prueba_demo'] != 2 && $fila['id_estado_prueba_demo'] != 1 && $fila['id_estado_prueba_demo'] != NULL) {
            //verificamos si tiene prorroga o no para mostrar el boton
            if (empty($fila['id_prorroga_unidad_demo']) && $fila['id_estado_prueba_demo'] != 5) {
                // ✅ No tiene prórroga → mostrar botón habilitado
                echo '<button type="button" 
                     class="btn btn-primary btn-sm btnsolicitarprorrogademo" 
                     data-id_asignacion_demo="' . $fila['id_asignacion_unidad_demo'] . '">
                 Prórroga
              </button>';
            }

            echo '<button type="button" class="btn btn-success btn-sm btnreportefinalunidademo" 
                 data-id_asignacion_demo="' . $fila['id_asignacion_unidad_demo'] . '">
             Reporte
          </button>';

            if ($fila['id_estado_prueba_demo'] != 5) {
                echo '<button type="button" 
                     class="btn btn-warning btn-sm btnfinalizarpruebaunidademo" 
                     data-id_asignacion_demo="' . $fila['id_asignacion_unidad_demo'] . '">
                 Finalizar
              </button>';
            }
        }
        echo '</div>
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
                    <th>Nombre del usuario/empresa</th>
                    <th>Modelo</th>
                    <th>Placa</th>
                    <th>Asignación</th>
                    <th>Devolución</th>
                </tr>
            </thead>
            <tbody>';

while ($fila = $resultado->fetch_assoc()) {
    if (($fila['id_persona_fisica'] || $fila['id_persona_moral']) && $fila['autorizacion'] === 'APROVADO') {
        $nombre = $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'] . ' ' . $fila['organizacion_institucion'];
        $tipo_solicitante = isset($fila['id_persona_fisica']) && $fila['id_persona_fisica'] ? 'fisica' : 'moral';
        echo '<tr class="fila-solicitante tipo-' . $tipo_solicitante . '">';
        echo '
            <td>' . $nombre . '</td>
            <td>' . $fila['nombre_modelo'] . '</td>
            <td>' . $fila['placa'] . '</td>
            <td>' . $fila['fecha_prestamo'] . '</td>
            <td>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</td>';
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