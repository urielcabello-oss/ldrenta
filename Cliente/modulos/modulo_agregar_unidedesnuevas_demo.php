<div class="container-fluid px-3 px-md-4 mt-4">

    <!-- HEADER -->
    <div class="panel-acciones-final p-4 mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h4 class="titulo-validacion mb-1">
                    Registro de unidades
                </h4>

                <p class="subtitulo-validacion mb-0">
                    Alta y administración de nuevas unidades dentro de la flotilla.
                </p>

            </div>

            <div class="d-flex gap-2">

                <?php if (tienePermiso('ROLES', 'w')): ?>

                    <button type="button"
                        class="btn btn-dark"
                        id="btnToggleCatalogos">

                        <i class="fa-solid fa-sliders me-2"></i>
                        Administrar catálogos

                    </button>

                <?php endif; ?>

                <button type="button"
                    class="btn btn-light btn-modern border"
                    onclick="window.history.back();">

                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Regresar

                </button>

            </div>

        </div>

    </div>

    <!-- ========================================= -->
    <!-- PANEL CATALOGOS -->
    <!-- ========================================= -->

    <div id="panelCatalogos"
        class="panel-acciones-final p-4 mb-4 d-none">


        <!-- ========================================= -->
        <!-- ADMINISTRACION DE CATALOGOS -->
        <!-- ========================================= -->


        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div class="titulo-seccion-orange">

                <div class="icono-seccion">
                    <i class="fa-solid fa-car-side"></i>
                </div>

                <div>
                    <h5 class="mb-0 fw-bold">
                        Administración de catálogos
                    </h5>

                    <small>
                        Gestión de marcas, modelos y sedes
                    </small>
                </div>

            </div>

        </div>

        <!-- ================================= -->
        <!-- ALTAS RAPIDAS -->
        <!-- ================================= -->

        <div class="row g-4 mb-5">

            <!-- MARCAS -->
            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <h6 class="fw-bold mb-3">

                            <i class="fa-solid fa-car me-2 text-warning"></i>
                            Nueva marca

                        </h6>

                        <input type="text"
                            class="form-control input-moderno mb-3"
                            id="nuevaMarca"
                            placeholder="Ej. Toyota">

                        <button type="button"
                            class="btn btn-orange w-100"
                            id="btnRegistrarMarca">

                            <i class="fa-solid fa-plus me-2"></i>
                            Registrar marca

                        </button>

                    </div>

                </div>

            </div>

            <!-- MODELOS -->
            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <h6 class="fw-bold mb-3">

                            <i class="fa-solid fa-list me-2 text-warning"></i>
                            Nuevo modelo

                        </h6>

                        <select class="form-select input-moderno mb-3"
                            id="marcaModelo">

                            <option value="">
                                Seleccionar marca
                            </option>

                            <?php

                            $sql = "SELECT *
                                FROM marcas
                                WHERE activo = 1
                                ORDER BY nombre_marca ASC";

                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {

                                echo '
                            
                            <option value="' . $row['id_marca'] . '">
                                ' . $row['nombre_marca'] . '
                            </option>

                            ';
                            }

                            ?>

                        </select>

                        <input type="text"
                            class="form-control input-moderno mb-3"
                            id="nuevoModelo"
                            placeholder="Ej. Hilux">

                        <button type="button"
                            class="btn btn-orange w-100"
                            id="btnRegistrarModelo">

                            <i class="fa-solid fa-plus me-2"></i>
                            Registrar modelo

                        </button>

                    </div>

                </div>

            </div>

            <!-- SEDES -->
            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <h6 class="fw-bold mb-3">

                            <i class="fa-solid fa-location-dot me-2 text-warning"></i>
                            Nueva sede

                        </h6>

                        <input type="text"
                            class="form-control input-moderno mb-3"
                            id="nuevaSede"
                            placeholder="Ej. Monterrey">

                        <button type="button"
                            class="btn btn-orange w-100"
                            id="btnRegistrarSede">

                            <i class="fa-solid fa-plus me-2"></i>
                            Registrar sede

                        </button>

                    </div>

                </div>

            </div>

            <!-- UBICACIONES -->
            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <h6 class="fw-bold mb-3">

                            <i class="fa-solid fa-location-dot me-2 text-warning"></i>
                            Nueva Ubicación

                        </h6>

                        <input type="text"
                            class="form-control input-moderno mb-3"
                            id="nuevaUbicacion"
                            placeholder="Ej. Patio FULOGMA TECAMAC">

                        <button type="button"
                            class="btn btn-orange w-100"
                            id="btnRegistrarUbicacion">

                            <i class="fa-solid fa-plus me-2"></i>
                            Registrar sede

                        </button>

                    </div>

                </div>

            </div>

        </div>

        <!-- ================================= -->
        <!-- TABS -->
        <!-- ================================= -->

        <ul class="nav nav-pills mb-4"
            role="tablist">

            <!-- MARCAS -->
            <li class="nav-item me-2">

                <button class="nav-link active"
                    data-bs-toggle="pill"
                    data-bs-target="#tabMarcas">

                    <i class="fa-solid fa-car me-2"></i>
                    Marcas

                </button>

            </li>

            <!-- MODELOS -->
            <li class="nav-item me-2">

                <button class="nav-link"
                    data-bs-toggle="pill"
                    data-bs-target="#tabModelos">

                    <i class="fa-solid fa-list me-2"></i>
                    Modelos

                </button>

            </li>

            <!-- SEDES -->
            <li class="nav-item">

                <button class="nav-link"
                    data-bs-toggle="pill"
                    data-bs-target="#tabSedes">

                    <i class="fa-solid fa-location-dot me-2"></i>
                    Sedes

                </button>

            </li>

            <!-- UBICACIONES -->
            <li class="nav-item">

                <button class="nav-link"
                    data-bs-toggle="pill"
                    data-bs-target="#tabUbicaciones">

                    <i class="fa-solid fa-location-dot me-2"></i>
                    Ubicaciones

                </button>

            </li>

        </ul>

        <div class="tab-content">

            <!-- ================================= -->
            <!-- TAB MARCAS -->
            <!-- ================================= -->

            <div class="tab-pane fade show active"
                id="tabMarcas">

                <div class="table-responsive">

                    <table class="table align-middle ldr-table">

                        <thead class="table-light">

                            <tr>

                                <th>Marca</th>
                                <th width="150">Estatus</th>
                                <th width="180">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $sql = "SELECT *
                                FROM marcas
                                ORDER BY nombre_marca ASC";

                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {

                            ?>

                                <tr>

                                    <td>
                                        <?php echo $row['nombre_marca']; ?>
                                    </td>

                                    <td>

                                        <?php if ($row['activo'] == 1) { ?>

                                            <span class="badge bg-success">
                                                Activo
                                            </span>

                                        <?php } else { ?>

                                            <span class="badge bg-danger">
                                                Inactivo
                                            </span>

                                        <?php } ?>

                                    </td>

                                    <td>

                                        <!-- EDITAR -->
                                        <button type="button"
                                            class="btn btn-sm btn-warning btnEditarMarca"
                                            data-id="<?php echo $row['id_marca']; ?>"
                                            data-marca="<?php echo $row['nombre_marca']; ?>">

                                            <i class="fa-solid fa-pen"></i>

                                        </button>

                                        <!-- ACTIVAR / DESACTIVAR -->
                                        <?php if ($row['activo'] == 1) { ?>

                                            <button type="button"
                                                class="btn btn-sm btn-danger btnEstatusMarca"
                                                data-id="<?php echo $row['id_marca']; ?>"
                                                data-estatus="0">

                                                <i class="fa-solid fa-ban"></i>

                                            </button>

                                        <?php } else { ?>

                                            <button type="button"
                                                class="btn btn-sm btn-success btnEstatusMarca"
                                                data-id="<?php echo $row['id_marca']; ?>"
                                                data-estatus="1">

                                                <i class="fa-solid fa-check"></i>

                                            </button>

                                        <?php } ?>

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- ================================= -->
            <!-- TAB MODELOS -->
            <!-- ================================= -->

            <div class="tab-pane fade"
                id="tabModelos">

                <div class="table-responsive">

                    <table class="table align-middle ldr-table">

                        <thead class="table-light">

                            <tr>

                                <th>Marca</th>
                                <th>Modelo</th>
                                <th width="150">Estatus</th>
                                <th width="180">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $sql = "SELECT m.*,
                                       ma.nombre_marca
                                FROM modelos m
                                INNER JOIN marcas ma
                                    ON ma.id_marca = m.id_marca
                                ORDER BY ma.nombre_marca ASC";

                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {

                            ?>

                                <tr>

                                    <td>
                                        <?php echo $row['nombre_marca']; ?>
                                    </td>

                                    <td>
                                        <?php echo $row['nombre_modelo']; ?>
                                    </td>

                                    <td>

                                        <?php if ($row['activo'] == 1) { ?>

                                            <span class="badge bg-success">
                                                Activo
                                            </span>

                                        <?php } else { ?>

                                            <span class="badge bg-danger">
                                                Inactivo
                                            </span>

                                        <?php } ?>

                                    </td>

                                    <td>

                                        <button type="button"
                                            class="btn btn-sm btn-warning">

                                            <i class="fa-solid fa-pen"></i>

                                        </button>

                                        <?php if ($row['activo'] == 1) { ?>

                                            <button type="button"
                                                class="btn btn-sm btn-danger">

                                                <i class="fa-solid fa-ban"></i>

                                            </button>

                                        <?php } else { ?>

                                            <button type="button"
                                                class="btn btn-sm btn-success">

                                                <i class="fa-solid fa-check"></i>

                                            </button>

                                        <?php } ?>

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- ================================= -->
            <!-- TAB SEDES -->
            <!-- ================================= -->

            <div class="tab-pane fade"
                id="tabSedes">

                <div class="table-responsive">

                    <table class="table align-middle ldr-table">

                        <thead class="table-light">

                            <tr>

                                <th>Sede</th>
                                <th width="150">Estatus</th>
                                <th width="180">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $sql = "SELECT *
                                FROM sedes
                                ORDER BY ubicacion ASC";

                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {

                            ?>

                                <tr>

                                    <td>
                                        <?php echo $row['ubicacion']; ?>
                                    </td>

                                    <td>

                                        <?php if ($row['activo'] == 1) { ?>

                                            <span class="badge bg-success">
                                                Activo
                                            </span>

                                        <?php } else { ?>

                                            <span class="badge bg-danger">
                                                Inactivo
                                            </span>

                                        <?php } ?>

                                    </td>

                                    <td>

                                        <button type="button"
                                            class="btn btn-sm btn-warning">

                                            <i class="fa-solid fa-pen"></i>

                                        </button>

                                        <?php if ($row['activo'] == 1) { ?>

                                            <button type="button"
                                                class="btn btn-sm btn-danger">

                                                <i class="fa-solid fa-ban"></i>

                                            </button>

                                        <?php } else { ?>

                                            <button type="button"
                                                class="btn btn-sm btn-success">

                                                <i class="fa-solid fa-check"></i>

                                            </button>

                                        <?php } ?>

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- ================================= -->
            <!-- TAB UBICACIONES -->
            <!-- ================================= -->

            <div class="tab-pane fade"
                id="tabUbicaciones">

                <div class="table-responsive">

                    <table class="table align-middle ldr-table">

                        <thead class="table-light">

                            <tr>

                                <th>Ubicación</th>
                                <th width="150">Estatus</th>
                                <th width="180">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $sql = "SELECT *
                                FROM ubicaciones
                                ORDER BY ubicacion_unidad ASC";

                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {

                            ?>

                                <tr>

                                    <td>
                                        <?php echo $row['ubicacion_unidad']; ?>
                                    </td>

                                    <td>

                                        <?php if ($row['activo'] == 1) { ?>

                                            <span class="badge bg-success">
                                                Activo
                                            </span>

                                        <?php } else { ?>

                                            <span class="badge bg-danger">
                                                Inactivo
                                            </span>

                                        <?php } ?>

                                    </td>

                                    <td>

                                        <button type="button"
                                            class="btn btn-sm btn-warning">

                                            <i class="fa-solid fa-pen"></i>

                                        </button>

                                        <?php if ($row['activo'] == 1) { ?>

                                            <button type="button"
                                                class="btn btn-sm btn-danger">

                                                <i class="fa-solid fa-ban"></i>

                                            </button>

                                        <?php } else { ?>

                                            <button type="button"
                                                class="btn btn-sm btn-success">

                                                <i class="fa-solid fa-check"></i>

                                            </button>

                                        <?php } ?>

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div id="panelAltaUnidad">
        <form id="formRegistrarUnidadDemo" enctype="multipart/form-data">
            <!-- ========================================= -->
            <!-- MARCA Y MODELO -->
            <!-- ========================================= -->

            <div class="panel-acciones-final p-4 mb-4">

                <div class="titulo-seccion-orange mb-4">

                    <div class="icono-seccion">
                        <i class="fa-solid fa-car-side"></i>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">
                            Marca y modelo
                        </h5>

                        <small>
                            Información principal de identificación
                        </small>
                    </div>

                </div>

                <div class="row g-4">

                    <!-- MARCA -->
                    <div class="col-md-6">

                        <label class="form-label label-form">
                            Marca <span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="marcaunidad"
                            name="marcaunidad">

                            <option value="">Seleccionar</option>

                            <?php
                            $sql = "SELECT id_marca, nombre_marca FROM marcas WHERE activo = 1";
                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_marca'] . '">
                                ' . $row['nombre_marca'] . '
                              </option>';
                            }
                            ?>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- MODELO -->
                    <div class="col-md-6">

                        <label class="form-label label-form">
                            Modelo <span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="modelounidad"
                            name="modelounidad">

                            <option value="">Seleccionar</option>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                </div>

            </div>

            <!-- ========================================= -->
            <!-- DATOS GENERALES -->
            <!-- ========================================= -->

            <div class="panel-acciones-final p-4 mb-4">

                <div class="titulo-seccion-orange mb-4">

                    <div class="icono-seccion">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">
                            Datos generales
                        </h5>

                        <small>
                            Información administrativa y técnica
                        </small>
                    </div>

                </div>

                <div class="row g-4">

                    <!-- SUPERVISOR -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Supervisor<span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="supervisor"
                            name="supervisor">

                            <option value="">Seleccionar supervisor</option>

                            <?php

                            $sql = "
                                SELECT
                                    s.id_supervisor,
                                    s.id_usuario,
                                    u.id_colaborador,
                                    c.nombre_1,
                                    c.nombre_2,
                                    c.apellido_paterno,
                                    c.apellido_materno
                                FROM supervisores s
                                INNER JOIN usuarios u
                                    ON s.id_usuario = u.id_usuario
                                INNER JOIN colaboradores c
                                    ON u.id_colaborador = c.id_colaborador
                                WHERE s.estado = 1
                                ORDER BY c.nombre_1 ASC
                            ";

                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {

                                $nombreCompleto = trim(
                                    $row['nombre_1'] . ' ' .
                                        $row['nombre_2'] . ' ' .
                                        $row['apellido_paterno'] . ' ' .
                                        $row['apellido_materno']
                                );

                                echo '<option value="' . $row['id_supervisor'] . '">'
                                    . htmlspecialchars($nombreCompleto) .
                                    '</option>';
                            }

                            ?>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- COSTO -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Costo neto<span class="text-danger">*</span>
                        </label>

                        <input type="number"
                            step="0.01"
                            class="form-control input-moderno"
                            id="costoneto"
                            name="costoneto">

                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- COLOR -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Color<span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="colorunidad"
                            name="colorunidad">

                            <option value="">Seleccionar</option>

                            <?php
                            $sql = "SELECT id_color, color_unidad FROM unidad_color";
                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_color'] . '">
                                ' . $row['color_unidad'] . '
                              </option>';
                            }
                            ?>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- PLACA -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Placa <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            class="form-control input-moderno"
                            id="placaunidad"
                            name="placaunidad">
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- VIN -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            VIN <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            class="form-control input-moderno"
                            id="vin"
                            name="vin">
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- MOTOR -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Número de motor<span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            class="form-control input-moderno"
                            id="motorunidad"
                            name="motorunidad">
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- AÑO -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Año de la unidad<span class="text-danger">*</span>
                        </label>

                        <input type="number"
                            class="form-control input-moderno"
                            id="anounidad"
                            name="anounidad">
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- FOLIO FACTURA -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Folio factura<span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            class="form-control input-moderno"
                            id="foliofactura"
                            name="foliofactura">
                        <small class="text-danger">Campo obligatorio</small>

                    </div>
                </div>

            </div>

            <!-- ========================================= -->
            <!-- ESTADO Y ESTATUS -->
            <!-- ========================================= -->

            <div class="panel-acciones-final p-4 mb-4">

                <div class="titulo-seccion-orange mb-4">

                    <div class="icono-seccion">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">
                            Estado y estatus
                        </h5>

                        <small>
                            Configuración operativa
                        </small>
                    </div>

                </div>

                <div class="row g-4">

                    <!-- ESTADO -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Estado unidad<span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="estadounidad"
                            name="estadounidad">

                            <option value="">Seleccionar</option>

                            <?php
                            $sql = "SELECT id_estado_unidad, estado FROM estado_unidad";
                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_estado_unidad'] . '">
                                ' . $row['estado'] . '
                              </option>';
                            }
                            ?>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- ESTATUS -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Estatus<span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="estatusunidad"
                            name="estatusunidad">

                            <option value="">Seleccionar</option>

                            <?php
                            $sql = "SELECT id_estatus_unidad, estatus FROM estatus_unidades";
                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_estatus_unidad'] . '">
                                ' . $row['estatus'] . '
                              </option>';
                            }
                            ?>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- TIPO -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Tipo unidad<span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="tipounidad"
                            name="tipounidad">

                            <option value="">Seleccionar</option>

                            <?php
                            $sql = "SELECT id_tipo_unidad, tipo_unidad 
                                FROM tipo_unidad ";


                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_tipo_unidad'] . '">
                                ' . $row['tipo_unidad'] . '
                              </option>';
                            }
                            ?>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                </div>

            </div>

            <!-- ========================================= -->
            <!-- UBICACION -->
            <!-- ========================================= -->

            <div class="panel-acciones-final p-4 mb-4">

                <div class="titulo-seccion-orange mb-4">

                    <div class="icono-seccion">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">
                            Ubicación y adquisición
                        </h5>

                        <small>
                            Información administrativa
                        </small>
                    </div>

                </div>

                <div class="row g-4">

                    <!-- SEDE -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Sede<span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="sedeunidad"
                            name="sedeunidad">

                            <option value="">Seleccionar</option>

                            <?php
                            $sql = "SELECT id_sede, ubicacion FROM sedes WHERE activo = 1";
                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_sede'] . '">
                                ' . $row['ubicacion'] . '
                              </option>';
                            }
                            ?>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- UBICACIÓN -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Ubicación<span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="ubicacion"
                            name="ubicacion">

                            <option value="">Seleccionar</option>

                            <?php
                            $sql = "SELECT id_ubicacion, ubicacion_unidad FROM ubicaciones WHERE activo = 1";
                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_ubicacion'] . '">
                                ' . $row['ubicacion_unidad'] . '
                              </option>';
                            }
                            ?>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- CIUDAD -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Ciudad<span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            class="form-control input-moderno"
                            id="ciudad"
                            name="ciudad">
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- MUNICIPIO -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Municipio<span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            class="form-control input-moderno"
                            id="municipio"
                            name="municipio">
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- FECHA -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Fecha adquisición
                        </label>

                        <input type="date"
                            class="form-control input-moderno"
                            id="fechaadquisicion"
                            name="fechaadquisicion">

                    </div>

                    <!-- TIPO ADQUISICION -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Tipo adquisición<span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="tipoadquisicion"
                            name="tipoadquisicion">

                            <option value="">Seleccionar</option>

                            <?php
                            $sql = "SELECT id_tipo_adquisicion, nombre_tipo_adquisicion 
                            FROM tipo_adquisicion";

                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_tipo_adquisicion'] . '">
                                ' . $row['nombre_tipo_adquisicion'] . '
                              </option>';
                            }
                            ?>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                    <!-- ARRENDADORA -->
                    <div class="col-md-4">

                        <label class="form-label label-form">
                            Arrendadora<span class="text-danger">*</span>
                        </label>

                        <select class="form-select input-moderno"
                            id="arrendadora"
                            name="arrendadora">

                            <option value="">Seleccionar</option>

                            <?php
                            $sql = "SELECT id_arrendadora, arrendadora 
                            FROM arrendadora";

                            $result = $conexion->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_arrendadora'] . '">
                                ' . $row['arrendadora'] . '
                              </option>';
                            }
                            ?>

                        </select>
                        <small class="text-danger">Campo obligatorio</small>

                    </div>

                </div>

            </div>

            <!-- ========================================= -->
            <!-- IMAGEN -->
            <!-- ========================================= -->

            <div class="panel-acciones-final p-4 mb-5">

                <div class="titulo-seccion-orange mb-4">

                    <div class="icono-seccion">
                        <i class="fa-solid fa-image"></i>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">
                            Imagen de la unidad
                        </h5>

                        <small>
                            Fotografía de referencia
                        </small>
                    </div>

                </div>

                <div class="row align-items-center g-4">

                    <div class="col-md-8">

                        <input type="file"
                            class="form-control input-moderno"
                            id="imagen_unidad"
                            name="imagen_unidad"
                            accept="image/*">

                    </div>

                    <div class="col-md-4">

                        <button type="button"
                            class="btn btn-orange w-100 py-3"
                            id="btnregistrarunidad">

                            <i class="fa-solid fa-check me-2"></i>
                            Registrar unidad

                        </button>

                    </div>

                </div>

            </div>

    </div>

    </form>
</div>

<script>
    document.getElementById('marcaunidad').addEventListener('change', function() {

        const marcaId = this.value;

        fetch('../../Servidor/solicitudes/unidades/obtener_modelos.php?marca_id=' + marcaId)

            .then(response => response.json())

            .then(data => {

                const modeloSelect = document.getElementById('modelounidad');

                modeloSelect.innerHTML = '<option value="">Seleccionar</option>';

                data.forEach(modelo => {

                    const option = document.createElement('option');

                    option.value = modelo.id_modelo;
                    option.text = modelo.nombre_modelo;

                    modeloSelect.appendChild(option);

                });

            })

            .catch(error => {

                console.error('Error al cargar modelos:', error);

            });

    });
</script>