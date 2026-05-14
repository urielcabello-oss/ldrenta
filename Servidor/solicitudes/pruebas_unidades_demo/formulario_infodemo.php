<?php
include("../../conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

$id_usuario_pool = $_SESSION['id_colaborador'];

if (isset($_POST['id_info_unidad_demo'])) {
    $id_unidad = $_POST['id_info_unidad_demo'];
    $queryobtenerinfounidadasignacion = "SELECT u.id_unidad,
                                u.id_modelo,
                                u.id_estado_unidad,
                                u.id_estatus_unidad,
                                u.id_tipo_unidad,
                                u.id_tipo_adquisicion,
                                u.id_sede,
                                u.vin,
                                u.placa,
                                u.costo_neto,
                                u.id_color,
                                u.img_unidad,
                                u.fecha_adquisicion,
                                u.img_unidad,
                                unidcolor.id_color,
                                unidcolor.color_unidad,
                                marc.id_marca,
                                marc.nombre_marca,
                                mode.nombre_modelo,
                                estado.id_estado_unidad,
                                estado.estado,
                                estat.id_estatus_unidad,
                                estat.estatus,
                                tipunidad.id_tipo_unidad,
                                tipunidad.tipo_unidad,
                                sed.id_sede,
                                sed.ubicacion,
                                tipadquisicion.id_tipo_adquisicion,
                                tipadquisicion.nombre_tipo_adquisicion
                                FROM unidades AS u 
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
                                INNER JOIN unidad_color AS unidcolor
                                ON u.id_color = unidcolor.id_color
                                WHERE u.id_unidad = '$id_unidad'";

    $resultadoinfounidadasignacion = $conexion->query($queryobtenerinfounidadasignacion);
    if (mysqli_num_rows($resultadoinfounidadasignacion) > 0) {
        $data = mysqli_fetch_array($resultadoinfounidadasignacion);
        $id_marca_unidad = $data['id_marca']; // Obtener id_marca de la marca
        $id_modelo_unidad = $data['id_modelo']; // Obtener id_modelo de la marca
    }
    echo '<div class="row">
<div class="contenedorimgunidadasignacion">
    <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $data['img_unidad'] . '" onerror="this.src=\'../../Cliente/img/unidades/carro_desconocido.png\'" class="imgasignacionunidad" alt="..." >
</div>';
    echo '<input type="hidden" id="id_usuario_pool" name="id_usuario_pool" value="' . $id_usuario_pool . '">';
    // Mostrar los campos sin editar
    echo '<div class="row ">
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="marcaunidadldr" value="' . $data['nombre_marca'] . '" disabled>
                <label for="marcaunidadldr">Marca:</label>
            </div>
            <label class="" style="color: white;"> </label>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="modelounidadldr" value="' . $data['nombre_modelo'] . '" disabled>
                <label for="modelounidadldr">Modelo:</label>
            </div>
            <label class="" style="color: white;"> </label>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="placaunidadldr" value="' . $data['placa'] . '" disabled>
                <label for="placaunidadldr">Placa:</label>
            </div>
            <label class="" style="color: white;"> </label>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="vinunidadldr" value="' . $data['vin'] . '" disabled>
                <label for="vinunidadldr">VIN:</label>
            </div>
            <label class="" style="color: white;"> </label>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="colorunidadldr" value="' . $data['color_unidad'] . '" disabled>
                <label for="colorunidadldr">Color:</label>
            </div>
            <label class="" style="color: white;"> </label>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="tarjetacirculacionunidadesldr" value="' . $data['costo_neto'] . '" disabled>
                <label for="tarjetacirculacionunidadesldr">Costo neto:</label>
            </div>
            <label class="" style="color: white;"> </label>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="tipounidadldr" value="' . $data['tipo_unidad'] . '" disabled>
                <label for="tipounidadldr">Tipo de unidad:</label>
            </div>
            <label class="" style="color: white;"> </label>
        </div>
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control" id="sedeunidadldr" value="' . $data['ubicacion'] . '" disabled>
                <label for="sedeunidadldr">Sede de la unidad:</label>
            </div>
            <label class="" style="color: white;"> </label>
        </div>
        </div>
        </div>
        ';
}
