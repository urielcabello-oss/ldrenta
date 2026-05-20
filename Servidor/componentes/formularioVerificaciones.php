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
                <i class="fas fa-clipboard-check"></i>
            </div>

            <div>
                <h5 class="mb-1 fw-bold">
                    Registro de verificación
                </h5>

                <small>
                    Información de verificaciones vehiculares
                </small>
            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- DATOS GENERALES -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="ldr-form-section">

            <div class="ldr-section-title">
                <i class="fas fa-file-signature"></i>
                Datos generales
            </div>

            <div class="row g-3">

                <!-- FOLIO -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Folio <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                        class="form-control input-moderno"
                        id="folioverificacion"
                        name="folioverificacion"
                        placeholder="Folio de verificación">

                </div>

                <!-- MONTO -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Monto
                    </label>

                    <input type="number"
                        class="form-control input-moderno"
                        id="montoverificacion"
                        name="montoverificacion"
                        placeholder="Monto de verificación"
                        oninput="
                            document.getElementById('MontoVerificacion').innerText =
                            this.value
                            ? parseFloat(this.value).toLocaleString(
                                'es-MX',
                                {
                                    style: 'currency',
                                    currency: 'MXN'
                                }
                              ) + ' MXN'
                            : '';
                        ">

                    <small id="MontoVerificacion"
                        class="text-muted fw-bold mt-1 d-block"></small>

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- AÑO Y SEMESTRE -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="ldr-form-section">

            <div class="ldr-section-title">
                <i class="fas fa-calendar-alt"></i>
                Año y semestre
            </div>

            <div class="row g-3">

                <!-- AÑO -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Año
                    </label>

                    <input type="number"
                        class="form-control input-moderno"
                        id="añoverificacion"
                        name="añoverificacion"
                        placeholder="Ejemplo: 2026">

                </div>

                <!-- SEMESTRE -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Semestre
                    </label>

                    <select class="form-select input-moderno"
                        id="semestreverificacion"
                        name="semestreverificacion">

                        <option value="">
                            Selecciona un semestre
                        </option>

                        <?php

                        $sql = "SELECT id_semestre, nombre_semestre 
                                FROM verificacion_semestre";

                        $result = $conectar->query($sql);

                        while ($row = $result->fetch_assoc()) {

                            echo '
                            <option value="' . $row['id_semestre'] . '">
                                ' . $row['nombre_semestre'] . '
                            </option>';
                        }

                        ?>

                    </select>

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
                <i class="fas fa-calendar-check"></i>
                Fechas de verificación
            </div>

            <div class="row g-3">

                <!-- FECHA VERIFICACION -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Fecha de verificación
                    </label>

                    <input type="date"
                        class="form-control input-moderno"
                        id="fechaverificacion"
                        name="fechaverificacion">

                </div>

                <!-- PROXIMA VERIFICACION -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Próxima verificación
                    </label>

                    <input type="date"
                        class="form-control input-moderno"
                        id="fechaproximaverificacion"
                        name="fechaproximaverificacion">

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- ESTATUS -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="ldr-form-section">

            <div class="ldr-section-title">
                <i class="fas fa-circle-check"></i>
                Estado de la verificación
            </div>

            <div class="row g-3">

                <div class="col-md-6">

                    <label class="form-label label-form">
                        Estatus
                    </label>

                    <select class="form-select input-moderno"
                        id="estatusverificacion"
                        name="estatusverificacion">

                        <option value="">
                            Seleccionar estatus
                        </option>

                        <?php

                        $sql = "SELECT id_estatus_verificacion, estatus 
                                FROM estatus_verificacion";

                        $result = $conectar->query($sql);

                        while ($row = $result->fetch_assoc()) {

                            echo '
                            <option value="' . $row['id_estatus_verificacion'] . '">
                                ' . $row['estatus'] . '
                            </option>';
                        }

                        ?>

                    </select>

                </div>

            </div>

        </div>

    </div>

</div>