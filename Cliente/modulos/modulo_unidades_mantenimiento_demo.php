<div class="contenedorvalidacionunidades">
    <h5 class="titulosletrasunidades text-nowrap">
        <a class="navbar-brand" href="#"><i class="bi bi-tools"></i> Flotilla - Mantenimientos (Demo)</a>
    </h5>
    <h4 class="letravalidacionunidadresponsiva text-nowrap"></h4>
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

<!-- Modal: Registrar / Editar mantenimiento -->
<div class="modal fade" id="maintenanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="maintenanceForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="maintenanceModalLabel">Nuevo mantenimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Unidad</label>
                            <input type="text" id="unidadInput" class="form-control" placeholder="Buscar unidad por VIN, modelo o placas">
                            <input type="hidden" name="id_unidad" id="unidadIdInput">
                            <div id="unidadList" class="list-group position-absolute w-100" style="z-index:1000;"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de mantenimiento</label>
                            <select id="tipoInput" name="id_tipo_mantenimiento" class="form-select" required>
                                <option value="">-- Seleccionar tipo --</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kilometraje actual</label>
                            <input type="number" name="km_actual" id="kmInput" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha ingreso</label>
                            <input type="date" name="fecha_ingreso" id="fechaIngreso" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha estimada salida</label>
                            <input type="date" name="fecha_salida" id="fechaSalida" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Taller</label>
                            <input type="text" name="taller" id="tallerInput" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Costo estimado</label>
                            <input type="number" name="costo_estimado" id="costoInput" class="form-control" step="0.01">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descripción del trabajo</label>
                            <textarea name="descripcion_trabajo" id="descInput" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Programar próximo mantenimiento</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="number" name="proximo_km" id="proximoKm" class="form-control" placeholder="Km (ej. 5000)">
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="proximo_fecha" id="proximoFecha" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar mantenimiento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Editar mantenimiento -->
<div class="modal fade" id="editMaintenanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editMaintenanceForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMaintenanceModalLabel">Editar mantenimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Unidad</label>
                            <input type="text" id="editUnidadInput" class="form-control" readonly>
                            <!-- Oculto: ID mantenimiento -->
                            <input type="hidden" id="editIdMantenimiento" name="id_mantenimiento">
                            <input type="hidden" name="id_unidad" id="editUnidadIdInput">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de mantenimiento</label>
                            <select id="editTipoInput" name="id_tipo_mantenimiento" class="form-select" required>
                                <option value="">-- Seleccionar tipo --</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kilometraje</label>
                            <input type="number" name="km_manual" id="editKmInput" class="form-control" required disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha ingreso</label>
                            <input type="date" name="fecha_ingreso" id="editFechaIngreso" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha estimada salida</label>
                            <input type="date" name="fecha_salida" id="editFechaSalida" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Taller</label>
                            <input type="text" name="taller" id="editTallerInput" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Costo estimado</label>
                            <input type="number" name="costo_estimado" id="editCostoInput" class="form-control" step="0.01">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descripción del trabajo</label>
                            <textarea name="descripcion_trabajo" id="editDescInput" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Factura (adjuntar archivo)</label>
                            <input type="file" name="factura_file" id="editFacturaFile" class="form-control" accept=".pdf,.jpg,.png">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estatus</label>
                            <select name="estatus" id="editEstatus" class="form-select">
                                <option value="">-- Seleccionar estatus --</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="En proceso">En proceso</option>
                                <option value="Finalizado">Finalizado</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Programar próximo mantenimiento</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="number" name="proximo_km" id="editProximoKm" class="form-control" placeholder="Km (ej. 5000)">
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="proximo_fecha" id="editProximoFecha" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar mantenimiento</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!--js para realizar el modulo de los mantenimientos-->
<script src="../js/modulo_mantenimientos_demos/modulo_mantenimientos_demo.js"></script>
<!--js para realizar el modulo editar los mantenimientos-->
<script src="../js/modulo_mantenimientos_demos/mantenimientos_demo_editar.js"></script>