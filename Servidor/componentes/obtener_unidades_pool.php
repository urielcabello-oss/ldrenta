<?php

include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}

$id_usuario = $_SESSION['id_colaborador'];

//query para obtener el id de las unidades asignadas del lado admin

$sqlobtenerunidadpooldisponible = "SELECT ung.id_unidad,
                                    marc.nombre_marca,  
                                    model.nombre_modelo,
                                    ung.placa,
                                    ung.img_unidad,
                                    ung.id_tipo_unidad,
                                    unest.estado,
                                    unestatus.id_estatus_unidad,
                                    sed.ubicacion
                                FROM unidades AS ung
                                INNER JOIN modelos AS model 
                                ON ung.id_modelo = model.id_modelo 
                                INNER JOIN marcas AS marc 
                                ON model.id_marca = marc.id_marca  
                                INNER JOIN estado_unidad AS unest 
                                ON ung.id_estado_unidad = unest.id_estado_unidad
                                INNER JOIN estatus_unidades AS unestatus
                                ON ung.id_estatus_unidad = unestatus.id_estatus_unidad
                                INNER JOIN sedes AS sed 
                                ON ung.id_sede = sed.id_sede
                                WHERE ung.id_estado_unidad = 1
                                AND ung.id_estatus_unidad = 1
                                AND ung.id_tipo_unidad = 2";

$resultado = $conexion->query($sqlobtenerunidadpooldisponible);


while ($fila = $resultado->fetch_assoc()) {


    echo '<div class="card">
            <div class="cardheader">
                <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" class="imgcard" alt="..." >
            </div>
            <div class="card-body mt-3">
                <h5 class="card-title"><b>' . $fila['nombre_marca'] . '</b></h5>
                <h5 class="card-title"><b>' . $fila['nombre_modelo'] . '</b></h5>
                <br>
                <h6 class="card-text"><b>Placa: </b>' . $fila['placa'] . '</h6>
                <h6 class="card-text"><b>Ubicación: </b>' . $fila['ubicacion'] . '</h6>
                <button type="button" id="btnmostrarunidadpool" data-id="' . $fila['id_unidad'] . '"  class="btn btn-primary  btnmostrarunidadpool">Solicitar</button>
     </div>
        </div>';
}
