<!-- CONTENEDOR PRINCIPAL -->
<div class="container-fluid px-3 px-md-4 mt-4">


    <!-- HEADER -->
    <section class="ldr-page-header">

        <div>
            <span class="ldr-page-badge">
                GESTIÓN DE MANTENIMIENTOS
            </span>

            <h1 class="ldr-page-title">
                Administra los mantenimientos
            </h1>

            <p class="ldr-page-subtitle">
                Registro y administración mantenimientos.
            </p>
        </div>

    </section>
</div>


<div class="contenedor_botones">
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary me-2" id="btnNewMaintenance">
            <i class="bi bi-plus-lg"></i> Nuevo mantenimiento
        </button>
    </div>

</div>


<div class="container">
    <!-- Dashboard Cards -->
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="mb-1">Mantenimientos este mes</h6>
                <h3 id="cardThisMonth">0</h3>
                <p class="small-muted mb-0">Total procedimientos registrados</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="mb-1">Unidades fuera de servicio</h6>
                <h3 id="cardOutOfService">0</h3>
                <p class="small-muted mb-0">Actualmente en taller</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="mb-1">Costo total (mes)</h6>
                <h3 id="cardCost">$0</h3>
                <p class="small-muted mb-0">MXN</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="mb-1">Preventivos vs Correctivos</h6>
                <h5 id="cardAvgDays">0</h5>
                <p class="small-muted mb-0">Porcentaje de mantenimientos</p>
            </div>
        </div>
    </div>

    <!-- Tabla mantenimientos -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="p-3 border rounded">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Bitácora de mantenimientos</h5>
                    <button class="btn btn-sm btn-outline-secondary" id="exportCsv">
                        <i class="bi bi-download"></i> Exportar CSV
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="maintTable">
                        <thead class="table-light">
                            <tr>
                                <th class="txtmantenimientos">Id</th>
                                <th class="txtmantenimientos">Modelo</th>
                                <th class="txtmantenimientos">VIN</th>
                                <th class="txtmantenimientos">Tipo mantenimiento</th>
                                <th class="txtmantenimientos">Estatus</th>
                                <th class="txtmantenimientos">Ingreso</th>
                                <th class="txtmantenimientos">Salida</th>
                                <th class="txtmantenimientos">Kilometraje</th>
                                <th class="txtmantenimientos">Taller</th>
                                <th class="txtmantenimientos">Costo</th>
                                <th class="txtmantenimientos">Descripción</th>
                                <th class="txtmantenimientos">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="maintBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <!-- Gráficas -->
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <h5 class="text-center mb-3 fw-semibold">Resumen de mantenimientos</h5>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card shadow-sm p-3">
                    <h6 class="text-center mb-3">Mantenimientos por tipo</h6>
                    <div class="chart-container" style="position: relative; height:280px;">
                        <canvas id="chartTypes"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card shadow-sm p-3">
                    <h6 class="text-center mb-3">Mantenimientos por estatus</h6>
                    <div class="chart-container" style="position: relative; height:280px;">
                        <canvas id="chartStatus"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card shadow-sm p-3">
                    <h6 class="text-center mb-3">Unidades con y sin telemetría</h6>
                    <div class="chart-container" style="position: relative; height:280px;">
                        <canvas id="chartTelemetria" style="height:300px;"></canvas>
                        <button class="btn btn-secondary" id="exportTelemetriaCsv">Exportar CSV Telemetría</button>
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