<?php
include("../../../conexion.php");
if (isset($_POST['idasignacion'])) {

    $idasignacion = $_POST['idasignacion'];

    //vamos a obtener los valores de la unidad modelos, marcas y adquisiciones
    $queryobtenerinfounidadasignacion = "SELECT u.id_unidad,
                                            u.id_modelo,
                                            u.id_sede,
                                            u.vin,
                                            u.numero_motor,
                                            u.placa,
                                            u.costo_neto,
                                            u.id_color,
                                            u.img_unidad,
                                            marc.id_marca,
                                            marc.nombre_marca,
                                            mode.nombre_modelo,
                                            tipoasig.id_tipo_asignaciones,
                                            sed.id_sede,
                                            sed.ubicacion,
                                            asigun.motivo_rechazo_comodato,
                                            unidcolor.id_color,
                                            unidcolor.color_unidad,
                                            asigun.archivo_comodato_sin_firmar
                                        FROM asignacion_unidad_colaborador AS asigun
                                        INNER JOIN unidades AS u
                                        ON asigun.id_unidad = u.id_unidad
                                        INNER JOIN modelos AS mode
                                        ON u.id_modelo = mode.id_modelo
                                        INNER JOIN marcas AS marc
                                        ON mode.id_marca = marc.id_marca
                                        INNER JOIN estatus_unidades AS estat
                                        INNER JOIN sedes AS sed
                                        ON u.id_sede = sed.id_sede
                                        INNER JOIN tipo_asignaciones AS tipoasig
                                        ON asigun.id_tipo_asignaciones = tipoasig.id_tipo_asignaciones
                                        INNER JOIN unidad_color AS unidcolor
                                        ON u.id_color = unidcolor.id_color
                                        WHERE asigun.id_asignaciones = '$idasignacion'";

    $resultadoinfounidadasignacion = $conexion->query($queryobtenerinfounidadasignacion);

    while ($fila = $resultadoinfounidadasignacion->fetch_assoc()) {
        $idunidad = $fila['id_unidad'];
        $idmarca = $fila['id_marca'];
        $idmodelo = $fila['id_modelo'];
        $vin = $fila['vin'];
        $numero_motor = $fila['numero_motor'];
        $placa = $fila['placa'];
        $tarjeta_circulacion = $fila['costo_neto'];
        $color = $fila['color_unidad'];
        $img_unidad = $fila['img_unidad'];
        $ubicacion = $fila['ubicacion'];
        $nombre_marca = $fila['nombre_marca'];
        $nombre_modelo = $fila['nombre_modelo'];
        $motivo_rechazo_comodato = $fila['motivo_rechazo_comodato'];
        $archivo_comodato_sin_firmar = $fila['archivo_comodato_sin_firmar'];
    }

    echo '<div class="row">
    <div class="col-6">
        <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $img_unidad . '" onerror="this.src=\'../../Cliente/img/unidades/carro_desconocido.png\'" class="card-img-top img-fluid imgcomodato" style="text-align: center"  alt="..." >
    </div>
    <div class="col-6">
        <h5 class="card-title"><strong>' . $nombre_modelo . ' ' . $nombre_marca . ' </strong></h5>
        <h6 class="card-text"><strong>Sede: </strong>' . $ubicacion . '</h6>
        <h6 class="card-text"><strong>VIN: </strong>' . $vin . '</h6>
        <h6 class="card-text"><strong>N° Motor: </strong>' . $numero_motor . '</h6>
        <h6 class="card-text"><strong>Placa: </strong>' . $placa . '</h6>
        <h6 class="card-text"><strong>Costo neto: </strong>' . $tarjeta_circulacion . '</h6>
        <h6 class="card-text"><strong>Color: </strong>' . $color . '</h6>';
        if (!empty($motivo_rechazo_comodato)) {
            echo '<h6 class="card-text"> <Strong>Motivo de rechazo:</Strong> <strong style="color: red;"> ' . $motivo_rechazo_comodato . '  </strong></h6>';
            
        }
        if (!empty($archivo_comodato_sin_firmar)) {
            echo '<h6 class="card-text"> <strong>Comodato:</strong> <a href="../../Servidor/archivos/files/files_unidades/comodato/' . $archivo_comodato_sin_firmar . '" class="btn btn-warning btn-sm" target="_blank"><i class="fas fa-eye"></i></a></h6>';
        }
        echo'
    </div>';
    
    echo '

    
    <div class="conetendorsubircartaresponsiva">
        <h3 for="archivo_comodato">Aquí debes subir el comodato:</h3>
        <input type="file" class="form-control archivo_subir_comodato" id="archivo_subir_comodato" name="archivo_subir_comodato" accept=".pdf">
    </div>
</div>';
}

?>