
<!-- MODAL ASIGNACIÓN -->
<div class="modal fade modalinfoformacionunidademo"
    id="modalinfoformacionunidademo"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header modal-header-demo">

                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-file-circle-check me-2"></i>
                    Asignación de unidad
                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    id="btncerrarmodalinfounidadpool">
                </button>

            </div>

            <div class="modal-body"
                id="modalinfoformacionunidademobody">
            </div>

            <div class="modal-footer border-0">

                <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cerrar
                </button>

            </div>

        </div>

    </div>

</div>



<!-- MODAL DETALLES -->
<div class="modal fade modalverunidaddemoasignacion"
    id="modalverunidaddemoasignacion"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header modal-header-demo">

                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-car-side me-2"></i>
                    Detalles de la unidad
                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    id="btncerrarmodalverunidaddemoasignacion">
                </button>

            </div>

            <div class="modal-body"
                id="modalverunidaddemoasignacionbody">
            </div>

            <div class="modal-footer border-0">

                <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cerrar
                </button>

                <button type="button"
                    class="btn btn-final-demo"
                    id="btnsolicitaruniaddemo">

                    <i class="fa-solid fa-paper-plane me-2"></i>
                    Solicitar unidad
                </button>

            </div>

        </div>

    </div>

</div>



<style>
    .modal-header-demo {
        background: linear-gradient(135deg, #ff6b35, #ff8c42);
        color: white;
        border-bottom: none;
    }

    .icono-panel-demo {
        width: 55px;
        height: 55px;
        border-radius: 16px;
        background: rgba(255, 107, 53, .12);
        color: #ff6b35;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .mini-card-demo {
        background: linear-gradient(135deg, #fff5f0, #ffffff);
        border: 1px solid rgba(255, 107, 53, .12);
        border-radius: 18px;
        padding: 18px;
    }

    .mini-icono {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: linear-gradient(135deg, #ff6b35, #ff8c42);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 15px;
    }
</style>
