<?php
include("../../conexion.php");
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
                                            u.kilometraje,
                                            u.placa,
                                            u.costo_neto,
                                            u.color,
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
        $kilometraje = $fila['kilometraje'];
        $placa = $fila['placa'];
        $tarjeta_circulacion = $fila['costo_neto'];
        $color = $fila['color'];
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
    <div class="col">
        <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $img_unidad . '" class="card-img-top img-fluid " alt="..." >
    </div>
    <div class="col">
        <h5 class="card-title">' . $nombre_modelo . ' ' . $nombre_marca . '</h5>
        <h6 class="card-text">Fecha de asignación: ' . $fecha_asignacion . '</h6>
        <h6 class="card-text">Tipo de unidad: ' . $tipo_unidad . '</h6>
        <h6 class="card-text">Sede: ' . $ubicacion . '</h6>
        <h6 class="card-text">VIN: ' . $vin . '</h6>
        <h6 class="card-text">N° Motor: ' . $numero_motor . '</h6>
        <h6 class="card-text">Kilometraje: ' . $kilometraje . '</h6>
        <h6 class="card-text">Placa: ' . $placa . '</h6>
        <h6 class="card-text">Costo neto: ' . $tarjeta_circulacion . '</h6>
        <h6 class="card-text">Color: ' . $color . '</p>
    </div>
</div>';

}

?>