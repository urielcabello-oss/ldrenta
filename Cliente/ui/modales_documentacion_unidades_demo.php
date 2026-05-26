<!-- ================================================= -->
<!-- MODAL AGREGAR DOCUMENTO -->
<!-- ================================================= -->

<div class="modal fade"
    id="modalAgregarDocumento"
    tabindex="-1">

    <div class="modal-dialog modal-fullscreen-lg-down modal-xl modal-dialog-scrollable">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header">

                <h5 class="modal-title">
                    Agregar documento
                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form id="formAgregarDocumento"
                enctype="multipart/form-data">

                <div
                    class="modal-body"
                    style="
        max-height: 70vh;
        overflow-y: auto;
    ">

                    <div class="row">

                        <!-- ========================================= -->
                        <!-- GENERALES -->
                        <!-- ========================================= -->

                        <!-- UNIDAD -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Unidad
                            </label>

                            <select
                                class="form-select"
                                id="id_unidad"
                                name="id_unidad">

                                <option value="">
                                    Seleccione unidad
                                </option>

                            </select>

                        </div>

                        <!-- TIPO -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tipo documento
                            </label>

                            <select
                                class="form-select"
                                id="tipo_documento"
                                name="tipo_documento"
                                required>

                                <option value="">
                                    Seleccione
                                </option>

                                <option value="CFDI XML">
                                    CFDI XML
                                </option>

                                <option value="FACTURA PDF">
                                    FACTURA PDF
                                </option>

                                <option value="COMPROBANTE PAGO">
                                    COMPROBANTE PAGO
                                </option>

                                <option value="EVIDENCIA">
                                    EVIDENCIA
                                </option>

                            </select>

                        </div>

                        <!-- CATEGORIA -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Categoría
                            </label>

                            <input type="text"
                                class="form-control"
                                name="categoria">

                        </div>

                        <!-- NOMBRE -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nombre documento
                            </label>

                            <input type="text"
                                class="form-control"
                                name="nombre_documento">

                        </div>

                    </div>

                    <!-- ========================================= -->
                    <!-- CFDI -->
                    <!-- ========================================= -->

                    <div
                        id="seccionCFDI"
                        class="row d-none">

                        <!-- FOLIO -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Folio
                            </label>

                            <input type="text"
                                class="form-control"
                                name="folio">

                        </div>

                        <!-- UUID -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                UUID
                            </label>

                            <input type="text"
                                class="form-control"
                                name="uuid">

                        </div>

                        <!-- FECHA -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Fecha documento
                            </label>

                            <input type="date"
                                class="form-control"
                                name="fecha_documento">

                        </div>

                        <!-- RFC EMISOR -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                RFC Emisor
                            </label>

                            <input type="text"
                                class="form-control"
                                name="rfc_emisor">

                        </div>

                        <!-- RFC RECEPTOR -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                RFC Receptor
                            </label>

                            <input type="text"
                                class="form-control"
                                name="rfc_receptor">

                        </div>

                        <!-- SUBTOTAL -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Subtotal
                            </label>

                            <input type="number"
                                step="0.01"
                                class="form-control"
                                name="subtotal">

                        </div>

                        <!-- IVA -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                IVA
                            </label>

                            <input type="number"
                                step="0.01"
                                class="form-control"
                                name="iva">

                        </div>

                        <!-- TOTAL -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Total
                            </label>

                            <input type="number"
                                step="0.01"
                                class="form-control"
                                name="total">

                        </div>

                        <!-- XML -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Archivo XML
                            </label>

                            <input type="file"
                                class="form-control"
                                name="archivo_xml"
                                accept=".xml">

                        </div>

                        <!-- PDF -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Archivo PDF
                            </label>

                            <input type="file"
                                class="form-control"
                                name="archivo_pdf"
                                accept=".pdf">

                        </div>

                    </div>

                    <!-- ========================================= -->
                    <!-- COMPROBANTE -->
                    <!-- ========================================= -->

                    <div
                        id="seccionComprobante"
                        class="row d-none">

                        <!-- COMPROBANTE -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Comprobante pago
                            </label>

                            <input type="file"
                                class="form-control"
                                name="archivo_comprobante"
                                accept=".pdf,.jpg,.png">

                        </div>

                        <!-- TOTAL -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Total
                            </label>

                            <input type="number"
                                step="0.01"
                                class="form-control"
                                name="total_comprobante">

                        </div>

                    </div>

                    <!-- ========================================= -->
                    <!-- EVIDENCIA -->
                    <!-- ========================================= -->

                    <div
                        id="seccionEvidencia"
                        class="row d-none">

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Evidencia
                            </label>

                            <input type="file"
                                class="form-control"
                                name="archivo_evidencia"
                                accept=".pdf,.jpg,.png">

                        </div>

                    </div>

                    <!-- OBSERVACIONES -->

                    <div class="row">

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Observaciones
                            </label>

                            <textarea class="form-control"
                                rows="3"
                                name="observaciones"></textarea>

                        </div>

                    </div>

                </div>

                <div class="modal-footer sticky-bottom bg-white">

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cerrar

                    </button>

                    <button type="submit"
                        class="btn btn-primary">

                        Guardar documento

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- ================================================= -->
<!-- MODAL EDITAR DOCUMENTO -->
<!-- ================================================= -->

