<div class="modal fade" id="modalCatalogo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="tituloCatalogo">
                    Editar catálogo
                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="tipoCatalogo">
                <input type="hidden" id="idCatalogo">

                <label class="form-label">
                    Nombre
                </label>

                <input type="text"
                    class="form-control"
                    id="nombreCatalogo">

            </div>

            <div class="modal-footer">

                <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button type="button"
                    class="btn btn-warning"
                    id="btnGuardarCatalogo">

                    Guardar cambios

                </button>

            </div>

        </div>
    </div>
</div>