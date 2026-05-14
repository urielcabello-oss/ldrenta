<?php

include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}

$id_usuario = $_SESSION['id_colaborador'];

//query para obtener el id de las unidades preasignadas del lado del cliente

$sqlobtenerunidadpreasignada = "SELECT unid.img_unidad,
            unidasigcolab.id_asignaciones,
            unidasigcolab.id_unidad,
            unidasigcolab.id_colaborador,
            unidasigcolab.politica_aceptada,
            model.nombre_modelo,
            estatusrespons.estatus_responsiva,
            estatusrespons.id_estatus_carta_responsiva,
            estatuscomodato.id_estatus_comodato,
            estatuscomodato.estatus_comodato,
            unid.placa,
            unid.id_estado_unidad,
            unidasigcolab.fecha_asignacion,
            unidasigcolab.fecha_devolucion
        FROM asignacion_unidad_colaborador AS unidasigcolab
        INNER JOIN unidades AS unid 
        ON unidasigcolab.id_unidad = unid.id_unidad
        INNER JOIN modelos AS model 
        ON unid.id_modelo = model.id_modelo 
        INNER JOIN estatus_carta_responsiva AS estatusrespons 
        ON unidasigcolab.id_estatus_carta_responsiva = estatusrespons.id_estatus_carta_responsiva
        INNER JOIN estatus_comodato AS estatuscomodato
        ON unidasigcolab.id_estatus_comodato = estatuscomodato.id_estatus_comodato
        WHERE unidasigcolab.id_colaborador = $id_usuario";
$resultado = $conexion->query($sqlobtenerunidadpreasignada);


while ($fila = $resultado->fetch_assoc()) {
    if ($fila['id_estado_unidad'] == 3) {
        echo "<div class='cardmisunidades card'>";
        echo '
                <div class="cardheader">
                    <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" class="card-img-top img-fluid imgcard" onerror="this.src=\'../../Cliente/img/unidades/carro_desconocido.png\'" alt="..." >
                </div>
                <div class="card-body mt-3">
                
                <h5 class="card-title"><strong>' . $fila['nombre_modelo'] . '</strong></h5>
                    <h6 class="card-text"><strong>Placa: </strong>' . $fila['placa'] . '</h6>
                    <h6 class="card-text"><strong>Asignación: </strong>' . $fila['fecha_asignacion'] . '</h6>
                    <h6 class="card-text"><strong>Devolución: </strong>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</h6>';
        echo ' </div>
            </div>';
    }
}
