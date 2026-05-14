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

<!-----------------aqui comienza el contenedor para subir el desempeño de las unidades demos por parte del usuario tipo 11 ADMINISTRADOR PRUEBA DEMO ---------------------------------->
<div class="contenedormisunidades demo-wrapper">

    <div class="demo-panel">

        <!-- HEADER -->
        <div class="demo-header">
            <h2 class="titulosletrasunidades">Desempeños de las unidades demos</h2>
            <p class="demo-descripcion">
                Aquí puedes consultar los desempeños de cada unidad demo y filtrar por tipo de solicitante.
            </p>
        </div>

        <!-- BUSCADOR Y FILTROS -->
        <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
            <input type="text" id="filtroBusqueda" class="form-control flex-grow-1" placeholder="Buscar unidades..." onkeyup="filtrarCards(), filtrarTabla()">

            <!-- Filtro tipo de solicitante -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownFiltroSolicitante" data-bs-toggle="dropdown" aria-expanded="false">
                    Filtrar por tipo de solicitante
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownFiltroSolicitante">
                    <li><a class="dropdown-item opcion-filtro-solicitante" data-filtro="todos" href="#">Todas</a></li>
                    <li><a class="dropdown-item opcion-filtro-solicitante" data-filtro="fisica" href="#">Personas Físicas</a></li>
                    <li><a class="dropdown-item opcion-filtro-solicitante" data-filtro="moral" href="#">Personas Morales</a></li>
                </ul>
            </div>
        </div>

        <!-- CONTENIDO DE LAS CARDS -->
        <div class="demo-contenido mt-4">
            <div class="contenedorcardunidadescliente demo-grid">
                <?php include("../../Servidor/componentes/obtener_desempeños_unidades_demo.php"); ?>
            </div>
        </div>

    </div>

</div>



<!---------------------------------------modal para ver los detalles de la unidad demo del lado del usuario tipo 9 master driver--------------------------------------->
<!--modal-->
<div class="modal fade modalinfopruebaunidademo" id="modalinfopruebaunidademo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalinfopruebaunidademo"></button>
            </div>
            <div class="modal-body" id="modalinfopruebaunidademobody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalinfopruebaunidademo" data-bs-dismiss="modal">Cerrar</button>
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


<!--js para mandar a llamar el modal de informacion de la unidad y la carta responsiva de las unidades-->
<script src="../js/pruebas_unidades_demo/pruebas_unidades_demo.js"></script>
<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards_tabla.js"></script>
<!--js para poder obtener iinformacion del mapa -->
<script src="../js/api/obtener_mapa_telematics.js"></script>
