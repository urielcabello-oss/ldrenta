<?php 
include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}
//query para obtener el id de las unidades preasignadas

$sqlobtenerunidadvercartaresponsiva = "SELECT unid.img_unidad,
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
            unid.kilometraje,
            unid.placa,
            unid.id_tipo_unidad,
            unidasigcolab.fecha_asignacion,
            unidasigcolab.fecha_devolucion
        FROM asignacion_unidad_colaborador AS unidasigcolab
        LEFT JOIN unidades AS unid 
        ON unidasigcolab.id_unidad = unid.id_unidad
        LEFT JOIN modelos AS model 
        ON unid.id_modelo = model.id_modelo 
        LEFT JOIN colaboradores AS colab 
        ON unidasigcolab.id_colaborador = colab.id_colaborador
        WHERE unidasigcolab.id_colaborador";
$resultado = $conexion->query($sqlobtenerunidadvercartaresponsiva);

while ($fila = $resultado->fetch_assoc()) {

    $arreglo_unidades[] = $fila;
}
function ordenarPorFecha($a, $b) {
    return strtotime($a['fecha_asignacion']) - strtotime($b['fecha_asignacion']);
}

usort($arreglo_unidades, 'ordenarPorFecha');

foreach ($arreglo_unidades as $fila) {
    if ($fila['id_estatus_carta_responsiva'] != 2 && $fila['id_tipo_unidad'] == 1) {
        echo '<div class="card">';
        if ($fila['id_estatus_carta_responsiva'] == 4) {
            echo "<div class='alerta'>
            <img src='../../Cliente/videos/actualizar.gif' alt='...'> 
            Responsiva: Subida
            </div>";
        }elseif ($fila['id_estatus_carta_responsiva'] == 3) {
            echo "<div class='alerta'>
            <img src='../../Cliente/videos/warning-red.gif' alt='...'> 
            Responsiva: Rechazada
            </div>";
        }
        echo '
            <div class="cardheader">
                <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" class="card-img-top img-fluid imgcard" alt="..." >
            </div>
            <div class="card-body mt-3">
                <h6 class="card-title"><b>' . $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'] . '</b></h6>

                <h6 class="card-title"><b>' . $fila['nombre_modelo'] . '</b></h6>
                <h6 class="card-text"><b>Placa: </b>' . $fila['placa'] . '</h6>
                <h6 class="card-text"><b>Asignación: </b>' . date('d-m-Y', strtotime($fila['fecha_asignacion'])) . '</h6>
                <h6 class="text"><b>Devolución: </b>' . ($fila['fecha_devolucion'] != '0000-00-00' ? date('d-m-Y', strtotime($fila['fecha_devolucion'])) : '') . '</h6>
<button type="button"  id="btnmosrarmodalunidadsolicitud" data-idunidad="' . $fila['id_unidad'] . '" data-id="' . $fila['id_asignaciones'] . '" class="btn btn-primary mt-3 btnmosrarmodalunidadsolicitud">Verificar responsiva</button>
     </div>
        </div>';
    }
}
?>