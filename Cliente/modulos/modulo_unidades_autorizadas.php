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
<div class="container mt-4" style="padding-top: 40px;">
    <div class="container mt-4" style="padding-top: 40px;">

        <!-- HEADER -->
        <div class="mb-4">
            <h4 class="titulo-validacion mb-1">Unidades demo asignadas</h4>
            <p class="subtitulo-validacion mb-0">
                Consulta las unidades demo autorizadas y asignadas, revisa detalles y gestiona solicitudes activas.
            </p>
        </div>

        <!-- PANEL DE ACCIONES -->
        <div class="panel-acciones-final p-4 mb-4">

            <p class="panel-texto fw-bold mb-3">
                🔹 Desde aquí puedes buscar, filtrar y cambiar el tipo de visualización de las unidades demo
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
    <div class="demo-contenido">
        <div class="contenedorcardunidadescliente demo-grid">
            <?php include("../../Servidor/componentes/obtener_unidades_demo_autorizadas.php"); ?>
        </div>
    </div>

</div>

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

<!--modal para ver la prueba demo y la informacion de la unidad-->
<!--modal-->
<div class="modal fade modalresultadopruebademo" id="modalresultadopruebademo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Prueba unidad demo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalpruebademo"></button>
            </div>
            <div class="modal-body" id="modalresultadopruebademobody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalpruebademo" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!---------------------------------------modal para ver los detalles de la unidad y el COMODATO que el usuario cliente firmo----------------------->
<!--modal-->
<div class="modal fade modalinfounidademofisica" id="modalinfounidademofisica" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalinfounidademofisica"></button>
            </div>
            <div class="modal-body" id="modalinfounidademofisicabody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalinfounidademofisica" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnaprovarunidademofisica">Aprovar</button>
                <button type="button" class="btn btn-danger" id="btndenegarunidademofisica">Denegar</button>
            </div>
        </div>
    </div>
</div>

<!--------------------------------------modal para escribir el motivo por el cual se denego el comodato firmado---------------------------------------------->
<!--modal-->
<div class="modal fade modaldescripcionnegacionunidademofisica" id="modaldescripcionnegacionunidademofisica" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Denegar carta responsiva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodaldescripcionnegacionunidademofisica"></button>
            </div>
            <div class="modal-body" id="modaldescripcionnegacionunidademofisicabody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodaldescripcionnegacionunidademofisica" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="btndenegarunidaddemofisica">Enviar motivo de denegación</button>
            </div>
        </div>
    </div>
</div>
<!--------------------------------------------------------------------------Modal para ver el Mapa y saber donde esta la unidad-->
<!--modal-->
<div class="modal fade" id="modalMapa" tabindex="-1" aria-labelledby="modalMapaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ultima actualización de la ubicación de la unidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="mapaUnidad" style="height: 500px;"></div>
            </div>
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