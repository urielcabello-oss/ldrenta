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
            unid.id_tipo_unidad,
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
    if ($fila['id_estatus_comodato'] != 4) {
    echo "<div class='card'>";
    if ($fila['id_tipo_unidad'] == 1) {
        echo "<div class='alerta'>
                <img src='../../Cliente/videos/atención.gif' alt='...'>
                Espera el cominicado para que firmes de manera presencial 
                </div>";
    }
        if ($fila['id_tipo_unidad'] != 1) {
            if ($fila['id_estatus_carta_responsiva'] == 2) {
                echo "<div class='alerta'>
                <img src='../../Cliente/videos/succes-green.gif' alt='...'> 
                Responsiva: " . $fila['estatus_responsiva'] . "
                </div>";
            } else if ($fila['id_estatus_carta_responsiva'] == 3) {
                echo "<div class='alerta'>
                <img src='../../Cliente/videos/warning-red.gif' alt='...'> 
                Responsiva: " . $fila['estatus_responsiva'] . "
                </div>";
            } else if ($fila['id_estatus_carta_responsiva'] == 4) {
                echo "<div class='alerta'>
                <img src='../../Cliente/videos/actualizar.gif' alt='...'> 
                Responsiva: " . $fila['estatus_responsiva'] . "
                </div>";
            }
        }
    echo '
            <div class="cardheader">
                <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" onerror="this.src=\'../../Cliente/img/unidades/carro_desconocido.png\'" class="card-img-top img-fluid imgcard" alt="..." >
            </div>
            <div class="card-body mt-3">
            <h5 class="card-title"><b>' . $fila['nombre_modelo'] . '</b></h5>
                <h6 class="card-text"><b>Placa: </b>' . $fila['placa'] . '</h6>
                <h6 class="card-text"><b>Asignación: </b>' . $fila['fecha_asignacion'] . '</h6>
                <h6 class="card-text"><b>Devolución: </b>' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</h6>';
                if ($fila['id_tipo_unidad'] == 2) {
                    echo '<a class="linkcheckpolitica" href="../../Servidor/archivos/files/file_politica_prestamos_unidades/Lineamientos Préstamo de Vehículo Pull - LDR.pdf" target="_blank">Ver lineamientos de préstamos de vehículos</a>';
                }
                if ($fila['id_tipo_unidad'] == 2) {
                    echo '<div class="form-check">
                    <input class="form-check-input checkpolitica" type="checkbox" value="chekpoliticaunidades" id="checkpolitica" data-id="' . $fila['id_asignaciones'] . '"';
                    if ($fila['politica_aceptada'] == 'ACEPTADA') {
                        echo ' checked ';
                    }
                    echo '>
                    <label class="form-check-label" for="chekpoliticaunidades">
                    Acepto los lineamientos de préstamos de vehículos
                    </label>
                    </div>';
                }
                
    if ($fila['id_estatus_carta_responsiva'] == 2 || $fila['id_tipo_unidad'] == 1) {
        echo '<button type="button" data-idunidad="' . $fila['id_unidad'] . '" data-id="' . $fila['id_asignaciones'] . '"  id="btnpoliticaunidades'.$fila['id_asignaciones'].'" class="btn btn-primary mt-3 d-none">Ver detalles de la unidad</button>';
        echo '<button type="button" data-idunidad="' . $fila['id_unidad'] . '" data-id="' . $fila['id_asignaciones'] . '"  id="btnsubircomodato'.$fila['id_asignaciones'].'" class="btn btn-primary mt-3 btnsubircomodato">Ver detalles de la unidad</button>';
    } else {
        if ($fila['politica_aceptada'] != 'ACEPTADA') {
            echo '<button type="button" data-idunidad="' . $fila['id_unidad'] . '" data-id="' . $fila['id_asignaciones'] . '"  id="btnpoliticaunidades'.$fila['id_asignaciones'].'" class="btn btn-primary mt-3 btnmosrarmodalunidadsolicitud" disabled>Subir carta responsiva</button>';
        } else {
            echo '<button type="button" data-idunidad="' . $fila['id_unidad'] . '" data-id="' . $fila['id_asignaciones'] . '"  id="btnpoliticaunidades'.$fila['id_asignaciones'].'" class="btn btn-primary mt-3 btnmosrarmodalunidadsolicitud">Subir carta respnisva</button>';
        }
    }
    echo ' </div>
        </div>';
}
}
