<div class="row">
    <!--------------------------------------------------Edicion de unidades---------------------------------------------------->
    <?php
    include("../../conexion.php");


    //obtenemos los datos del colaborador para saber quien es el que agrega la unidad
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_tipo_usuario']) || !isset($_SESSION['id_modulo'])) {
    echo "Sesión inválida";
    exit;
}

$id_tipo_usuario = $_SESSION['id_tipo_usuario'];
$id_modulo = $_SESSION['id_modulo'];





    //comienza la obtencion de la unidad mediante el post del js 
    if (isset($_POST['idunidad'])) {
        $idunidad = $_POST['idunidad'];

        //vamos a obtener los valores de la unidad modelos y marcas
        $queryobtenerunidad = "SELECT u.id_unidad,
                                u.id_modelo,
                                u.id_estado_unidad,
                                u.id_estatus_unidad,
                                u.id_tipo_unidad,
                                u.id_tipo_adquisicion,
                                u.id_sede,
                                u.id_tipo_combustible,
                                u.id_traccion,
                                u.id_tipo_caja,
                                u.id_tipo_freno,
                                u.id_tipo_suspencion,
                                u.id_tipo_uso,
                                u.vin,
                                u.numero_motor,
                                u.placa,
                                u.folio_factura,
                                u.costo_neto,
                                u.id_color,
                                u.img_unidad,
                                u.fecha_adquisicion,
                                u.año_unidad,
                                u.id_arrendadora,
                                u.capacidad_carga,
                                u.capacidad_pasajeros,
                                marc.id_marca,
                                color.color_unidad,
                                arren.arrendadora,
                                comb.combustible,
                                tr.traccion,
                                u.tipo_carrceria,
                                u.numero_puertas,
                                u.numero_asientos,
                                tc.tipo_caja,
                                tf.tipo_freno,
                                ts.tipo_suspencion,
                                u.numero_ejes,
                                tu.tipo_uso
                                FROM unidades AS u 
                                INNER JOIN modelos AS mode
                                ON u.id_modelo = mode.id_modelo
                                INNER JOIN marcas AS marc
                                ON mode.id_marca = marc.id_marca
                                INNER JOIN unidad_color AS color
                                ON u.id_color = color.id_color
                                INNER JOIN arrendadora AS arren
                                ON u.id_arrendadora = arren.id_arrendadora
                                INNER JOIN tipos_combustibles as comb
                                ON u.id_tipo_combustible = comb.id_tipo_combustible
                                INNER JOIN tracciones AS tr
                                ON u.id_traccion = tr.id_traccion
                                INNER JOIN tipos_cajas AS tc
                                ON u.id_tipo_caja = tc.id_tipo_caja
                                INNER JOIN tipos_frenos AS tf    
                                ON u.id_tipo_freno = tf.id_tipo_freno
                                INNER JOIN tipos_suspenciones AS ts
                                ON u.id_tipo_suspencion = ts.id_tipo_suspencion
                                INNER JOIN tipos_usos AS tu
                                ON u.id_tipo_uso = tu.id_tipo_uso
                                WHERE u.id_unidad = '$idunidad'";

        $ejecutarobtenervalorunidad = $conectar->query($queryobtenerunidad);
        if (mysqli_num_rows($ejecutarobtenervalorunidad) > 0) {
            $data = mysqli_fetch_array($ejecutarobtenervalorunidad);
            $id_marca_unidad = $data['id_marca']; // Obtener id_marca de la marca
            $id_modelo_unidad = $data['id_modelo']; // Obtener id_modelo de la marca
        }

        echo '<div class="row">
    <div class="contenedorimgunidadasignacion">
        <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $data['img_unidad'] . '" onerror="this.src=\'../../Cliente/img/unidades/carro_desconocido.png\'" class="card-img-top img-fluid imgasignacionunidad" style="text-align: center"  alt="..." >
    </div>';
    
        //---------------------------------------------------------------editar marca------------------------------------------------
        // Realizar la consulta para obtener las marcas
        $sql = "SELECT id_marca, nombre_marca FROM marcas";
        $result = $conectar->query($sql);
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Recorrer los resultados y mostrar las opciones
            echo '<h3>Marca y modelo</h3>
            <div class="col-md-6">
        <div class="form-floating">
            <select class="form-control" id="marcaeditarunidad" placeholder="marcaeditarunidad" name="marcaeditarunidad">
                <option value="">Seleccione una marca</option>'; // Opción predeterminada

            while ($row = $result->fetch_assoc()) {
                // Mostrar cada marca como una opción
                $selected = ($row['id_marca'] == $id_marca_unidad) ? 'selected' : '';
                echo '<option value="' . $row['id_marca'] . '" ' . $selected . '>' . $row['nombre_marca'] . '</option>';
            }

            echo '</select>
        <label for="marcaunidadldr">Marca</label>
    </div>
    <label class="" style="color: white;">*Campo obligatorio</label>
</div>';
            //---------------------------------------------------------------editar modelo------------------------------------------------
            
            // Realizar la consulta para obtener los modelos
            $sqlmodelos = "SELECT id_modelo, nombre_modelo FROM modelos";
            $result = $conectar->query($sqlmodelos);
            echo '<div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="modeloeditarunidad" placeholder="modeloeditarunidad" name="modeloeditarunidad">
                    <option value="">Seleccione un modelo</option>'; // Opción predeterminada
            while ($rowmodelos = $result->fetch_assoc()) {
                // Mostrar cada marca como una opción
                $selected = ($rowmodelos['id_modelo'] == $id_modelo_unidad) ? 'selected' : '';
                echo '<option value="' . $rowmodelos['id_modelo'] . '" ' . $selected . '>' . $rowmodelos['nombre_modelo'] . '</option>';
            }

            echo '</select>
            <label for="modelounidadldr">Modelo</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    </div>';


            //---------------------------------------------------------------editar costo neto------------------------------------------------
            echo '<div class="row">
            <h3>Datos generales</h3>
            <div class="col-md-6">
            <div class="form-floating">
                <input type="number" class="form-control" id="editarTarjetaCirculacion" placeholder="editarTarjetaCirculacion" name="editarTarjetaCirculacion" value="' . $data['costo_neto'] . '" oninput="document.getElementById(\'CostoNetoEditar\').innerText = this.value ? parseFloat(this.value).toLocaleString(\'es-MX\', { style: \'currency\', currency: \'MXN\' }) + \' MXN\' : \'\';">
                <label for="tarjetacirculacionunidadesldr">Costo neto</label>
            </div>
            <label id="CostoNetoEditar" style="color: black;">' . ($data['costo_neto'] ? number_format($data['costo_neto'], 2, '.', ',') . ' MXN' : '') . '</label>
        </div>';
                //---------------------------------------------------------------editar color------------------------------------------------
            // Realizar la consulta para obtener el estado de la unidad
            $sqlcolorunidad = "SELECT id_color, color_unidad FROM unidad_color";
            $result = $conectar->query($sqlcolorunidad);
            echo '<div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarColor" placeholder="editarColor" name="editarColor">
                    <option value="">Seleccione un estado</option>'; // Opción predeterminada

            while ($rowcolorunidad = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_color'] == $rowcolorunidad['id_color']) ? 'selected' : '';
                echo '<option value="' . $rowcolorunidad['id_color'] . '" ' . $selected . '>' . $rowcolorunidad['color_unidad'] . '</option>';
            }
            echo '</select>
            <label for="estadounidadldr">Color</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';

        echo'
        <!-----------------------------------------------------------------------editar placa-------------------------------------->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="editarPlaca" placeholder="editarPlaca" name="editarPlaca" value="' . $data['placa'] . '">
                <label for="kilometrajeunidadldr">Placa</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>
        <!---------------------------------------------------------------editar vin------------------------------------------->
        <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="editarVIN" placeholder="editarVIN" name="editarVIN" value="' . $data['vin'] . '">
            <label for="vinunidadldr">VIN</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
            
            <!-----------------------------------------------------------------editar numero de motor-------------------------------------------------->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="editarNumeroMotor" placeholder="editarNumeroMotor" name="editarNumeroMotor" value="' . $data['numero_motor'] . '">
                <label for="colorunidadldr">Número de motor</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>
                <!---------------------------------------------------------------editar año------------------------------------------------>
    <div class="col-md-6">
            <div class="form-floating">
                <input type="number" class="form-control" id="editarañounidad" placeholder="editarañounidad" name="editarañounidad" value="' . $data['año_unidad'] . '">
                <label for="tarjetacirculacionunidadesldr">Año de la unidad</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>
        </div>
        <div class="row">';


            //---------------------------------------------------------------editar estado de la unidad------------------------------------------------
            // Realizar la consulta para obtener el estado de la unidad
            $sqlestadounidad = "SELECT id_estado_unidad, estado FROM estado_unidad";
            $result = $conectar->query($sqlestadounidad);
            echo '
            <h3>Estado y estatus</h3>
            <div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarEstadoUnidad" placeholder="editarEstadoUnidad" name="editarEstadoUnidad">
                    <option value="">Seleccione un estado</option>'; // Opción predeterminada

            while ($rowestadounidad = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_estado_unidad'] == $rowestadounidad['id_estado_unidad']) ? 'selected' : '';
                echo '<option value="' . $rowestadounidad['id_estado_unidad'] . '" ' . $selected . '>' . $rowestadounidad['estado'] . '</option>';
            }
            echo '</select>
            <label for="estadounidadldr">Estado de la unidad</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';

        //---------------------------------------------------------------editar estatus de la unidad------------------------------------------------
            // Realizar la consulta para obtener el estatus de la unidad
            $sqlestadounidad = "SELECT id_estatus_unidad, estatus FROM estatus_unidades";
            $result = $conectar->query($sqlestadounidad);
            echo '<div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarEstatusUnidad" placeholder="editarEstatusUnidad" name="editarEstatusUnidad">
                    <option value="">Seleccione un estatus</option>'; // Opción predeterminada

            while ($rowestatusunidad = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_estatus_unidad'] == $rowestatusunidad['id_estatus_unidad']) ? 'selected' : '';
                echo '<option value="' . $rowestatusunidad['id_estatus_unidad'] . '" ' . $selected . '>' . $rowestatusunidad['estatus'] . '</option>';
            }
            echo '</select>
            <label for="estatusunidadldr">Estatus de la unidad</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';

            //---------------------------------------------------------------editar tipo de unidad administrador flotilla interna------------------------------------------------
            if ($id_tipo_usuario == 1): // Administrador 
            // Realizar la consulta para obtener el tipo de unidad
            $sqltipounidad = "SELECT id_tipo_unidad, tipo_unidad FROM tipo_unidad WHERE id_tipo_unidad != 3";
            $result = $conectar->query($sqltipounidad);
            echo '<div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarTipoUnidad" placeholder="editarTipoUnidad" name="editarTipoUnidad">
                    <option value="">Seleccione un tipo</option>'; // Opción predeterminada

            while ($rowtipounidad = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_tipo_unidad'] == $rowtipounidad['id_tipo_unidad']) ? 'selected' : '';
                echo '<option value="' . $rowtipounidad['id_tipo_unidad'] . '" ' . $selected . '>' . $rowtipounidad['tipo_unidad'] . '</option>';
            }
            echo '</select>
            <label for="tipounidadldr">Tipo de unidad</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';


            //---------------------------------------------------------------editar tipo de unidad administrador DEMOS------------------------------------------------
            elseif ($id_tipo_usuario == 4): // Administrador DEMOS
                // Realizar la consulta para obtener el tipo de unidad
            $sqltipounidad = "SELECT id_tipo_unidad, tipo_unidad FROM tipo_unidad WHERE id_tipo_unidad = 3";
            $result = $conectar->query($sqltipounidad);
            echo '<div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarTipoUnidad" placeholder="editarTipoUnidad" name="editarTipoUnidad" disabled>
                    <option value="">Seleccione un tipo</option>'; // Opción predeterminada

            while ($rowtipounidad = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_tipo_unidad'] == $rowtipounidad['id_tipo_unidad']) ? 'selected' : '';
                echo '<option value="' . $rowtipounidad['id_tipo_unidad'] . '" ' . $selected . '>' . $rowtipounidad['tipo_unidad'] . '</option>';
            }
            echo '</select>
            <label for="tipounidadldr">Tipo de unidad</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';
            endif;
//---------------------------------------------------------------editar folio factura------------------------------------------------
            echo '<div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="editarfoliofacturaunidad" placeholder="editarfoliofacturaunidad" name="editarfechaadquisicionunidad" value="' . $data['folio_factura'] . '">
                <label for="fechaadquisicionunidadldr">Folio de factura</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>';
    //---------------------------------------------------------------editar sede de la unidad------------------------------------------------
            // Realizar la consulta para obtener la sede de la unidad
            $sqlsedeunidad = "SELECT id_sede, ubicacion FROM sedes";
            $result = $conectar->query($sqlsedeunidad);
            echo '
            <h3>Ubicación y adquisición</h3>
            <div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editsedeunidad" placeholder="editsedeunidad" name="editsedeunidad">
                    <option value="">Seleccione una sede</option>'; // Opción predeterminada

            while ($rowsedeunidad = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_sede'] == $rowsedeunidad['id_sede']) ? 'selected' : '';
                echo '<option value="' . $rowsedeunidad['id_sede'] . '" ' . $selected . '>' . $rowsedeunidad['ubicacion'] . '</option>';
            }
            echo '</select>
            <label for="sedeunidadldr">Sede de la unidad</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';

            //---------------------------------------------------------------editar fecha de adquisicion de la unidad------------------------------------------------
            echo '<div class="col-md-6">
            <div class="form-floating">
                <input type="date" class="form-control" id="editarfechaadquisicionunidad" placeholder="editarfechaadquisicionunidad" name="editarfechaadquisicionunidad" value="' . $data['fecha_adquisicion'] . '">
                <label for="fechaadquisicionunidadldr">Fecha de adquisicion de la unidad</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>';

        //---------------------------------------------------------------editar tipo de adquisicion de la unidad------------------------------------------------
        //realizar la consulta para obtener el tipo de adquisicion de la unidad
        $sqltipoadquisicionunidad = "SELECT id_tipo_adquisicion, nombre_tipo_adquisicion FROM tipo_adquisicion";
        $result = $conectar->query($sqltipoadquisicionunidad);
        echo '<div class="col-md-6">
        <div class="form-floating">
            <select class="form-control" id="editartipoadquisicionunidad" placeholder="editartipoadquisicionunidad" name="editartipoadquisicionunidad">
                <option value="">Seleccione un tipo</option>'; // Opción predeterminada

        while ($rowtipoadquisicionunidad = $result->fetch_assoc()) {
            // Mostrar cada estado como una opcion
            $selected = ($data['id_tipo_adquisicion'] == $rowtipoadquisicionunidad['id_tipo_adquisicion']) ? 'selected' : '';
            echo '<option value="' . $rowtipoadquisicionunidad['id_tipo_adquisicion'] . '" ' . $selected . '>' . $rowtipoadquisicionunidad['nombre_tipo_adquisicion'] . '</option>';
        }
        echo '</select>
        <label for="tipoadquisicionunidadldr">Tipo de adquisicion de la unidad</label>
    </div>
    <label class="" style="color: white;">*Campo obligatorio</label>
</div>';
//---------------------------------------------------------------editar tipo de arrendadora de la unidad------------------------------------------------
        //realizar la consulta para obtener el tipo de adquisicion de la unidad
        $sqlarrendadoraunidad = "SELECT id_arrendadora, arrendadora FROM arrendadora";
        $result = $conectar->query($sqlarrendadoraunidad);
        echo '<div class="col-md-6">
        <div class="form-floating">
            <select class="form-control" id="editartipoarrendadoraunidad" placeholder="editartipoarrendadoraunidad" name="editartipoarrendadoraunidad">
                <option value="">Seleccione un tipo</option>'; // Opción predeterminada

        while ($rowarrendadoraunidad = $result->fetch_assoc()) {
            // Mostrar cada estado como una opcion
            $selected = ($data['id_arrendadora'] == $rowarrendadoraunidad['id_arrendadora']) ? 'selected' : '';
            echo '<option value="' . $rowarrendadoraunidad['id_arrendadora'] . '" ' . $selected . '>' . $rowarrendadoraunidad['arrendadora'] . '</option>';
        }
        echo '</select>
        <label for="tipoadquisicionunidadldr">Arrendadora</label>
    </div>
    <label class="" style="color: white;">*Campo obligatorio</label>
</div>';

//-------------------------------------------------------------editar caracteristicas funcionales de las unidades demos

if ($id_tipo_usuario == 4): // Administrador DEMOS
            echo '<h3>Características funcionales</h3>
        <!-----------------------------------------------------------------Capacidad de carga (kg)-------------------------------------->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="editarCarga" placeholder="editarCarga" name="editarCarga" value="' . $data['capacidad_carga'] . '">
                <label for="kilometrajeunidadldr">Capacidad de carga (kg)</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>

        <!-----------------------------------------------------------------Capacidad de pasajeros-------------------------------------->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="editarPasajeros" placeholder="editarPasajeros" name="editarPasajeros" value="' . $data['capacidad_pasajeros'] . '">
                <label for="kilometrajeunidadldr">Capacidad de pasajeros</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>
        ';
        //---------------------------------------------------------------editar tipo de combustible------------------------------------------------
            // Realizar la consulta para obtener el tipo de combustible
            $sqltipocombustible = "SELECT id_tipo_combustible, combustible FROM tipos_combustibles";
            $result = $conectar->query($sqltipocombustible);
            echo '
            <div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarCombustible" placeholder="editarCombustible" name="editarCombustible">
                    <option value="">Seleccione un tipo de combustible</option>'; // Opción predeterminada

            while ($rowtipocombustible = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_tipo_combustible'] == $rowtipocombustible['id_tipo_combustible']) ? 'selected' : '';
                echo '<option value="' . $rowtipocombustible['id_tipo_combustible'] . '" ' . $selected . '>' . $rowtipocombustible['combustible'] . '</option>';
            }
            echo '</select>
            <label for="estadounidadldr">Tipo de combustible</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';

        //---------------------------------------------------------------editar traccion------------------------------------------------
            // Realizar la consulta para obtener la traccion
            $sqltipocombustible = "SELECT id_traccion, traccion FROM tracciones";
            $result = $conectar->query($sqltipocombustible);
            echo '
            <div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarTraccion" placeholder="editarTraccion" name="editarTraccion">
                    <option value="">Seleccione la traccion</option>'; // Opción predeterminada

            while ($rowtraccion = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_traccion'] == $rowtraccion['id_traccion']) ? 'selected' : '';
                echo '<option value="' . $rowtraccion['id_traccion'] . '" ' . $selected . '>' . $rowtraccion['traccion'] . '</option>';
            }
            echo '</select>
            <label for="estadounidadldr">Traccion</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';

    echo'
        <!-----------------------------------------------------------------------editar tipo carroceria-------------------------------------->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="editarCarroceria" placeholder="editarCarroceria" name="editarCarroceria" value="' . $data['tipo_carrceria'] . '">
                <label for="kilometrajeunidadldr">Carrocería</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>

        <!-----------------------------------------------------------------------editar numero de puertas-------------------------------------->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="editarPuertas" placeholder="editarPuertas" name="editarPuertas" value="' . $data['numero_puertas'] . '">
                <label for="kilometrajeunidadldr">Número de puertas</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>

        <!-----------------------------------------------------------------------editar numero de asientos-------------------------------------->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="editarAsientos" placeholder="editarAsientos" name="editarAsientos" value="' . $data['numero_asientos'] . '">
                <label for="kilometrajeunidadldr">Número de asientos</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>';

        //---------------------------------------------------------------editar tipo de caja------------------------------------------------
            // Realizar la consulta para obtener el tipo de caja
            $sqltipocaja = "SELECT id_tipo_caja, tipo_caja FROM tipos_cajas";
            $result = $conectar->query($sqltipocaja);
            echo '
            <div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarCaja" placeholder="editarCaja" name="editarCaja">
                    <option value="">Seleccione el tipo de caja</option>'; // Opción predeterminada

            while ($rowtipocaja = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_tipo_caja'] == $rowtipocaja['id_tipo_caja']) ? 'selected' : '';
                echo '<option value="' . $rowtipocaja['id_tipo_caja'] . '" ' . $selected . '>' . $rowtipocaja['tipo_caja'] . '</option>';
            }
            echo '</select>
            <label for="estadounidadldr">Tipo de caja</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';

        //---------------------------------------------------------------editar tipo de frenos------------------------------------------------
            // Realizar la consulta para obtener el tipo de frenos
            $sqltipofrenos = "SELECT id_tipo_freno, tipo_freno FROM tipos_frenos";
            $result = $conectar->query($sqltipofrenos);
            echo '
            <div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarFreno" placeholder="editarFreno" name="editarFreno">
                    <option value="">Seleccione el tipo de freno</option>'; // Opción predeterminada

            while ($rowtipofrenos = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_tipo_freno'] == $rowtipofrenos['id_tipo_freno']) ? 'selected' : '';
                echo '<option value="' . $rowtipofrenos['id_tipo_freno'] . '" ' . $selected . '>' . $rowtipofrenos['tipo_freno'] . '</option>';
            }
            echo '</select>
            <label for="estadounidadldr">Tipo de frenos</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';

        //---------------------------------------------------------------editar suspencion------------------------------------------------
            // Realizar la consulta para obtener el tipo de frenos
            $sqltiposuspension = "SELECT id_tipo_suspencion, tipo_suspencion FROM tipos_suspenciones";
            $result = $conectar->query($sqltiposuspension);
            echo '
            <div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarSuspencion" placeholder="editarSuspencion" name="editarSuspencion">
                    <option value="">Seleccione el tipo de suspención</option>'; // Opción predeterminada

            while ($rowtiposuspencion = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_tipo_suspencion'] == $rowtiposuspencion['id_tipo_suspencion']) ? 'selected' : '';
                echo '<option value="' . $rowtiposuspencion['id_tipo_suspencion'] . '" ' . $selected . '>' . $rowtiposuspencion['tipo_suspencion'] . '</option>';
            }
            echo '</select>
            <label for="estadounidadldr">Tipo de suspención</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';

    echo'
        <!-----------------------------------------------------------------------editar numero de ejes-------------------------------------->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="editarEjes" placeholder="editarEjes" name="editarEjes" value="' . $data['numero_ejes'] . '">
                <label for="kilometrajeunidadldr">Número de ejes</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>';

        //---------------------------------------------------------------editar uso permitido------------------------------------------------
            // Realizar la consulta para obtener el uso permitido
            $sqlusopermitido = "SELECT id_tipo_uso, tipo_uso FROM tipos_usos";
            $result = $conectar->query($sqlusopermitido);
            echo '
            <div class="col-md-6">
            <div class="form-floating">
                <select class="form-control" id="editarUso" placeholder="editarUso" name="editarUso">
                    <option value="">Seleccione el uso permitido</option>'; // Opción predeterminada

            while ($rowusopermitido = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_tipo_uso'] == $rowusopermitido['id_tipo_uso']) ? 'selected' : '';
                echo '<option value="' . $rowusopermitido['id_tipo_uso'] . '" ' . $selected . '>' . $rowusopermitido['tipo_uso'] . '</option>';
            }
            echo '</select>
            <label for="estadounidadldr">Uso permitido</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';

    echo'
        <!-----------------------------------------------------------------------editar checkboxes-------------------------------------->
        <div class="col-md-6">
            <!-- Extras tecnológicos -->
                    <div class="col-md-6">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="editar_camara_reversa" id="editar_camara_reversa" value="1" ' . ($data['camara_reversa'] == 1 ? 'checked' : '') . '>
                            <label class="form-check-label" for="editar_camara_reversa">Cámara de reversa</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="editar_sensores_reversa" id="editar_sensores_reversa" value="1" ' . ($data['sensores_reversa'] == 1 ? 'checked' : '') . '>
                            <label class="form-check-label" for="editar_sensores_reversa">Sensores de reversa</label>
                        </div>
                    </div>
        </div>';

        endif;

//---------------------------------------------------------------editar imagen de la unidad------------------------------------------------
        echo '
        <h3>Imagen</h3>
        <div class="col-md-8">
        <div class="form-floating">
            <div class="form-label">
                <input type="file" class="form-control" id="imagen_unidad" name="imagen_unidad" accept="image/*">
                <label class="input-group-text" for="imagen_unidad">
                    <i class="fas fa-upload"></i> Cargar Imagen
                </label>
            </div>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>';
    } else {
        echo "No hay tipos de unidad disponibles.";
    }
        } else {
            echo "No hay marcas disponibles.";
    }

    $conectar->close();

    ?>