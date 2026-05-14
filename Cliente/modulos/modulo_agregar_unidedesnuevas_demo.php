<div class="container-fluid px-3 px-md-4 mt-4">

    <!-- HEADER PRINCIPAL -->
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

            <div class="d-flex gap-2 flex-wrap">

                <button type="button"
                    class="btn btn-light btn-modern border"
                    onclick="window.history.back();">

                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Regresar
                </button>

            </div>

        </div>

    </div>

    <!-- =========================== -->
    <!-- MARCA Y MODELO -->
    <!-- =========================== -->

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
                    Información principal de identificación de la unidad
                </small>
            </div>
        </div>

        <div class="row g-4">

            <!-- Marca -->
            <div class="col-md-6">

                <label class="form-label label-form">
                    Marca <span class="text-danger">*</span>
                </label>

                <select class="form-select input-moderno"
                    id="marcaunidad"
                    name="marcaunidades">

                    <option value="">Seleccionar</option>

                    <?php
                    $sql = "SELECT id_marca, nombre_marca FROM marcas WHERE id_marca = 1";
                    $result = $conectar->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_marca'] . '">' . $row['nombre_marca'] . '</option>';
                    }
                    ?>

                </select>

            </div>

            <!-- Modelo -->
            <div class="col-md-6">

                <label class="form-label label-form">
                    Modelo <span class="text-danger">*</span>
                </label>

                <select class="form-select input-moderno"
                    id="modelounidad"
                    name="modelounidades">

                    <option value="">Seleccionar</option>

                </select>

            </div>

            <script>
                document.getElementById('marcaunidad').addEventListener('change', function() {
                    const marcaId = this.value;

                    fetch('../../Servidor/solicitudes/unidades/obtener_modelos.php?marca_id=' + marcaId)
                        .then(response => response.json())
                        .then(data => {
                            const modeloSelect = document.getElementById('modelounidad');
                            modeloSelect.innerHTML = '<option value="">Seleccionar</option>'; // limpia anteriores

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

        </div>

    </div>

    <!-- =========================== -->
    <!-- DATOS GENERALES -->
    <!-- =========================== -->

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
                    Información administrativa y técnica de la unidad
                </small>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-md-4">

                <label class="form-label label-form">
                    Costo neto
                </label>

                <input type="number"
                    class="form-control input-moderno"
                    id="tarjetacirculacionunidad">

            </div>

            <div class="col-md-4">

                <label class="form-label label-form">
                    Paso diferencial
                </label>

                <input type="text"
                    class="form-control input-moderno"
                    id="paso_diferencial">

            </div>

            <div class="col-md-4">

                <label class="form-label label-form">
                    Placa <span class="text-danger">*</span>
                </label>

                <input type="text"
                    class="form-control input-moderno"
                    id="placaunidad">

            </div>

            <div class="col-md-4">

                <label class="form-label label-form">
                    VIN <span class="text-danger">*</span>
                </label>

                <input type="text"
                    class="form-control input-moderno"
                    id="VIN">

            </div>

            <div class="col-md-4">

                <label class="form-label label-form">
                    Número de motor
                </label>

                <input type="text"
                    class="form-control input-moderno"
                    id="motorunidad">

            </div>

            <div class="col-md-4">

                <label class="form-label label-form">
                    Año de la unidad
                </label>

                <input type="number"
                    class="form-control input-moderno"
                    id="añounidad">

            </div>

        </div>

    </div>

    <!-- =========================== -->
    <!-- ESTADO Y ESTATUS -->
    <!-- =========================== -->

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
                    Configuración operativa de la unidad
                </small>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-md-4">

                <label class="form-label label-form">
                    Estado de unidad
                </label>

                <select class="form-select input-moderno"
                    id="estadounidad">

                    <option value="">Seleccionar</option>

                    <?php
                    $sql = "SELECT id_estado_unidad, estado FROM estado_unidad";
                    $result = $conexion->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_estado_unidad'] . '">' . $row['estado'] . '</option>';
                    }
                    ?>

                </select>

            </div>

            <div class="col-md-4">

                <label class="form-label label-form">
                    Estatus
                </label>

                <select class="form-select input-moderno"
                    id="estatusunidad">

                    <option value="">Seleccionar</option>

                    <?php
                    $sql = "SELECT id_estatus_unidad, estatus FROM estatus_unidades";
                    $result = $conexion->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_estatus_unidad'] . '">' . $row['estatus'] . '</option>';
                    }
                    ?>

                </select>

            </div>

            <div class="col-md-4">

                <label class="form-label label-form">
                    Tipo de unidad
                </label>

                <select class="form-select input-moderno"
                    id="tipounidad">

                    <option value="">Seleccionar</option>

                    <?php

                    $sql = "SELECT id_tipo_unidad, tipo_unidad FROM tipo_unidad";

                    $result = $conexion->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_tipo_unidad'] . '">' . $row['tipo_unidad'] . '</option>';
                    }
                    ?>


                </select>

            </div>

        </div>

    </div>

    <!-- =========================== -->
    <!-- UBICACION -->
    <!-- =========================== -->

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
                    Datos administrativos de adquisición
                </small>
            </div>

        </div>

        <div class="row g-4">

            <div class="col-md-4">

                <label class="form-label label-form">
                    Sede
                </label>

                <select class="form-select input-moderno"
                    id="sedeunidad">

                    <option value="">Seleccionar</option>

                    <?php
                    $sql = "SELECT id_sede, ubicacion FROM sedes";
                    $result = $conectar->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_sede'] . '">' . $row['ubicacion'] . '</option>';
                    }
                    ?>

                </select>

            </div>

            <div class="col-md-4">

                <label class="form-label label-form">
                    Fecha adquisición
                </label>

                <input type="date"
                    class="form-control input-moderno"
                    id="fechaadquisicionunidad">

            </div>

            <div class="col-md-4">

                <label class="form-label label-form">
                    Folio factura
                </label>

                <input type="number"
                    class="form-control input-moderno"
                    id="foliofactura">

            </div>

        </div>

    </div>

    <!-- =========================== -->
    <!-- IMAGEN -->
    <!-- =========================== -->

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
                    Fotografía de referencia de la unidad
                </small>
            </div>

        </div>

        <div class="row align-items-center g-4">

            <div class="col-md-8">

                <input type="file"
                    class="form-control input-moderno"
                    id="imagen_unidad"
                    accept="image/*">

            </div>

            <div class="col-md-4">

                <button class="btn btn-orange w-100 py-3"
                    id="btnregistrarunidad">

                    <i class="fa-solid fa-check me-2"></i>
                    Registrar unidad

                </button>

            </div>

        </div>

    </div>


    <style>


    </style>