<!-- ===================================================== -->
<!-- MODAL CREAR INCIDENCIA -->
<!-- ===================================================== -->

<div class="modal fade"
    id="modalCrearIncidencia"
    tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header ldr-modal-header">

                <div>

                    <h5 class="modal-title fw-bold mb-1">

                        Nueva incidencia

                    </h5>

                    <small class="opacity-75">

                        Registro operativo de incidencias

                    </small>

                </div>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <form id="formCrearIncidencia">

                    <div class="row g-4">

                        <!-- UNIDAD -->
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Unidad

                            </label>

                            <select class="form-select ldr-input"
                                name="id_unidad"
                                id="id_unidad"
                                required>

                                <option value="">
                                    Seleccione unidad
                                </option>

                            </select>

                        </div>

                        <!-- TIPO -->
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Tipo incidencia

                            </label>

                            <select class="form-select ldr-input"
                                name="tipo_incidencia">

                                <option value="ACCIDENTE">
                                    ACCIDENTE
                                </option>

                                <option value="DAÑO MENOR">
                                    DAÑO MENOR
                                </option>

                                <option value="ROBO TOTAL">
                                    ROBO TOTAL
                                </option>

                                <option value="ROBO AUTOPARTES">
                                    ROBO AUTOPARTES
                                </option>

                            </select>

                        </div>

                        <!-- PRIORIDAD -->
                        <div class="col-md-4">

                            <label class="form-label fw-semibold">

                                Prioridad

                            </label>

                            <select class="form-select ldr-input"
                                name="prioridad">

                                <option value="BAJA">
                                    BAJA
                                </option>

                                <option value="MEDIA">
                                    MEDIA
                                </option>

                                <option value="ALTA">
                                    ALTA
                                </option>

                                <option value="CRITICA">
                                    CRITICA
                                </option>

                            </select>

                        </div>

                        <!-- FECHA -->
                        <div class="col-md-4">

                            <label class="form-label fw-semibold">

                                Fecha incidencia

                            </label>

                            <input type="datetime-local"
                                class="form-control ldr-input"
                                name="fecha_incidencia">

                        </div>

                        <!-- UBICACION -->
                        <div class="col-md-4">

                            <label class="form-label fw-semibold">

                                Ubicación

                            </label>

                            <input type="text"
                                class="form-control ldr-input"
                                name="ubicacion">

                        </div>

                        <!-- TITULO -->
                        <div class="col-12">

                            <label class="form-label fw-semibold">

                                Título

                            </label>

                            <input type="text"
                                class="form-control ldr-input"
                                name="titulo"
                                required>

                        </div>

                        <!-- DESCRIPCION -->
                        <div class="col-12">

                            <label class="form-label fw-semibold">

                                Descripción

                            </label>

                            <textarea class="form-control ldr-input"
                                rows="5"
                                name="descripcion"></textarea>

                        </div>

                        <!-- CHECKS -->
                        <div class="col-12">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-check">

                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="requiere_taller"
                                            value="1">

                                        <label class="form-check-label">

                                            Requiere taller

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-check">

                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="requiere_seguro"
                                            value="1">

                                        <label class="form-check-label">

                                            Requiere seguro

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-check">

                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="requiere_juridico"
                                            value="1">

                                        <label class="form-check-label">

                                            Requiere jurídico

                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- EVIDENCIAS -->
                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Evidencias
                            </label>

                            <div class="card border-0 shadow-sm">

                                <div class="card-body">

                                    <input type="file"
                                        id="inputEvidencias"
                                        class="form-control ldr-input"
                                        multiple
                                        hidden>

                                    <button type="button"
                                        class="btn btn-outline-primary rounded-pill mb-3"
                                        id="btnAgregarEvidencias">

                                        <i class="bi bi-paperclip me-2"></i>
                                        Agregar archivos

                                    </button>

                                    <div id="listaEvidencias"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer border-0">

                <button class="btn btn-light rounded-pill px-4"
                    data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button class="btn ldr-btn-primary rounded-pill px-4"
                    id="btnGuardarIncidencia">

                    <i class="bi bi-save me-2"></i>
                    Guardar incidencia

                </button>

            </div>

        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- MODAL DETALLE -->
<!-- ===================================================== -->

<div class="modal fade"
    id="modalDetalleIncidencia"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header ldr-modal-header">

                <h5 class="modal-title fw-bold">

                    Detalle incidencia

                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <h4 id="detalleTitulo"></h4>

                <hr>

                <div class="row g-3">

                    <div class="col-md-6">

                        <small class="text-muted">
                            Unidad
                        </small>

                        <div id="detalleUnidad"></div>

                    </div>

                    <div class="col-md-6">

                        <small class="text-muted">
                            Estatus
                        </small>

                        <div id="detalleEstatus"></div>

                    </div>

                    <div class="col-md-6">

                        <small class="text-muted">
                            Prioridad
                        </small>

                        <div id="detallePrioridad"></div>

                    </div>

                </div>

                <hr>

                <div>

                    <small class="text-muted">

                        Descripción

                    </small>

                    <div id="detalleDescripcion"
                        class="p-3 bg-light rounded-4 mt-2"></div>

                    <hr>

                    <div>

                        <small class="text-muted">
                            Evidencias
                        </small>

                        <div id="detalleEvidencias"
                            class="mt-3">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- MODAL EDITAR -->
