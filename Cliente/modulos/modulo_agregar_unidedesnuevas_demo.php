<form id="formRegistrarUnidadDemo" enctype="multipart/form-data">

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

            <button type="button"
                    class="btn btn-light btn-modern border"
                    onclick="window.history.back();">

                <i class="fa-solid fa-arrow-left me-2"></i>
                Regresar

            </button>

        </div>

    </div>

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
                    $sql = "SELECT id_marca, nombre_marca FROM marcas";
                    $result = $conexion->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_marca'] . '">
                                ' . $row['nombre_marca'] . '
                              </option>';
                    }
                    ?>

                </select>

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

            <!-- COSTO -->
            <div class="col-md-4">

                <label class="form-label label-form">
                    Costo neto
                </label>

                <input type="number"
                       step="0.01"
                       class="form-control input-moderno"
                       id="costoneto"
                       name="costoneto">

            </div>

            <!-- COLOR -->
            <div class="col-md-4">

                <label class="form-label label-form">
                    Color
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

            </div>

            <!-- MOTOR -->
            <div class="col-md-4">

                <label class="form-label label-form">
                    Número de motor
                </label>

                <input type="text"
                       class="form-control input-moderno"
                       id="motorunidad"
                       name="motorunidad">

            </div>

            <!-- AÑO -->
            <div class="col-md-4">

                <label class="form-label label-form">
                    Año de la unidad
                </label>

                <input type="number"
                       class="form-control input-moderno"
                       id="anounidad"
                       name="anounidad">

            </div>

            <!-- PASO DIFERENCIAL -->
            <div class="col-md-4">

                <label class="form-label label-form">
                    Paso diferencial
                </label>

                <input type="number"
                       step="0.01"
                       class="form-control input-moderno"
                       id="pasodiferencial"
                       name="pasodiferencial">

            </div>

            <!-- FOLIO FACTURA -->
            <div class="col-md-4">

                <label class="form-label label-form">
                    Folio factura
                </label>

                <input type="text"
                       class="form-control input-moderno"
                       id="foliofactura"
                       name="foliofactura">

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
                    Estado unidad
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

            </div>

            <!-- ESTATUS -->
            <div class="col-md-4">

                <label class="form-label label-form">
                    Estatus
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

            </div>

            <!-- TIPO -->
            <div class="col-md-4">

                <label class="form-label label-form">
                    Tipo unidad
                </label>

                <select class="form-select input-moderno"
                        id="tipounidad"
                        name="tipounidad">

                    <option value="">Seleccionar</option>

                    <?php

                    if ($id_tipo_usuario == 1) {
                        $sql = "SELECT id_tipo_unidad, tipo_unidad 
                                FROM tipo_unidad 
                                WHERE id_tipo_unidad != 3";
                    } else {
                        $sql = "SELECT id_tipo_unidad, tipo_unidad 
                                FROM tipo_unidad 
                                WHERE id_tipo_unidad = 3";
                    }

                    $result = $conexion->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_tipo_unidad'] . '">
                                ' . $row['tipo_unidad'] . '
                              </option>';
                    }
                    ?>

                </select>

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
                    Sede
                </label>

                <select class="form-select input-moderno"
                        id="sedeunidad"
                        name="sedeunidad">

                    <option value="">Seleccionar</option>

                    <?php
                    $sql = "SELECT id_sede, ubicacion FROM sedes";
                    $result = $conexion->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_sede'] . '">
                                ' . $row['ubicacion'] . '
                              </option>';
                    }
                    ?>

                </select>

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
                    Tipo adquisición
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

            </div>

            <!-- ARRENDADORA -->
            <div class="col-md-4">

                <label class="form-label label-form">
                    Arrendadora
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

<script>

document.getElementById('marcaunidad').addEventListener('change', function () {

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