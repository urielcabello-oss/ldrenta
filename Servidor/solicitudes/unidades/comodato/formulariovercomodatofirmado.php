<?php
include("../../../conexion.php");
if (isset($_POST['idasignacion'])) {

    $idasignacion = $_POST['idasignacion'];

    //vamos a obtener los valores de la unidad modelos, marcas y adquisiciones
    $queryobtenerinfounidadcartaresponsiva = "SELECT u.id_unidad,
                                            u.id_modelo,
                                            u.id_estado_unidad,
                                            u.id_estatus_unidad,
                                            u.id_tipo_unidad,
                                            u.id_tipo_adquisicion,
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
                                            estado.id_estado_unidad,
                                            estado.estado,
                                            estat.id_estatus_unidad,
                                            estat.estatus,
                                            tipunidad.id_tipo_unidad,
                                            tipunidad.tipo_unidad,
                                            tipoasig.id_tipo_asignaciones,
                                            sed.id_sede,
                                            sed.ubicacion,
                                            tipadquisicion.id_tipo_adquisicion,
                                            tipadquisicion.nombre_tipo_adquisicion,
                                            asigun.fecha_asignacion,
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
                                        INNER JOIN estado_unidad AS estado
                                        ON u.id_estado_unidad = estado.id_estado_unidad
                                        INNER JOIN estatus_unidades AS estat
                                        ON u.id_estatus_unidad = estat.id_estatus_unidad
                                        INNER JOIN tipo_unidad AS tipunidad
                                        ON u.id_tipo_unidad = tipunidad.id_tipo_unidad
                                        INNER JOIN sedes AS sed
                                        ON u.id_sede = sed.id_sede
                                        INNER JOIN tipo_adquisicion AS tipadquisicion
                                        ON u.id_tipo_adquisicion = tipadquisicion.id_tipo_adquisicion
                                        INNER JOIN tipo_asignaciones AS tipoasig
                                        ON asigun.id_tipo_asignaciones = tipoasig.id_tipo_asignaciones
                                        INNER JOIN unidad_color AS unidcolor
                                        ON u.id_color = unidcolor.id_color
                                        WHERE asigun.id_asignaciones = '$idasignacion'";

    $resultadoinfounidadcartaresponsiva = $conexion->query($queryobtenerinfounidadcartaresponsiva);

    while ($fila = $resultadoinfounidadcartaresponsiva->fetch_assoc()) {
        $idunidad = $fila['id_unidad'];
        $idmarca = $fila['id_marca'];
        $idmodelo = $fila['id_modelo'];
        $idestadounidad = $fila['id_estado_unidad'];
        $idestatusunidad = $fila['id_estatus_unidad'];
        $idtipounidad = $fila['id_tipo_unidad'];
        $idtipoadquisicion = $fila['id_tipo_adquisicion'];
        $idsede = $fila['id_sede'];
        $vin = $fila['vin'];
        $numero_motor = $fila['numero_motor'];
        $placa = $fila['placa'];
        $tarjeta_circulacion = $fila['costo_neto'];
        $color = $fila['color_unidad'];
        $img_unidad = $fila['img_unidad'];
        $ubicacion = $fila['ubicacion'];
        $nombre_marca = $fila['nombre_marca'];
        $nombre_modelo = $fila['nombre_modelo'];
        $estado = $fila['estado'];
        $estatus = $fila['estatus'];
        $tipo_unidad = $fila['tipo_unidad'];
        $nombre_tipo_adquisicion = $fila['nombre_tipo_adquisicion'];
        $fecha_asignacion = $fila['fecha_asignacion'];
        $archivo_comodato_sin_firmar = $fila['archivo_comodato_sin_firmar'];
    }

    echo '<div class="row">
    <div class="col-6">
        <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $img_unidad . '" class="card-img-top img-fluid imgcardverificarcomodato" onerror="this.src=\'../../../Cliente/img/unidades/carro_desconocido.png\'" alt="..." >
        </div>
    <div class="col-6">
        <div class="card-body ">
        <h5 class="card-title"><strong>' . $nombre_modelo . ' ' . $nombre_marca . '</strong></h5>
        <h6 class="card-text"><strong>Fecha de asignación: </strong>' . $fecha_asignacion . '</h6>
        <h6 class="card-text"><strong>Tipo de unidad: </strong>' . $tipo_unidad . '</h6>
        <h6 class="card-text"><strong>Sede: </strong>' . $ubicacion . '</h6>
        <h6 class="card-text"><strong>VIN: </strong>' . $vin . '</h6>
        <h6 class="card-text"><strong>N° Motor: </strong>' . $numero_motor . '</h6>
        <h6 class="card-text"><strong>Placa: </strong>' . $placa . '</h6>
        <h6 class="card-text"><strong>Costo neto: </strong>' . $tarjeta_circulacion . '</h6>
        <h6 class="card-text"><strong>Color: </strong>' . $color . '</h6>
        </div>
    </div>
    
    <div class="col archivocomodato">';
    if (!empty($archivo_comodato_sin_firmar)) {
        echo '<p class="card-text" style="color: rgb(61, 65, 62);"><strong>Descarga el comodato, reunete con el usuario para que realize la firma y subelo.</strong>
        <a href="../../Servidor/archivos/files/files_unidades/comodato/' . $archivo_comodato_sin_firmar . '" target="_blank" class="btn btn-warning">Abrir</a>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="../../Servidor/archivos/files/files_unidades/comodato/' . $archivo_comodato_sin_firmar . '#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" style="width:100%;height:400px;"></iframe>
        </div>
      </p>
      
      <h6 style="text-align: right; color: red;"><strong>Si el comodato no es el correcto, deniegalo.</strong></h6>
      <h6 style="text-align: right; color:rgb(85, 94, 87);"><strong>Si el comodato es correcto, notifica al usuario para que asista a la firma del contrato.</strong></h6>

      ';
    }

    echo '</div>

    <div class="row">
    <div class="conetendorsubircartaresponsiva">
        <h3 for="comodato_archivo_sin_firmar">Aquí debes subir el comodato firmado:</h3>
        <input type="file" class="form-control comodato_archivo_sin_firmar" id="comodato_archivo_sin_firmar" name="comodato_archivo_sin_firmar" accept=".pdf">
    </div>
    </div>
</div>';
}

?>