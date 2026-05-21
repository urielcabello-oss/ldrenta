<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!-------------------------------------------
    CONTENEDOR JURÍDICO DEMOS
-------------------------------------------->

<div class="container-fluid px-3 px-md-4 mt-4">

    <!-- HEADER -->
    <section class="ldr-page-header">

        <div>

            <span class="ldr-page-badge">
                ÁREA JURÍDICA
            </span>

            <h1 class="ldr-page-title">
                Gestión de contratos
            </h1>

            <p class="ldr-page-subtitle">
                Administra, revisa y sube los contratos correspondientes a las unidades demo.
            </p>

        </div>

    </section>

    <!-- CONTENIDO -->
    <section class="ldr-table-card">

        <div class="ldr-table-header">

            <div>

                <h2>
                    Listado de contratos
                </h2>

                <p>
                    Consulta las asignaciones pendientes y administra los documentos jurídicos.
                </p>

            </div>

        </div>

        <!-- CARDS -->
        <div class="contenedorcardunidadesjuridico">

            <?php include("../../Servidor/componentes/obtener_unidades_subir_comodato_demo.php"); ?>

        </div>

    </section>

</div>

<!-- JS -->
<script src="../js/juridico/comodato_demo.js"></script>
<script src="../js/unidades/filtrar_cards_tabla.js"></script>
<script src="../js/juridico/ver_archivos.js"></script>