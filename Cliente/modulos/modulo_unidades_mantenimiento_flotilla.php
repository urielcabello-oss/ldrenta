<!-- ===================================================== -->
<!-- CONTENEDOR PRINCIPAL -->
<!-- ===================================================== -->

<div class="ldr-dashboard">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <section class="ldr-maintenance-header">

        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">

            <div>

                <span class="ldr-page-badge">
                    MANTENIMIENTOS FLOTILLA
                </span>

                <h1 class="ldr-page-title">
                    Dashboard de mantenimientos
                </h1>

                <p class="ldr-page-subtitle">
                    Control y administración de servicios preventivos, correctivos y mixtos.
                </p>

            </div>

            <div>

                <button class="btn ldr-btn-primary" id="btnNewMaintenance">
                    <i class="bi bi-plus-circle me-2"></i>
                    Nuevo mantenimiento
                </button>

                <button class="btn ldr-btn-secondary" id="btnNuevoTaller">
                    <i class="bi bi-plus-circle me-2"></i>
                    Alta de talleres
                </button>

            </div>

        </div>

    </section>

    <!-- ===================================================== -->
    <!-- CARDS -->
    <!-- ===================================================== -->

    <div class="row g-3 mt-1">

        <div class="col-xl-3 col-md-6">

            <div class="ldr-card-mini">

                <div class="ldr-icon-card bg-primary-subtle text-primary">
                    <i class="bi bi-tools"></i>
                </div>

                <div>

                    <small class="text-muted">
                        Este mes
                    </small>

                    <h5 id="cardThisMonth" class="fw-bold mb-0">
                        0
                    </h5>

                    <span class="small text-muted">
                        mantenimientos
                    </span>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="ldr-card-mini">

                <div class="ldr-icon-card bg-danger-subtle text-danger">
                    <i class="bi bi-truck"></i>
                </div>

                <div>

                    <small class="text-muted">
                        Fuera de servicio
                    </small>

                    <h5 id="cardOutOfService" class="fw-bold mb-0">
                        0
                    </h5>

                    <span class="small text-muted">
                        en taller
                    </span>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="ldr-card-mini">

                <div class="ldr-icon-card bg-success-subtle text-success">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <div>

                    <small class="text-muted">
                        Costo total
                    </small>

                    <h5 id="cardCost" class="fw-bold mb-0">
                        $0
                    </h5>

                    <span class="small text-muted">
                        MXN
                    </span>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="ldr-card-mini">

                <div class="ldr-icon-card bg-warning-subtle text-warning">
                    <i class="bi bi-bar-chart"></i>
                </div>

                <div>

                    <small class="text-muted">
                        Preventivos
                    </small>

                    <h5 id="cardAvgDays" class="fw-bold mb-0">
                        0%
                    </h5>

                    <span class="small text-muted">
                        vs correctivos
                    </span>

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- TABLA -->
    <!-- ===================================================== -->
     <div style="padding-top: 20px;">

    <section class="ldr-table-card">

        <div class="ldr-table-header">

            <div>

                <h2>
                    Bitácora de mantenimientos
                </h2>

                <p>
                    Historial general de mantenimientos registrados.
                </p>

            </div>



            <button class="btn btn-outline-dark btn-sm rounded-pill" id="exportCsv">

                <i class="bi bi-download me-2"></i>
                Exportar CSV

            </button>



        </div>

        <div class="table-responsive">

            <table class="table align-middle ldr-table" id="maintTable">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Modelo</th>
                        <th>VIN</th>
                        <th>Tipo</th>
                        <th>Estatus</th>
                        <th>Ingreso</th>
                        <th>Salida</th>
                        <th>KM</th>
                        <th>Taller</th>
                        <th>Costo</th>
                        <th>Descripción</th>
                        <th class="text-center">Acciones</th>

                    </tr>

                </thead>

                <tbody id="maintBody"></tbody>

            </table>

        </div>

    </section>

    </div>

    <!-- ===================================================== -->
    <!-- GRAFICAS -->
    <!-- ===================================================== -->

    <div class="row g-4 mt-2">

        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">

                        <div class="ldr-chart-icon bg-primary-subtle text-primary">
                            <i class="bi bi-pie-chart"></i>
                        </div>

                        <div class="ms-3">

                            <h6 class="fw-bold mb-0">
                                Por tipo
                            </h6>

                            <small class="text-muted">
                                Preventivos y correctivos
                            </small>

                        </div>

                    </div>

                    <div style="height: 260px;">
                        <canvas id="chartTypes"></canvas>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">

                        <div class="ldr-chart-icon bg-success-subtle text-success">
                            <i class="bi bi-clipboard-check"></i>
                        </div>

                        <div class="ms-3">

                            <h6 class="fw-bold mb-0">
                                Estatus
                            </h6>

                            <small class="text-muted">
                                Seguimiento de servicios
                            </small>

                        </div>

                    </div>

                    <div style="height: 260px;">
                        <canvas id="chartStatus"></canvas>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">

                        <div class="ldr-chart-icon bg-warning-subtle text-warning">
                            <i class="bi bi-wifi"></i>
                        </div>

                        <div class="ms-3">

                            <h6 class="fw-bold mb-0">
                                Telemetría
                            </h6>

                            <small class="text-muted">
                                Unidades conectadas
                            </small>

                        </div>

                    </div>

                    <div style="height: 260px;">
                        <canvas id="chartTelemetria"></canvas>
                    </div>

                    <div class="mt-3">

                        <button class="btn btn-outline-secondary btn-sm rounded-pill w-100" id="exportTelemetriaCsv">

                            <i class="bi bi-download me-2"></i>
                            Exportar CSV

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!--js para realizar el modulo de los mantenimientos-->
<script src="../js/modulo_mantenimientos_flotilla/modulo_mantenimientos_flotilla.js"></script>
<!--js para realizar el modulo editar los mantenimientos-->
<script src="../js/modulo_mantenimientos_flotilla/mantenimientos_flotilla_editar.js"></script>