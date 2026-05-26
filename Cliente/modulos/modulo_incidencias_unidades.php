<!-- ===================================================== -->
<!-- DASHBOARD INCIDENCIAS FLOTILLA -->
<!-- ===================================================== -->

<div class="ldr-incidencias-dashboard">

    <!-- ===================================================== -->
    <!-- HERO -->
    <!-- ===================================================== -->

    <section class="ldr-incidencias-hero">

        <div class="row align-items-center g-4">

            <div class="col-xl-7">

                <div class="ldr-hero-content">

                    <span class="ldr-page-badge">

                        <i class="bi bi-shield-exclamation me-2"></i>
                        INCIDENCIAS

                    </span>

                    <h1 class="ldr-page-title">

                        Centro de incidencias operativas

                    </h1>

                    <p class="ldr-page-subtitle">

                        Gestión y monitoreo de accidentes, daños, robos y eventos operativos registrados en unidades.

                    </p>

                    <div class="d-flex flex-wrap gap-2 mt-4">

                        <button class="btn btn ldr-btn-primary"
                                id="btnNuevaIncidencia">

                            <i class="bi bi-plus-circle me-2"></i>
                            Nueva incidencia

                        </button>

                    </div>

                </div>

            </div>

            <!-- PANEL DERECHO -->
            <div class="col-xl-5">

                <div class="ldr-hero-alert-card">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <span class="ldr-alert-mini-title">

                                ALERTAS ACTIVAS

                            </span>

                            <h3 class="ldr-alert-main-number"
                                id="cardAbiertas">

                                0

                            </h3>

                            <p class="mb-0 text-muted small">

                                incidencias abiertas actualmente

                            </p>

                        </div>

                        <div class="ldr-alert-icon">

                            <i class="bi bi-exclamation-octagon"></i>

                        </div>

                    </div>

                    <hr>

                    <div class="row text-center">

                        <div class="col-4">

                            <small class="text-muted d-block">
                                Accidentes
                            </small>

                            <strong id="cardAccidentes">
                                0
                            </strong>

                        </div>

                        <div class="col-4">

                            <small class="text-muted d-block">
                                Robos
                            </small>

                            <strong id="cardRobos">
                                0
                            </strong>

                        </div>

                        <div class="col-4">

                            <small class="text-muted d-block">
                                Total
                            </small>

                            <strong id="cardTotalIncidencias">
                                0
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- ===================================================== -->
    <!-- RESUMEN -->
    <!-- ===================================================== -->

    <div class="row g-4 mt-1">

        <!-- CARD -->
        <div class="col-xl-3 col-md-6">

            <div class="ldr-inc-card">

                <div class="ldr-inc-card-top">

                    <div class="ldr-inc-icon bg-primary-subtle text-primary">

                        <i class="bi bi-clipboard-data"></i>

                    </div>

                    <span class="ldr-status-pill bg-primary-subtle text-primary">

                        GENERAL

                    </span>

                </div>

                <h3 id="cardTotalIncidencias2">
                    0
                </h3>

                <p>
                    incidencias registradas
                </p>

            </div>

        </div>

        <!-- CARD -->
        <div class="col-xl-3 col-md-6">

            <div class="ldr-inc-card">

                <div class="ldr-inc-card-top">

                    <div class="ldr-inc-icon bg-warning-subtle text-warning">

                        <i class="bi bi-cone-striped"></i>

                    </div>

                    <span class="ldr-status-pill bg-warning-subtle text-warning">

                        PROCESO

                    </span>

                </div>

                <h3 id="cardProceso">
                    0
                </h3>

                <p>
                    incidencias en seguimiento
                </p>

            </div>

        </div>

        <!-- CARD -->
        <div class="col-xl-3 col-md-6">

            <div class="ldr-inc-card">

                <div class="ldr-inc-card-top">

                    <div class="ldr-inc-icon bg-success-subtle text-success">

                        <i class="bi bi-check-circle"></i>

                    </div>

                    <span class="ldr-status-pill bg-success-subtle text-success">

                        FINALIZADAS

                    </span>

                </div>

                <h3 id="cardFinalizadas">
                    0
                </h3>

                <p>
                    incidencias cerradas
                </p>

            </div>

        </div>

        <!-- CARD -->
        <div class="col-xl-3 col-md-6">

            <div class="ldr-inc-card">

                <div class="ldr-inc-card-top">

                    <div class="ldr-inc-icon bg-danger-subtle text-danger">

                        <i class="bi bi-car-front-fill"></i>

                    </div>

                    <span class="ldr-status-pill bg-danger-subtle text-danger">

                        CRÍTICAS

                    </span>

                </div>

                <h3 id="cardCriticas">
                    0
                </h3>

                <p>
                    prioridad alta / crítica
                </p>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- CONTENIDO -->
    <!-- ===================================================== -->

    <div class="row g-4 mt-2">

        <!-- ===================================================== -->
        <!-- TABLA -->
        <!-- ===================================================== -->

        <div class="col-xl-12">

            <div class="ldr-panel-card h-100">

                <div class="ldr-panel-header">

                    <div>

                        <h4>

                            <i class="bi bi-list-ul me-2"></i>
                            Bitácora de incidencias

                        </h4>

                        <p>

                            Seguimiento general de incidencias registradas.

                        </p>

                    </div>

                    <button class="btn btn-sm ldr-btn-incidencia-outline">

                        <i class="bi bi-funnel me-2"></i>
                        Filtros

                    </button>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle ldr-table">

                        <thead>

                            <tr>

                                <th>ID</th>
                                <th>Unidad</th>
                                <th>Tipo</th>
                                <th>Estatus</th>
                                <th>Prioridad</th>
                                <th>Fecha</th>
                                <th class="text-center">Acciones</th>

                            </tr>

                        </thead>

                        <tbody id="bodyIncidencias">

                            <!-- JS -->

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>