<!-- ===================================================== -->

<div class="modal fade"
    id="modalEditarIncidencia"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header ldr-modal-header">

                <h5 class="modal-title fw-bold">

                    Actualizar incidencia

                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <form id="formEditarIncidencia">

                    <input type="hidden"
                        id="editar_id_incidencia"
                        name="id_incidencia">

                    <div class="mb-3">

                        <label class="form-label">

                            Estatus

                        </label>

                        <select class="form-select"
                            id="editar_estatus"
                            name="estatus">

                            <option value="ABIERTA">
                                ABIERTA
                            </option>

                            <option value="EN_PROCESO">
                                EN PROCESO
                            </option>

                            <option value="RESUELTA">
                                RESUELTA
                            </option>

                            <option value="CERRADA">
                                CERRADA
                            </option>

                        </select>

                    </div>

                    <div>

                        <label class="form-label">

                            Observaciones

                        </label>

                        <textarea class="form-control"
                            rows="4"
                            id="editar_observaciones"
                            name="observaciones"></textarea>

                    </div>

                </form>

            </div>

            <div class="modal-footer border-0">

                <button class="btn btn-light"
                    data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button class="btn ldr-btn-primary"
                    id="btnActualizarIncidencia">

                    Actualizar

                </button>

            </div>

        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- MODAL GESTIONAR INCIDENCIA -->
<!-- ===================================================== -->

<div class="modal fade"
    id="modalGestionIncidencia"
    tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header ldr-modal-header">

                <h5 class="modal-title fw-bold">

                    Gestionar incidencia

                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <form id="formGestionIncidencia">

                    <input type="hidden"
                        id="gestion_id_incidencia">

                    <div class="row g-4">

                        <!-- PRIORIDAD -->
                        <div class="col-md-4">

                            <label class="form-label">

                                Prioridad

                            </label>

                            <select class="form-select"
                                id="gestion_prioridad">

                                <option value="BAJA">
                                    BAJA
                                </option>

                                <option value="MEDIA">
                                    MEDIA
                                </option>

                                <option value="ALTA">
                                    ALTA
                                </option>

                                <option value="CRITICA">
                                    CRITICA
                                </option>

                            </select>

                        </div>

                        <!-- TIPO -->
                        <div class="col-md-4">

                            <label class="form-label">

                                Tipo incidencia

                            </label>

                            <select class="form-select"
                                id="gestion_tipo">

                                <option value="ACCIDENTE">
                                    ACCIDENTE
                                </option>

                                <option value="DAÑO MENOR">
                                    DAÑO MENOR
                                </option>

                                <option value="ROBO TOTAL">
                                    ROBO TOTAL
                                </option>

                                <option value="ROBO AUTOPARTES">
                                    ROBO AUTOPARTES
                                </option>

                            </select>

                        </div>

                        <!-- TITULO -->
                        <div class="col-12">

                            <label class="form-label">

                                Título

                            </label>

                            <input type="text"
                                class="form-control"
                                id="gestion_titulo">

                        </div>


                        <!-- UBICACION -->
                        <div class="col-md-12">

                            <label class="form-label">

                                Ubicación

                            </label>

                            <input type="text"
                                class="form-control"
                                id="gestion_ubicacion">

                        </div>

                        <!-- DESCRIPCION -->
                        <div class="col-12">

                            <label class="form-label">

                                Descripción

                            </label>

                            <textarea class="form-control"
                                rows="4"
                                id="gestion_descripcion"></textarea>

                        </div>

                        <!-- CHECKS -->
                        <div class="col-12">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-check">

                                        <input class="form-check-input"
                                            type="checkbox"
                                            id="gestion_taller">

                                        <label class="form-check-label">

                                            Requiere taller

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-check">

                                        <input class="form-check-input"
                                            type="checkbox"
                                            id="gestion_seguro">

                                        <label class="form-check-label">

                                            Requiere seguro

                                        </label>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-check">

                                        <input class="form-check-input"
                                            type="checkbox"
                                            id="gestion_juridico">

                                        <label class="form-check-label">

                                            Requiere jurídico

                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-12 mt-4">

                            <label class="form-label fw-bold">

                                Evidencias actuales

                            </label>

                            <div id="contenedorGestionEvidencias">

                            </div>

                        </div>

                        <!-- NUEVAS EVIDENCIAS -->
                        <div class="col-12">

                            <label class="form-label fw-bold">

                                Agregar nuevas evidencias

                            </label>

                            <div class="card border-0 shadow-sm">

                                <div class="card-body">

                                    <input
                                        type="file"
                                        id="inputGestionEvidencias"
                                        hidden
                                        multiple>

                                    <button
                                        type="button"
                                        class="btn btn-outline-primary rounded-pill mb-3"
                                        id="btnAgregarGestionEvidencias">

                                        <i class="bi bi-paperclip me-2"></i>

                                        Agregar archivos

                                    </button>

                                    <div id="listaGestionEvidencias"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer border-0">

                <button class="btn btn-light"
                    data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button class="btn btn-warning"
                    id="btnGuardarGestionIncidencia">

                    <i class="bi bi-save me-2"></i>

                    Guardar cambios

                </button>

            </div>

        </div>

    </div>

</div>