<?php
include("../../Servidor/conexion.php");

//obtenemos el id del colaborador para saber quien es el que esta logeado
if (!isset($_SESSION)) {
    session_start();
}

// Verificar que la sesión tenga los datos necesarios
if (!isset($_SESSION['id_colaborador']) || !isset($_SESSION['id_tipo_usuario'])) {
    echo "Sesión inválida";
    exit;
}

$colaborador = $_SESSION['id_colaborador'];
$id_tipo_usuario = $_SESSION['id_tipo_usuario'];

?>

<!-------------------------------------------aqui comienza el contenedor Autorizacion de unidades demos por parte del usuario tipo 7 ----------------------------------------------------------->
<!-- CONTENEDOR PRINCIPAL -->
<div class="container-fluid px-3 px-md-4 mt-4">


    <!-- HEADER -->
    <section class="ldr-page-header">

        <div>
            <span class="ldr-page-badge">
                GESTIÓN DE UNIDADES RENTADAS
            </span>

            <h1 class="ldr-page-title">
                Administra las unidades rentadas
            </h1>

            <p class="ldr-page-subtitle">
                Registro y administración de las unidades rentadas a personas físicas o morales.
            </p>
        </div>

    </section>

    <!-- PANEL DE ACCIONES -->
    <div class="panel-acciones-final p-4 mb-4">

        <p class="panel-texto fw-bold mb-3">
            🔹 Desde aquí puedes buscar, filtrar y cambiar el tipo de visualización de las unidades 
        </p>

        <div class="d-flex flex-wrap gap-3 align-items-center">

            <!-- Buscador -->
            <div class="flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text"
                        id="filtroBusqueda"
                        class="form-control"
                        placeholder="Buscar unidades..."
                        onkeyup="filtrarCards(); filtrarTabla();">
                </div>
            </div>

            <!-- Botón cambiar vista -->
            <button class="btn btn-outline-primary"
                id="botonCambiarVista"
                onclick="toggleVista()">
                <i class="fa-solid fa-table-cells me-2"></i>
                Cambiar vista
            </button>

            <!-- Filtro solicitante -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle"
                    type="button"
                    id="dropdownFiltroSolicitante"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Filtrar solicitante
                </button>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item opcion-filtro-solicitante" data-filtro="todos" href="#">Todas</a></li>
                    <li><a class="dropdown-item opcion-filtro-solicitante" data-filtro="fisica" href="#">Personas Físicas</a></li>
                    <li><a class="dropdown-item opcion-filtro-solicitante" data-filtro="moral" href="#">Personas Morales</a></li>
                </ul>
            </div>
            <button class="btn btn-warning" id="btnPendientes">
                <i class="fas fa-clock"></i> Pendientes de asignación
            </button>
        </div>
    </div>
</div>

<!-- CONTENIDO -->
    <section class="ldr-table-card">

      <div class="ldr-table-header">

            <div>
                <h2>
                    Listado de asignaciones
                </h2>

                <p>
                    Consulta y administra todas las asignaciones.
                </p>
            </div>

        </div>
        <?php include("../../Servidor/componentes/obtener_unidades_demo_autorizadas.php"); ?>
    </section>


<!--panel lateral-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="panelPendientes" style="width:500px;">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title">
            <i class="fas fa-clock"></i> Solicitudes pendientes
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <div id="listaPendientes">

            <!-- aqui se cargaran -->

        </div>

    </div>

</div>


<!--js para vizualisar el reporte final de la prueba demo-->
<script src="../js/reporte_final_prueba_demo/reportes_finales_demos.js"></script>
<!--js para mandar a llamar el modal de informacion de la unidad y la carta responsiva de las unidades-->
<script src="../js/unidades_demo_autorizadas/unidades_demo_autorizadas.js"></script>
<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards_tabla.js"></script>
<!--js para poder obtener iinformacion del mapa -->
<script src="../js/api/obtener_mapa_telematics.js"></script>