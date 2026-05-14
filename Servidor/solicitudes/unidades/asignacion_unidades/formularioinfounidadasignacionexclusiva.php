<!--------------------------------------------------Mostrar unidad a asignar---------------------------------------------------->
<?php
include("../../../conexion.php");


if (isset($_POST['idunidadasignar']) && isset($_POST['colaboradorasignacion']) && isset($_POST['idexterno'])) {

    $idunidadasignar = $_POST['idunidadasignar'];
    //aqui mandamos a llamar al colaborador del select, realizamos la consulta para obtener su nombre
    $colaboradorasignacion = $_POST['colaboradorasignacion'];
    $idexterno = $_POST['idexterno'];


    if (isset($_POST['idexterno']) && $_POST['idexterno'] != "") {
        $idexterno = $_POST['idexterno'];
        $sqlobtenercolaborador = "SELECT * FROM usuarios_externos WHERE id_usuario_externo = '$idexterno'";
    } else {
        $sqlobtenercolaborador = "SELECT * FROM colaboradores WHERE id_colaborador = '$colaboradorasignacion'";
    }
    $ejecutarsqlobtenercolaborador = $conectar->query($sqlobtenercolaborador);
    $obtenercolaborador = $ejecutarsqlobtenercolaborador->fetch_assoc();

    echo '
        <h3 id="" value="' . $colaboradorasignacion . '">Deseas asignar la siguiente unidad a ' . $obtenercolaborador['nombre_1'] . ' ' . $obtenercolaborador['nombre_2'] . ' ' . $obtenercolaborador['apellido_paterno'] . ' ' . $obtenercolaborador['apellido_materno'] . '?</h3>';
    echo '<input type="hidden" id="colaboradorasignacion" value="' . $colaboradorasignacion . '">';
    echo '<input type="hidden" id="idexterno" value="' . $idexterno . '">';
    echo '<input type="hidden" id="idunidadasignar" value="' . $idunidadasignar . '">';


    //vamos a obtener los valores de la unidad modelos, marcas y adquisiciones
    $queryobtenerunidadasignar = "SELECT u.id_unidad,
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
                                unidcolor.id_color,
                                unidcolor.color_unidad,
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
                                WHERE u.id_unidad = '$idunidadasignar'";

    $ejecutarobtenervalorunidad = $conectar->query($queryobtenerunidadasignar);
    if (mysqli_num_rows($ejecutarobtenervalorunidad) > 0) {
        $data = mysqli_fetch_array($ejecutarobtenervalorunidad);
        $id_marca_unidad = $data['id_marca']; // Obtener id_marca de la marca
        $id_modelo_unidad = $data['id_modelo']; // Obtener id_modelo de la marca
    }
    echo '<div class="row">
    <div class="contenedorimgunidadasignacion">
        <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $data['img_unidad'] . '" onerror="this.src=\'../../../Cliente/img/unidades/carro_desconocido.png\'" class="imgasignacionunidad" alt="...">
    </div>';
    // Mostrar los campos sin editar
    echo '<div class="row ">
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="marcaunidadldr" value="' . $data['nombre_marca'] . '" disabled>
                    <label for="marcaunidadldr">Marca:</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="modelounidadldr" value="' . $data['nombre_modelo'] . '" disabled>
                    <label for="modelounidadldr">Modelo:</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="vinunidadldr" value="' . $data['vin'] . '" disabled>
                    <label for="vinunidadldr">VIN:</label>
                </div>
            </div>
            </div>
            <div class="row contenedorinfounidadasignar">
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="placaunidadldr" value="' . $data['placa'] . '" disabled>
                    <label for="placaunidadldr">Placa:</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="colorunidadldr" value="' . $data['color_unidad'] . '" disabled>
                    <label for="colorunidadldr">Color:</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="tarjetacirculacionunidadesldr" value="' . $data['costo_neto'] . '" disabled>
                    <label for="tarjetacirculacionunidadesldr">Costo neto:</label>
                </div>
            </div>
            </div>
            <div class="row contenedorinfounidadasignar">
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="estadounidadldr" value="' . $data['estado'] . '" disabled>
                    <label for="estadounidadldr">Estado de la unidad:</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="estatusunidadldr" value="' . $data['estatus'] . '" disabled>
                    <label for="estatusunidadldr">Estatus de la unidad:</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="tipounidadldr" value="' . $data['tipo_unidad'] . '" disabled>
                    <label for="tipounidadldr">Tipo de unidad:</label>
                </div>
            </div>
            </div>
            <div class="row contenedorinfounidadasignar">
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" class="form-control" id="sedeunidadldr" value="' . $data['ubicacion'] . '" disabled>
                    <label for="sedeunidadldr">Sede de la unidad:</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="date" class="form-control" id="fechaadquisicionunidadldr" value="' . ($data['fecha_adquisicion'] !== '0000-00-00' ? $data['fecha_adquisicion'] : '') . '" disabled>
                    <label for="fechaadquisicionunidadldr">Fecha de adquisición de la unidad:</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">                                                                          
                    <input type="text" class="form-control" id="tipoadquisicionunidadldr" value="' . $data['nombre_tipo_adquisicion'] . '" disabled>
                    <label for="tipoadquisicionunidadldr">Tipo de adquisición de la unidad:</label>
                </div>
            </div>
            </div>
            <div class="row contenedorinfounidadasignar">
            </div>
        </div>
        </div>';
}


// Realizar la consulta para  seleccionar el tipo de asignación de la unidad
$sqltipoadquisicionunidad = "SELECT id_tipo_asignaciones, nombre_tipo_asignacion FROM tipo_asignaciones";
$result = $conectar->query($sqltipoadquisicionunidad);

echo '
    <h3 style="padding-top: 40px;">Asignación de la unidad</h3>
    <div class="row contenedorinfounidadasignar">
    <div class="col-md-4">
        <div class="form-floating">
            <select class="form-control" id="tipoasignacionunidad" placeholder="tipoasignacionunidad" name="tipoasignacionunidad">
                <option value="" selected>Seleccione un tipo de asignación</option>'; // Opción predeterminada

while ($rowtipoadquisicionunidad = $result->fetch_assoc()) {
    // Mostrar cada estado como una opción
    $selected = ($data['id_tipo_asignacion'] == $rowtipoadquisicionunidad['id_tipo_asignaciones']) ? 'selected' : '';
    echo '<option value="' . $rowtipoadquisicionunidad['id_tipo_asignaciones'] . '" ' . $selected . '>' . $rowtipoadquisicionunidad['nombre_tipo_asignacion'] . '</option>';
}

echo '</select>
        <label for="tipoasignacionunidadldr">Tipo de asignación de la unidad:</label>
    </div>
    <label class="" style="color: white;">*Campo obligatorio</label>
</div>';
?>

<!-- Campo adicional para el tipo de asignación -->
<div class="col-md-4" id="asignacionfechaasignacion">
    <div class="form-floating">
        <input type="date" class="form-control" id="fechasignacion" name="fechasignacion" placeholder="asignacion">
        <label for="detalleadquisicion">Fecha de asignación</label>
    </div>
</div>
<!-- Campo adicional para el tipo de asignación -->
<div class="col-md-4" id="asignacionfechadevolucion" style="display: none;">
    <div class="form-floating">
        <input type="date" class="form-control" id="fechadevolucion" name="fechadevolucion" placeholder="devolución">
        <label for="detalleadquisicion">Fecha de término</label>
    </div>
</div>