<div class="modal fade"
    id="modalEditarDocumento"
    tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header">

                <h5 class="modal-title">
                    Editar documento
                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form id="formEditarDocumento"
                enctype="multipart/form-data">

                <input type="hidden"
                    id="edit_id_documento"
                    name="id_documento">

                <div
                    class="modal-body"
                    style="
        max-height: 70vh;
        overflow-y: auto;
    ">

                    <div class="row">

                        <!-- UNIDAD -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Unidad
                            </label>

                            <select
                                class="form-select"
                                id="edit_id_unidad"
                                name="id_unidad">
                            </select>

                        </div>

                        <!-- TIPO -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tipo documento
                            </label>

                            <select
                                class="form-select"
                                id="edit_tipo_documento"
                                name="tipo_documento">

                                <option value="">
                                    Seleccione
                                </option>

                                <option value="CFDI XML">
                                    CFDI XML
                                </option>

                                <option value="FACTURA PDF">
                                    FACTURA PDF
                                </option>

                                <option value="COMPROBANTE PAGO">
                                    COMPROBANTE PAGO
                                </option>

                                <option value="EVIDENCIA">
                                    EVIDENCIA
                                </option>

                            </select>

                        </div>

                        <!-- CATEGORIA -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Categoría
                            </label>

                            <input type="text"
                                class="form-control"
                                id="edit_categoria"
                                name="categoria">

                        </div>

                        <!-- NOMBRE -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nombre documento
                            </label>

                            <input type="text"
                                class="form-control"
                                id="edit_nombre_documento"
                                name="nombre_documento">

                        </div>

                    </div>

                    <!-- ========================================= -->
                    <!-- CFDI -->
                    <!-- ========================================= -->

                    <div
                        id="edit_seccionCFDI"
                        class="row d-none">

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Folio
                            </label>

                            <input type="text"
                                class="form-control"
                                id="edit_folio"
                                name="folio">

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                UUID
                            </label>

                            <input type="text"
                                class="form-control"
                                id="edit_uuid"
                                name="uuid">

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Fecha documento
                            </label>

                            <input type="date"
                                class="form-control"
                                id="edit_fecha_documento"
                                name="fecha_documento">

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                RFC Emisor
                            </label>

                            <input type="text"
                                class="form-control"
                                id="edit_rfc_emisor"
                                name="rfc_emisor">

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                RFC Receptor
                            </label>

                            <input type="text"
                                class="form-control"
                                id="edit_rfc_receptor"
                                name="rfc_receptor">

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Subtotal
                            </label>

                            <input type="number"
                                step="0.01"
                                class="form-control"
                                id="edit_subtotal"
                                name="subtotal">

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                IVA
                            </label>

                            <input type="number"
                                step="0.01"
                                class="form-control"
                                id="edit_iva"
                                name="iva">

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Total
                            </label>

                            <input type="number"
                                step="0.01"
                                class="form-control"
                                id="edit_total"
                                name="total">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Reemplazar XML
                            </label>

                            <input type="file"
                                class="form-control"
                                name="archivo_xml">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Reemplazar PDF
                            </label>

                            <input type="file"
                                class="form-control"
                                name="archivo_pdf"
                                accept=".pdf">

                        </div>

                    </div>

                    <!-- ========================================= -->
                    <!-- COMPROBANTE -->
                    <!-- ========================================= -->

                    <div
                        id="edit_seccionComprobante"
                        class="row d-none">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Reemplazar comprobante
                            </label>

                            <input type="file"
                                class="form-control"
                                name="archivo_comprobante">

                        </div>

                    </div>

                    <!-- ========================================= -->
                    <!-- EVIDENCIA -->
                    <!-- ========================================= -->

                    <div
                        id="edit_seccionEvidencia"
                        class="row d-none">

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Reemplazar evidencia
                            </label>

                            <input type="file"
                                class="form-control"
                                name="archivo_evidencia">

                        </div>

                    </div>

                    <!-- OBS -->

                    <div class="row">

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Observaciones
                            </label>

                            <textarea
                                class="form-control"
                                rows="3"
                                id="edit_observaciones"
                                name="observaciones"></textarea>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                        class="btn btn-primary">

                        Actualizar documento

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>