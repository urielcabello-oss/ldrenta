<div class="row">

    <?php
    include("../../conexion.php");

    if (!isset($_SESSION)) {
        session_start();
    }


    if (isset($_POST['idunidad'])) {

        $idunidad = $_POST['idunidad'];

        $queryobtenerunidad = "SELECT 
                                u.*,
                                marc.id_marca,
                                marc.nombre_marca,
                                mode.nombre_modelo,
                                color.color_unidad
                            FROM unidades AS u
                            LEFT JOIN modelos AS mode
                                ON u.id_modelo = mode.id_modelo
                            LEFT JOIN marcas AS marc
                                ON mode.id_marca = marc.id_marca
                            LEFT JOIN unidad_color AS color
                                ON u.id_color = color.id_color
                            WHERE u.id_unidad = '$idunidad'";

        $resultado = $conectar->query($queryobtenerunidad);

        if (!$resultado || mysqli_num_rows($resultado) == 0) {
            echo '<div class="alert alert-danger">No se encontró la unidad.</div>';
            exit;
        }

        $data = mysqli_fetch_assoc($resultado);

    ?>

        <!-- ============================= CARD SUPERIOR ============================= -->

        <div class="col-12 mb-4">

            <div class="ldr-top-card">

                <div class="row g-0 align-items-center">

                    <!-- Imagen -->
                    <div class="col-xl-4 text-center">

                        <div class="ldr-top-card-img">

                            <img src="../../Servidor/archivos/imagenes/imagenes_unidades/<?php echo $data['img_unidad']; ?>"
                                onerror="this.src='../../Cliente/img/unidades/silueta_tracto3.png'"
                                class="img-fluid">

                        </div>

                    </div>

                    <!-- Información -->
                    <div class="col-xl-8">

                        <div class="ldr-top-card-body">

                            <div class="d-flex flex-wrap gap-2 mb-3">

                                <span class="badge bg-success">
                                    <?php echo $data['placa'] ?: 'Sin placa'; ?>
                                </span>

                                <span class="badge bg-dark">
                                    <?php echo $data['anio_unidad']; ?>
                                </span>

                                <span class="badge bg-primary">
                                    <?php echo $data['nombre_marca']; ?>
                                </span>

                            </div>

                            <h2 class="ldr-unidad-title">
                                <?php echo $data['nombre_modelo']; ?>
                            </h2>

                            <div class="row mt-4">

                                <div class="col-md-4 mb-3">
                                    <small>VIN</small>
                                    <h6><?php echo $data['vin'] ?: 'N/D'; ?></h6>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <small>Motor</small>
                                    <h6><?php echo $data['numero_motor'] ?: 'N/D'; ?></h6>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <small>Color</small>
                                    <h6><?php echo $data['color_unidad'] ?: 'N/D'; ?></h6>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ============================= FORMULARIO ============================= -->

        <div class="col-12">

            <!-- ===================== MARCA Y MODELO ===================== -->

            <div class="ldr-form-section">

                <div class="ldr-section-title">
                    <i class="fas fa-car-side"></i>
                    Marca y modelo
                </div>

                <div class="row g-3">

                    <!-- Marca -->
                    <div class="col-md-6">

                        <div class="form-floating">

                            <select class="form-select input-moderno"
                                id="marcaeditarunidad"
                                name="marcaeditarunidad">

                                <option value="">Seleccione una marca</option>

                                <?php

                                $marcas = $conectar->query("SELECT * FROM marcas");

                                while ($marca = $marcas->fetch_assoc()) {

                                    $selected = ($marca['id_marca'] == $data['id_marca']) ? 'selected' : '';

                                    echo '
                                <option value="' . $marca['id_marca'] . '" ' . $selected . '>
                                    ' . $marca['nombre_marca'] . '
                                </option>';
                                }

                                ?>

                            </select>

                            <label>Marca</label>

                        </div>

                    </div>

                    <!-- Modelo -->
                    <div class="col-md-6">

                        <div class="form-floating">

                            <select class="form-select input-moderno"
                                id="modeloeditarunidad"
                                name="modeloeditarunidad">

                                <option value="">Seleccione un modelo</option>

                                <?php

                                $modelos = $conectar->query("SELECT * FROM modelos");

                                while ($modelo = $modelos->fetch_assoc()) {

                                    $selected = ($modelo['id_modelo'] == $data['id_modelo']) ? 'selected' : '';

                                    echo '
                                <option value="' . $modelo['id_modelo'] . '" ' . $selected . '>
                                    ' . $modelo['nombre_modelo'] . '
                                </option>';
                                }

                                ?>

                            </select>

                            <label>Modelo</label>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================== DATOS GENERALES ===================== -->

            <div class="ldr-form-section">

                <div class="ldr-section-title">
                    <i class="fas fa-file-lines"></i>
                    Datos generales
                </div>

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text"
                                class="form-control input-moderno"
                                id="editarPlaca"
                                name="editarPlaca"
                                value="<?php echo htmlspecialchars($data['placa']); ?>">
                            <label>Placa</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text"
                                class="form-control input-moderno"
                                id="editarVIN"
                                name="editarVIN"
                                value="<?php echo htmlspecialchars($data['vin']); ?>">
                            <label>VIN</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text"
                                class="form-control input-moderno"
                                id="editarNumeroMotor"
                                name="editarNumeroMotor"
                                value="<?php echo htmlspecialchars($data['numero_motor']); ?>">
                            <label>Número de motor</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number"
                                class="form-control input-moderno"
                                id="editarAnioUnidad"
                                name="editarAnioUnidad"
                                value="<?php echo htmlspecialchars($data['anio_unidad']); ?>">
                            <label>Año</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text"
                                class="form-control input-moderno"
                                id="editarPasoDiferencial"
                                name="editarPasoDiferencial"
                                value="<?php echo htmlspecialchars($data['paso_diferencial']); ?>">
                            <label>Paso diferencial</label>
                        </div>
                    </div>

                    <div class="col-md-4">

                        <div class="form-floating">

                            <select class="form-select input-moderno"
                                id="editarColor"
                                name="editarColor">

                                <option value="">Seleccione</option>

                                <?php

                                $colores = $conectar->query("SELECT * FROM unidad_color");

                                while ($color = $colores->fetch_assoc()) {

                                    $selected = ($color['id_color'] == $data['id_color']) ? 'selected' : '';

                                    echo '
                                <option value="' . $color['id_color'] . '" ' . $selected . '>
                                    ' . $color['color_unidad'] . '
                                </option>';
                                }

                                ?>

                            </select>

                            <label>Color</label>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================== ESTATUS ===================== -->

            <div class="ldr-form-section">

                <div class="ldr-section-title">
                    <i class="fas fa-circle-check"></i>
                    Estado y estatus
                </div>

                <div class="row g-3">

                    <div class="col-md-4">

                        <div class="form-floating">

                            <select class="form-select input-moderno"
                                id="editarEstadoUnidad"
                                name="editarEstadoUnidad">

                                <?php

                                $estados = $conectar->query("
                                SELECT * 
                                FROM estado_unidad
                            ");

                                while ($estado = $estados->fetch_assoc()) {

                                    $selected = ($estado['id_estado_unidad'] == $data['id_estado_unidad']) ? 'selected' : '';

                                    echo '
                                <option value="' . $estado['id_estado_unidad'] . '" ' . $selected . '>
                                    ' . $estado['estado'] . '
                                </option>';
                                }

                                ?>

                            </select>

                            <label>Estado</label>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-floating">

                            <select class="form-select input-moderno"
                                id="editarEstatusUnidad"
                                name="editarEstatusUnidad">

                                <?php

                                $estatus = $conectar->query("SELECT * FROM estatus_unidades");

                                while ($row = $estatus->fetch_assoc()) {

                                    $selected = ($row['id_estatus_unidad'] == $data['id_estatus_unidad']) ? 'selected' : '';

                                    echo '
                                <option value="' . $row['id_estatus_unidad'] . '" ' . $selected . '>
                                    ' . $row['estatus'] . '
                                </option>';
                                }

                                ?>

                            </select>

                            <label>Estatus</label>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-floating">

                            <select class="form-select input-moderno"
                                id="editarTipoUnidad"
                                name="editarTipoUnidad">

                                <?php

                                $tipos = $conectar->query("SELECT * FROM tipo_unidad");

                                while ($tipo = $tipos->fetch_assoc()) {

                                    $selected = ($tipo['id_tipo_unidad'] == $data['id_tipo_unidad']) ? 'selected' : '';

                                    echo '
                                <option value="' . $tipo['id_tipo_unidad'] . '" ' . $selected . '>
                                    ' . $tipo['tipo_unidad'] . '
                                </option>';
                                }

                                ?>

                            </select>

                            <label>Tipo unidad</label>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================== ADQUISICIÓN ===================== -->

            <div class="ldr-form-section">

                <div class="ldr-section-title">
                    <i class="fas fa-building"></i>
                    Ubicación y adquisición
                </div>

                <div class="row g-3">

                    <div class="col-md-3">

                        <div class="form-floating">

                            <input type="number"
                                class="form-control input-moderno"
                                id="editarCostoNeto"
                                name="editarCostoNeto"
                                value="<?php echo htmlspecialchars($data['costo_neto']); ?>">

                            <label>Costo neto</label>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-floating">

                            <input type="text"
                                class="form-control input-moderno"
                                id="editarfoliofacturaunidad"
                                name="editarfoliofacturaunidad"
                                value="<?php echo htmlspecialchars($data['folio_factura']); ?>">

                            <label>Folio factura</label>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-floating">

                            <input type="date"
                                class="form-control input-moderno"
                                id="editarfechaadquisicionunidad"
                                name="editarfechaadquisicionunidad"
                                value="<?php echo htmlspecialchars($data['fecha_adquisicion']); ?>">

                            <label>Fecha adquisición</label>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-floating">

                            <select class="form-select input-moderno"
                                id="editsedeunidad"
                                name="editsedeunidad">

                                <?php

                                $sedes = $conectar->query("SELECT * FROM sedes");

                                while ($sede = $sedes->fetch_assoc()) {

                                    $selected = ($sede['id_sede'] == $data['id_sede']) ? 'selected' : '';

                                    echo '
                                <option value="' . $sede['id_sede'] . '" ' . $selected . '>
                                    ' . $sede['ubicacion'] . '
                                </option>';
                                }

                                ?>

                            </select>

                            <label>Sede</label>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-floating">

                            <select class="form-select input-moderno"
                                id="editartipoadquisicionunidad"
                                name="editartipoadquisicionunidad">

                                <?php

                                $adquisicion = $conectar->query("SELECT * FROM tipo_adquisicion");

                                while ($tipo = $adquisicion->fetch_assoc()) {

                                    $selected = ($tipo['id_tipo_adquisicion'] == $data['id_tipo_adquisicion']) ? 'selected' : '';

                                    echo '
                                <option value="' . $tipo['id_tipo_adquisicion'] . '" ' . $selected . '>
                                    ' . $tipo['nombre_tipo_adquisicion'] . '
                                </option>';
                                }

                                ?>

                            </select>

                            <label>Tipo adquisición</label>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-floating">

                            <select class="form-select input-moderno"
                                id="editartipoarrendadoraunidad"
                                name="editartipoarrendadoraunidad">

                                <?php

                                $adquisicion = $conectar->query("SELECT * FROM arrendadora");

                                while ($tipo = $adquisicion->fetch_assoc()) {

                                    $selected = ($tipo['id_arrendadora'] == $data['id_arrendadora']) ? 'selected' : '';

                                    echo '
                                <option value="' . $tipo['id_arrendadora'] . '" ' . $selected . '>
                                    ' . $tipo['arrendadora'] . '
                                </option>';
                                }

                                ?>

                            </select>

                            <label>Tipo adquisición</label>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================== IMAGEN ===================== -->

            <div class="ldr-form-section">

                <div class="ldr-section-title">
                    <i class="fas fa-image"></i>
                    Imagen de la unidad
                </div>

                <div class="row">

                    <div class="col-md-8">

                        <input type="file"
                            class="form-control input-moderno"
                            id="imagen_unidad"
                            name="imagen_unidad"
                            accept="image/*">

                    </div>

                </div>

            </div>

        </div>

    <?php

    } else {

        echo '<div class="alert alert-warning">No se recibió la unidad.</div>';
    }

    $conectar->close();

    ?>

</div>