<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<div class="ldr-dashboard">

    <!-- HEADER -->
    <section class="ldr-page-header">

        <div>
            <span class="ldr-page-badge">
                GESTIÓN DE DOCUMENTACIONES
            </span>

            <h1 class="ldr-page-title">
                Administración de los documentos
            </h1>

            <p class="ldr-page-subtitle">
                Alta, edición y administración centralizada de documentos.
            </p>
        </div>


        <div class="ldr-header-actions">

            <button
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalAgregarDocumento">

                <i class="fa-solid fa-plus me-2"></i>
                Agregar documento

            </button>

        </div>


    </section>

    <!-- TABLA -->
    <section class="ldr-table-card">

        <div class="ldr-table-header">

            <div>
                <h2>
                    Listado de documentos
                </h2>

                <p>
                    Consulta y administra todos los documentos.
                </p>
            </div>

        </div>

        <div class="table-responsive">

            <table class="table align-middle ldr-table" id="documentos">

                <thead>
                    <tr>
                        <th>Editar</th>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Documento</th>
                        <th>Placa</th>
                        <th>VIN</th>
                        <th>Folio</th>
                        <th>UUID</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Archivos</th>
                    </tr>
                </thead>

                <tbody id="documentosBody"></tbody>

            </table>

        </div>

    </section>

</div>





<!--js para mandar a llamar el modal de edicion de unidades-->
<script src="../js/documentacion_unidades_demo/documentacion_unidades_demo.js"></script>