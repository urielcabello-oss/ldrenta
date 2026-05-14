
<!-- Modal: Registrar mantenimiento -->
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
                            <input type="number" name="km_manual" id="editKmInput" class="form-control" required readonly>
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
                            <input type="file" name="factura" id="editFacturaFile" class="form-control" accept=".pdf,.jpg,.png">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estatus</label>
                            <select name="id_estatus_mantenimiento" id="editEstatus" class="form-select" required>
                                <option value="">-- Seleccionar estatus --</option>
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