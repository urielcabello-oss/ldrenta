<div class="row g-4">

    <?php
    include("../../Servidor/conexion.php");
    ?>

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="titulo-seccion-orange">

            <div class="icono-seccion">
                <i class="fas fa-shield-halved"></i>
            </div>

            <div>
                <h5 class="mb-1 fw-bold">
                    Registro de póliza
                </h5>

                <small>
                    Información general del seguro de la unidad
                </small>
            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- ASEGURADORA -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="ldr-form-section">

            <div class="ldr-section-title">
                <i class="fas fa-building-shield"></i>
                Aseguradora
            </div>

            <div class="row g-3">

                <!-- ASEGURADORA -->

                <!-- MARCA -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Aseguradora <span class="text-danger">*</span>
                    </label>

                    <select class="form-select input-moderno"
                        id="nombreaseguradora"
                        name="nombreaseguradora">

                        <option value="">Seleccionar aseguradora</option>

                        <?php

                        $sql = "SELECT id_aseguradora, aseguradora FROM aseguradoras";
                        $result = $conectar->query($sql);

                        while ($row = $result->fetch_assoc()) {

                            echo '
                                <option value="' . $row['id_aseguradora'] . '">
                                    ' . $row['aseguradora'] . '
                                </option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- IDENTIFICADOR -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Identificador
                    </label>
                    <input type="text"
                        class="form-control input-moderno"
                        id="identificadopolizaseguro"
                        name="identificadopolizaseguro"
                        placeholder="Identificador">
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- FECHAS -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="ldr-form-section">

            <div class="ldr-section-title">
                <i class="fas fa-calendar-days"></i>
                Vigencia
            </div>

            <div class="row g-3">

                <!-- FECHA ALTA -->
                <div class="col-md-6">
                    <label class="form-label label-form">
                        Fecha de alta
                    </label>
                    <input type="date"
                        class="form-control input-moderno"
                        id="fechaaltaseguro"
                        name="fechaaltaseguro">
                </div>

                <!-- FECHA VENCIMIENTO -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Fecha de vencimiento
                    </label>
                    <input type="date"
                        class="form-control input-moderno"
                        id="fechavencimientoaseguradora"
                        name="fechavencimientoaseguradora">
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- ESTADO -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="ldr-form-section">

            <div class="ldr-section-title">
                <i class="fas fa-circle-check"></i>
                Estado y estatus
            </div>

            <div class="row g-3">
                <!-- ESTADO -->
                <div class="col-md-6">
                    <label class="form-label label-form">
                        Estado
                    </label>
                    <select class="form-select input-moderno"
                        id="estadoaseguradora"
                        name="estadoaseguradora">
                        <option value="">
                            Seleccionar estado
                        </option>
                        <?php
                        $sql = "SELECT id_estado_aseguradora, estado_aseguradora 
                                    FROM estado_aseguradora";
                        $result = $conectar->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            echo '
                                <option value="' . $row['id_estado_aseguradora'] . '">
                                    ' . $row['estado_aseguradora'] . '
                                </option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- ESTATUS -->
                <div class="col-md-6">
                    <label class="form-label label-form">
                        Estatus
                    </label>

                    <select class="form-select input-moderno"
                        id="estatusaseguradora"
                        name="estatusaseguradora">

                        <option value="">
                            Seleccionar estatus
                        </option>
                        <?php
                        $sql = "SELECT id_estatus_aseguradora, estatus 
                                    FROM estatus_aseguradora";

                        $result = $conectar->query($sql);

                        while ($row = $result->fetch_assoc()) {

                            echo '
                                <option value="' . $row['id_estatus_aseguradora'] . '">
                                    ' . $row['estatus'] . '
                                </option>';
                        }
                        ?>
                    </select>
                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- DOCUMENTO -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="ldr-form-section">

            <div class="ldr-section-title">
                <i class="fas fa-file-pdf"></i>
                Documento PDF
            </div>

            <div class="row">

                <div class="col-md-12">

                    <label for="documento_poliza"
                        class="upload-box-modern">
                        

                        <div class="upload-box-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>

                        <h6 class="mb-1">
                            Cargar póliza PDF
                        </h6>

                        <small>
                            Arrastra el archivo o haz clic aquí
                        </small>

                        <input type="file"
                            class="form-control input-moderno"
                            id="documento_poliza"
                            name="documento_poliza"
                            accept=".pdf">

                    </label>

                </div>

            </div>

        </div>

    </div>

</div>