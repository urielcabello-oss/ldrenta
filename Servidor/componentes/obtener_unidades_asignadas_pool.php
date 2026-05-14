<?php

include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}
$arreglo_unidadespool = array();
//query para obtener el id de las unidades asignadas del lado admin

$sqlobtenerunidadasignada = "SELECT unid.img_unidad,
                                    unidasigcolab.id_asignaciones,
                                    unidasigcolab.id_unidad,
                                    unidasigcolab.id_colaborador,
                                    unidasigcolab.id_estatus_carta_responsiva,
                                    colab.nombre_1,
                                    colab.nombre_2,
                                    colab.apellido_paterno,
                                    colab.apellido_materno,
                                    unidasigcolab.politica_aceptada,
                                    model.nombre_modelo,
                                    unid.placa,
                                    unid.vin,
                                    unid.id_estado_unidad,
                                    unid.id_tipo_unidad,
                                    unidasigcolab.fecha_asignacion,
                                    unidasigcolab.fecha_devolucion
                            FROM asignacion_unidad_colaborador AS unidasigcolab
                            INNER JOIN unidades AS unid 
                            ON unidasigcolab.id_unidad = unid.id_unidad
                            INNER JOIN modelos AS model 
                            ON unid.id_modelo = model.id_modelo 
                            INNER JOIN colaboradores AS colab 
                            ON unidasigcolab.id_colaborador = colab.id_colaborador
                            WHERE unidasigcolab.id_colaborador";

$resultado = $conexion->query($sqlobtenerunidadasignada);

$arreglo_unidadespool = array();

while ($fila = $resultado->fetch_assoc()) {

    $arreglo_unidadespool[] = $fila;
}

function ordenarPorFechapool($a, $b) {
    $fechaA = (isset($a['fecha_asignacion']) && !empty($a['fecha_asignacion'])) ? strtotime($a['fecha_asignacion']) : 0;
    $fechaB = (isset($b['fecha_asignacion']) && !empty($b['fecha_asignacion'])) ? strtotime($b['fecha_asignacion']) : 0;
    return $fechaA - $fechaB;
}

if (count($arreglo_unidadespool) > 0) {
    usort($arreglo_unidadespool, 'ordenarPorFechapool');
}


foreach ($arreglo_unidadespool as $fila) {

    if ($fila['id_estado_unidad'] == 3 && $fila['id_tipo_unidad'] == 2) {
        echo '<div class="card">
            <div class="cardheader">
                <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" class="card-img-top img-fluid imgcard" alt="..." onerror="this.src=\'../../Cliente/img/unidades/carro_desconocido.png\'" >
            </div>
            <div class="card-body mt-3">
                <h6 class="card-title"><b>' . $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'] . '</b></h6>
                
                <h6 class="card-title"><b>' . $fila['nombre_modelo'] . '</b></h6>
                <h6 class="card-text"><b>Placa: </b>' . $fila['placa'] . '</h6>
                <h6 class="card-text"><b>VIN: </b>' . $fila['vin'] . '</h6>
                <h6 class="card-text"><b>Asignación: </b>' . date('d-m-Y', strtotime($fila['fecha_asignacion'])) . '</h6>
                <h6 class="text"><b>Devolución: </b>' . ($fila['fecha_devolucion'] != '0000-00-00' ? date('d-m-Y', strtotime($fila['fecha_devolucion'])) : '') . '</h6>
                <button type="button" id="btnentregaunidad" data-id="' . $fila['id_unidad'] . '" data-idcolaborador="' . $fila['id_colaborador'] . '" class="btn btn-success btn-sm  btnentregaunidad">Asignación presencial</button>
     </div>
        </div>';
    }
}
