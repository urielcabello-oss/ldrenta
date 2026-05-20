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
                <i class="fas fa-file-invoice-dollar"></i>
            </div>

            <div>
                <h5 class="mb-1 fw-bold">
                    Registro de tenencia
                </h5>

                <small>
                    Información fiscal y comprobante de pago de la unidad
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
                <i class="fas fa-receipt"></i>
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
                        id="foliotenencia"
                        name="foliotenencia"
                        placeholder="Folio de tenencia">

                </div>

                <!-- AÑO / SEMESTRE -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Año / semestre <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                        class="form-control input-moderno"
                        id="añotenencia"
                        name="añotenencia"
                        placeholder="Ejemplo: 2026-1">

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- ESTATUS Y MONTO -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="ldr-form-section">

            <div class="ldr-section-title">
                <i class="fas fa-money-check-dollar"></i>
                Estatus y monto de pago
            </div>

            <div class="row g-3">

                <!-- ESTATUS -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Estatus
                    </label>

                    <select class="form-select input-moderno"
                        id="estatustenencias"
                        name="estatustenencias">

                        <option value="">
                            Seleccionar estatus
                        </option>

                        <?php

                        $sql = "SELECT 
                                    id_estatus_tenencias,
                                    estatus
                                FROM estatus_tenencias";

                        $result = $conectar->query($sql);

                        while ($row = $result->fetch_assoc()) {

                            echo '
                                <option value="' . $row['id_estatus_tenencias'] . '">
                                    ' . $row['estatus'] . '
                                </option>';
                        }

                        ?>

                    </select>

                </div>

                <!-- MONTO -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Monto de pago
                    </label>

                    <input type="number"
                        class="form-control input-moderno"
                        id="montopago"
                        name="montopago"
                        placeholder="Monto"

                        oninput="
                        document.getElementById('MontoPago').innerText =
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

                    <small id="MontoPago"
                        class="text-dark fw-semibold ps-1">
                    </small>

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
                Fechas de pago y vencimiento
            </div>

            <div class="row g-3">

                <!-- FECHA PAGO -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Fecha de pago
                    </label>

                    <input type="date"
                        class="form-control input-moderno"
                        id="fechapago"
                        name="fechapago">

                </div>

                <!-- FECHA VENCIMIENTO -->
                <div class="col-md-6">

                    <label class="form-label label-form">
                        Fecha de vencimiento
                    </label>

                    <input type="date"
                        class="form-control input-moderno"
                        id="fechavencimiento"
                        name="fechavencimiento">

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

                    <label for="documento_poliza_tenencia"
                        class="upload-box-modern">

                        <div class="upload-box-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>

                        <h6 class="mb-1">
                            Cargar comprobante PDF
                        </h6>

                        <small>
                            Arrastra el archivo o haz clic aquí
                        </small>

                        <input type="file"
                            class="form-control input-moderno"
                            id="documento_poliza_tenencia"
                            name="documento_poliza_tenencia"
                            accept=".pdf">

                    </label>

                </div>

            </div>

        </div>

    </div>

</div>