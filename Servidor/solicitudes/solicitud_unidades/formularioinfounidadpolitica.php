<?php
include("../../conexion.php");
if (isset($_POST['idasignacion'])) {

    $idasignacion = $_POST['idasignacion'];

    //vamos a obtener los valores de la unidad modelos, marcas y adquisiciones
    $queryobtenerinfounidadasignacion = "SELECT u.id_unidad,
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
                                            u.id_tipo_unidad,
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
                                            asigun.archivo_responsiva_sin_asignar
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

    $resultadoinfounidadasignacion = $conexion->query($queryobtenerinfounidadasignacion);

    while ($fila = $resultadoinfounidadasignacion->fetch_assoc()) {
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
        $archivo_responsiva_sin_asignar = $fila['archivo_responsiva_sin_asignar'];
    }

    $archivo_lineamientos_sin_firmar = "../../Servidor/archivos/files/file_politica_prestamos_unidades/Politica de asignacion de vehiculos LDR 2024.pdf";

    echo '<div class="row">
    <div class="col-3">
        <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $img_unidad . '" class="card-img-top img-fluid imgcard" onerror="this.src=\'../../../Cliente/img/unidades/carro_desconocido.png\'" alt="..." >
    </div>
    <div class="col-3">
        <h5 class="card-title"><strong>' . $nombre_modelo . ' ' . $nombre_marca . '</strong></h5>
        <h6 class="card-text">Fecha de asignación: ' . $fecha_asignacion . '</h6>
        <h6 class="card-text">Tipo de unidad: ' . $tipo_unidad . '</h6>
        <h6 class="card-text">Sede: ' . $ubicacion . '</h6>
        <h6 class="card-text">VIN: ' . $vin . '</h6>
        <h6 class="card-text">N° Motor: ' . $numero_motor . '</h6>
        <h6 class="card-text">Placa: ' . $placa . '</h6>
        <h6 class="card-text">Tarjeta de circulación: ' . $tarjeta_circulacion . '</h6>
        <h6 class="card-text">Color: ' . $color . '</h6>
    </div>
    
    <div class="col-6">';
    if ($idtipounidad == 1) {
        if (!empty($archivo_lineamientos_sin_firmar)) {
            echo '<p class="card-text">Descarga el archivo de la responsiva:
            <a href="' . $archivo_lineamientos_sin_firmar . '" target="_blank" class="btn btn-warning">Abrir</a>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="' . $archivo_lineamientos_sin_firmar . '#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" style="width:100%;height:500px;"></iframe>
            </div>
          </p>';
        }
    } else if ($idtipounidad == 2) {
        if (!empty($archivo_responsiva_sin_asignar)) {
            echo '<p class="card-text">Descarga el archivo de la responsiva:
            <a href="../../Servidor/archivos/files/files_unidades/responsiva_sin_asignar/' . $archivo_responsiva_sin_asignar . '" target="_blank" class="btn btn-warning">Abrir</a>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="../../Servidor/archivos/files/files_unidades/responsiva_sin_asignar/' . $archivo_responsiva_sin_asignar . '#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" style="width:100%;height:500px;"></iframe>
            </div>
          </p>';
        }
    }

    echo '</div>

    <div class="row">
    <div class="conetendorsubircartaresponsiva">
        <h3 for="archivo_responsiva_sin_asignar">Aquí debes subir tu carta responsiva firmada:</h3>
        <input type="file" class="form-control archivo_responsiva_sin_asignar" id="archivo_responsiva_sin_asignar" name="archivo_responsiva_sin_asignar" accept=".pdf">
    </div>
    </div>
</div>';
}
