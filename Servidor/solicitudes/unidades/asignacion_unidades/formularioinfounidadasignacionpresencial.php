    <!--------------------------------------------------Mostrar unidad a asignar---------------------------------------------------->
    <?php
    include("../../../conexion.php");

    if (isset($_POST['idunidadasignar']) && isset($_POST['colaboradorasignacion']) && isset($_POST['idusuarioexterno'])) {

        $idunidadasignar = $_POST['idunidadasignar'];
        //aqui mandamos a llamar al colaborador del select, realizamos la consulta para obtener su nombre
        $colaboradorasignacion = $_POST['colaboradorasignacion'];
        $usuarioexterno = $_POST['idusuarioexterno'];

        if ($colaboradorasignacion) {
            $sqlobtenercolaborador = "SELECT * FROM colaboradores WHERE id_colaborador = '$colaboradorasignacion'";
            $ejecutarsqlobtenercolaborador = $conectar->query($sqlobtenercolaborador);
            $obtenercolaborador = $ejecutarsqlobtenercolaborador->fetch_assoc();

            echo '
            <h3 id="" value="' . $colaboradorasignacion . '">Unidad asignada a <b>' . $obtenercolaborador['nombre_1'] . ' ' . $obtenercolaborador['nombre_2'] . ' ' . $obtenercolaborador['apellido_paterno'] . ' ' . $obtenercolaborador['apellido_materno'] . '</b></h3>';
        } else {
            $sqlobtenerusuario = "SELECT * FROM usuarios_externos WHERE id_usuario_externo = '$usuarioexterno'";
            $ejecutarsqlobtenerusuario = $conectar->query($sqlobtenerusuario);
            $obtenerusuario = $ejecutarsqlobtenerusuario->fetch_assoc();

            echo '
            <h3 id="" value="' . $usuarioexterno . '">Unidad asignada a <b>' . $obtenerusuario['nombre_1'] . ' ' . $obtenerusuario['nombre_2'] . ' ' . $obtenerusuario['apellido_paterno'] . ' ' . $obtenerusuario['apellido_materno'] . '</b></h3>';
        }
        echo '<input type="hidden" id="colaboradorasignacion" value="' . $colaboradorasignacion . '">';
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
                                colorunid.color_unidad,
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
                                INNER JOIN unidad_color AS colorunid
                                ON u.id_color = colorunid.id_color
                                WHERE u.id_unidad = '$idunidadasignar'";

        $ejecutarobtenervalorunidad = $conectar->query($queryobtenerunidadasignar);
        if (mysqli_num_rows($ejecutarobtenervalorunidad) > 0) {
            $data = mysqli_fetch_array($ejecutarobtenervalorunidad);
            $id_marca_unidad = $data['id_marca']; // Obtener id_marca de la marca
            $id_modelo_unidad = $data['id_modelo']; // Obtener id_modelo de la marca
        }
        echo '<div class="row">
        
    <div class="contenedorimgunidadasignacion">
        <div>
            <h3><b>' . $data['nombre_marca'] . '</b></h3>
            <h5>' . $data['nombre_modelo'] . '</h5>
        </div>
        <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $data['img_unidad'] . '" class="imgasignacionunidad" onerror="this.src=\'../../../Cliente/img/unidades/carro_desconocido.png\'" alt="..." >
    </div>';
        // Mostrar los campos sin editar
        echo '<div class="row ">
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="vinunidadldr" value="' . $data['vin'] . '" disabled>
                    <label for="vinunidadldr">VIN:</label>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="placaunidadldr" value="' . $data['placa'] . '" disabled>
                    <label for="placaunidadldr">Placa:</label>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="colorunidadldr" value="' . $data['color_unidad'] . '" disabled>
                    <label for="colorunidadldr">Color:</label>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="tarjetacirculacionunidadesldr" value="' . $data['costo_neto'] . '" disabled>
                    <label for="tarjetacirculacionunidadesldr">Costo neto:</label>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="estadounidadldr" value="' . $data['estado'] . '" disabled>
                    <label for="estadounidadldr">Estado:</label>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="tipounidadldr" value="' . $data['tipo_unidad'] . '" disabled>
                    <label for="tipounidadldr">Tipo de unidad:</label>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="sedeunidadldr" value="' . $data['ubicacion'] . '" disabled>
                    <label for="sedeunidadldr">Sede:</label>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">                                                                          
                    <input type="text" class="form-control" id="tipoadquisicionunidadldr" value="' . $data['nombre_tipo_adquisicion'] . '" disabled>
                    <label for="tipoadquisicionunidadldr">Tipo de adquisición:</label>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <button type="button" class="btn btn-warning btncheklistunidad" data-id="' . $idunidadasignar . '" data-idcolaborador="' . $colaboradorasignacion . '" id="btncheklistunidad">Checklist</button>
                </div>
            </div>
            
        </div>';
    }
        
    ?>