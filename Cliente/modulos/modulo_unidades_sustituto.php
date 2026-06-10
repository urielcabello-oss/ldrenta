<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<div class="container-fluid px-3 px-md-4 mt-4">

    <!-- HEADER -->
    <section class="ldr-page-header">

        <div>
            <span class="ldr-page-badge">
                GESTIÓN DE UNIDADES SUSTITUTO
            </span>

            <h1 class="ldr-page-title">
                Unidades sustituto
            </h1>

            <p class="ldr-page-subtitle">
                Asignación de unidades que pueden sustituirse.
            </p>
        </div>


        <div class="ldr-header-actions">

            <button type="button"
                class="btn btn-light btn-modern border"
                onclick="window.history.back();">

                <i class="fa-solid fa-arrow-left me-2"></i>
                Regresar

            </button>



        </div>


    </section>


    <div id="panelAltaUnidad">

        <!-- UNIDAD PRINCIPAL -->
        <div class="panel-acciones-final p-4 mb-4">

            <div class="titulo-seccion-orange mb-4">

                <div class="icono-seccion">
                    <i class="fa-solid fa-car-side"></i>
                </div>

                <div>
                    <h5 class="mb-0 fw-bold">
                        Unidad principal
                    </h5>

                    <small>
                        Selecciona la unidad principal
                    </small>
                </div>

            </div>

            <div class="row g-4">
                <!-- UNIDAD PRINCIPAL -->
                <div class="col-md-8">
                    <label class="form-label label-form">
                        Unidad Principal<span class="text-danger">*</span>
                    </label>

                    <select class="form-select input-moderno"
                        id="unidadPrincipal"
                        name="unidadPrincipal">

                        <option value="">Seleccionar</option>
                    </select>
                    <small class="text-danger">Campo obligatorio</small>
                </div>

            </div>

        </div>

        <!-- RESUMEN -->
        <div class="col-12">

            <div class="card border-0 bg-light">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <h6>
                                Total seleccionadas
                            </h6>

                            <span
                                id="contadorSeleccionadas"
                                class="badge bg-success fs-6">

                                0

                            </span>

                        </div>

                        <div class="col-md-6 text-md-end">

                            <button
                                class="btn btn-primary"
                                id="btnGuardarSustitutos">

                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                Guardar asignaciones

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- UNIDADES SUSTITUTAS -->
        <section class="ldr-table-card">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="mb-0">
                            <i class="fa-solid fa-arrows-rotate text-success me-2"></i>
                            Unidades sustitutas
                        </h5>

                        <div style="max-width:300px;">

                            <input
                                type="text"
                                id="buscarUnidad"
                                class="form-control"
                                placeholder="Buscar unidad...">

                        </div>

                    </div>

                    <div class="table-responsive">

                        <table class="table align-middle ldr-table" id="tablaSustitutas">

                            <thead>

                                <tr>

                                    <th width="60">
                                        Seleccionar
                                    </th>

                                    <th>
                                        Unidad
                                    </th>

                                    <th>
                                        Placa
                                    </th>

                                    <th>
                                        VIN
                                    </th>

                                    <th>
                                        Sede
                                    </th>

                                </tr>

                            </thead>

                            <tbody id="tablaUnidadesSustitutas">

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </section>

        <br>

        <!-- UNIDADES SUSTITUTAS -->
        <section class="ldr-table-card mt-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="mb-0">
                            <i class="fa-solid fa-link text-primary me-2"></i>
                            Relaciones actuales de sustitución
                        </h5>

                    </div>

                    <div
                        class="accordion"
                        id="accordionRelaciones">

                    </div>

                </div>

            </div>

        </section>
    </div>
</div>