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
                GESTIÓN DE FLOTILLA
            </span>

            <h1 class="ldr-page-title">
                Administración de unidades
            </h1>

            <p class="ldr-page-subtitle">
                Alta, edición y administración centralizada de unidades.
            </p>
        </div>


            <div class="ldr-header-actions">

                <button
                    onclick="window.location.href='../interfaces/agrega_nuevas_unidades.php'"
                    class="btn ldr-btn-primary">

                    <i class="fa-solid fa-plus me-2"></i>
                    Agregar unidad

                </button>

                <button
                    onclick="window.location.href='../interfaces/unidades_sustituto.php'"
                    class="btn ldr-btn-secondary">

                    <i class="fa-solid fa-plus me-2"></i>
                    Unidades sutituto

                </button>

                

            </div>


    </section>

    <!-- TABLA -->
    <section class="ldr-table-card">

        <div class="ldr-table-header">

            <div>
                <h2>
                    Listado de unidades
                </h2>

                <p>
                    Consulta y administra todas las unidades registradas en la plataforma.
                </p>
            </div>

        </div>

        <div class="table-responsive">

            <table class="table align-middle ldr-table" id="flotillaTable">

                <thead>
                    <tr>
                        <th>Editar</th>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Placa</th>
                        <th>Número motor</th>
                        <th>VIN</th>
                        <th>Supervisor</th>
                        <th>Cliente</th>
                        <th>Arrendadora</th>
                        <th>Estatus</th>
                        <th>Tipo unidad</th>
                        <th>Sede</th>
                        <th>Ubicación</th>
                        <th>Ciudad</th>
                        <th>Municipio</th>
                        <th>Kilometraje</th>
                        <th>Maps</th>
                        <th>Seguros</th>
                        <th>Tenencias</th>
                        <th>Verificaciones</th>
                    </tr>
                </thead>

                <tbody id="flotillaBody"></tbody>

            </table>

        </div>

    </section>

</div>





<!--js para mandar a llamar el modal de edicion de unidades-->
<script src="../js/unidades/modulo_demos.js"></script>
<!--js para mandar a llamar el modal de edicion de unidades-->
<script src="../js/unidades/editarunidadesdemo.js"></script>
<!--js para mandar a llamar el modal de polizas aseguradoras-->
<script src="../js/polizas/modulo_poliza_aseguradora.js"></script>
<!--js para mandar a llamar el modal de polizas tenencias-->
<script src="../js/polizas/modulo_poliza_tenencia.js"></script>
<!--js para mandar a llamar el modal de polizas tenencias-->
<script src="../js/polizas/modulo_poliza_verificacion.js"></script>
<!--js para filtrar la tabla de unidades-->
<script src="../js/unidades/filtrar_tabla.js"></script>
<!--js para editar polizas de seguros-->
<script src="../js/polizas/editar_polizas.js"></script>
<!--js para editar polizas tenencias-->
<script src="../js/polizas/editar_tenencias.js"></script>
<!--js para editar polizas verificaciones-->
<script src="../js/polizas/editar_verificaciones.js"></script>
<!--asignar unidades-->
<script src="../js/asignar_unidades/asignar_unidades.js"></script>
<!--asignar unidades externos-->
<script src="../js/asignar_unidades/asignar_unidades_externos.js"></script>
<!--js para poder obtener iinformacion del mapa -->
<script src="../js/api/obtener_mapa_telematics.js"></script>