<div class="container-fluid px-3 px-md-4 mt-4">


    <!-- PANEL INFORMATIVO -->
    <div class="panel-acciones-final p-4 mb-4">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <div class="d-flex align-items-start">

                    <div class="icono-panel-demo me-3">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>

                    <div>

                        <h5 class="fw-bold mb-2" style="color:#ff6b35;">
                            Flujo de asignación
                        </h5>

                        <p class="mb-2 text-muted">
                            Primero registra al cliente como persona física o moral.
                        </p>

                        <p class="mb-0 text-muted">
                            Después selecciona la unidad disponible y genera la solicitud de asignación.
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">

                <div class="mini-card-demo">

                    <div class="d-flex align-items-center">

                        <div class="mini-icono">
                            <i class="fa-solid fa-car-side"></i>
                        </div>

                        <div>
                            <h6 class="mb-1 fw-bold">
                                Unidades
                            </h6>

                            <small class="text-muted">
                                Consulta disponibilidad y asigna rápidamente
                            </small>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- HEADER PRINCIPAL -->
    <div class="panel-acciones-final p-4 mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h4 class="titulo-validacion mb-1">
                    Registro de clientes
                </h4>

                <p class="subtitulo-validacion mb-0">
                    Registro de clientes y asignación de unidades disponibles.
                </p>
            </div>

            <div class="d-flex flex-wrap gap-2">

                <button onclick="window.location.href='../interfaces/personas_fisicas.php'"
                    class="btn ldr-btn-secondary"
                    data-bs-toggle="tooltip"
                    title="Registrar persona física">

                    <i class="fa-solid fa-user-plus me-2"></i>
                    Persona física
                </button>

                <button onclick="window.location.href='../interfaces/personas_morales.php'"
                    class="btn ldr-btn-secondary"
                    data-bs-toggle="tooltip"
                    title="Registrar persona moral">

                    <i class="fa-solid fa-building-circle-check me-2"></i>
                    Persona moral
                </button>

            </div>

        </div>

    </div>


    <!-- CONTENIDO -->

    <!-- HEADER -->
    <div class="ldr-solicitud-header">

        <div>
            <span class="ldr-page-badge">
                DISPONIBILIDAD
            </span>

            <h3 class="ldr-solicitud-title">
                Consulta de unidades demo
            </h3>

            <p class="ldr-solicitud-subtitle">
                Verifica disponibilidad y aplica filtros avanzados.
            </p>
        </div>
    </div>

    <!-- COMPONENTE -->
    <div class="demo-contenido">
        <?php include("../../Servidor/componentes/solicitar_unidades_demo.php"); ?>
    </div>

    <!-- RESULTADOS -->
    <div class="contenedorunidadesdisponiblesdemo mt-4"
        id="contenedorunidadesdisponiblesdemo">
    </div>


</div>





<!-- JS -->
<script src="../js/unidades/filtrar_cards.js"></script>
<script src="../js/asignar_unidades_demo/solicitud_unidades_demo.js"></script>