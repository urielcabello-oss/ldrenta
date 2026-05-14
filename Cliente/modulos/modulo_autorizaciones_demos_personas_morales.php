<?php
include("../../Servidor/conexion.php");

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
<!-------------------------------------------aqui comienza el contenedor Autorizacion de unidades demos por parte del usuario tipo 7 --------------------------------------------------->
<div class="contenedormisunidades demo-wrapper">

    <div class="demo-panel">

        <!-- HEADER -->
        <div class="demo-header">
            <h2 class="titulosletrasunidades">Autorización de vehículos demo</h2>
            <p class="demo-descripcion">
                Personas Morales: aquí puedes aprobar o denegar las solicitudes de vehículos demo de tus clientes.
            </p>

            <!-- BOTONES DE FILTRO POR TIPO DE SOLICITANTE -->
            <div class="d-flex flex-wrap gap-2 mt-3 contenedor_botones_validacion_unidades_demos">
                <button onclick="window.location.href='../interfaces/autorizaciones_demos_personas_fisicas.php'" class="btn btn-persona-fisica m-2">
                    <i class="fa-solid fa-user"></i> Físicas
                </button>
                <button onclick="window.location.href='../interfaces/autorizaciones_demos_personas_morales.php'" class="btn btn-persona-moral m-2">
                    <i class="fa-solid fa-building-user"></i> Morales
                </button>
            </div>

            <!-- BUSCADOR Y TOGGLE -->
            <div class="d-flex flex-wrap gap-2 mt-3">
                <input type="text" id="filtroBusqueda" class="form-control flex-grow-1" placeholder="Buscar unidades..." onkeyup="filtrarCards(), filtrarTabla()">

                <button class="btn btn-outline-primary" id="botonCambiarVista" onclick="toggleVista()">Cambiar a vista de tabla</button>
            </div>
        </div>

        <!-- CONTENIDO DE LAS CARDS -->
        <div class="demo-contenido mt-4">
            <div class="contenedorcardunidadescliente demo-grid">
                <?php include("../../Servidor/componentes/obtener_autorizacion_unidades_demo_morales.php"); ?>
            </div>
        </div>

    </div>

</div>

<!---------------------------------------modal para ver los detalles de la unidad y el COMODATO que el usuario cliente firmo----------------------->
<!--modal-->
<div class="modal fade modalinfounidademomoral" id="modalinfounidademomoral" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalinfounidademomoral"></button>
            </div>
            <div class="modal-body" id="modalinfounidademomoralbody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalinfounidademomoral" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnaprovarunidademomoral">Autorizar</button>
                <button type="button" class="btn btn-danger" id="btndenegarunidademofisica">Rechazar</button>
            </div>
        </div>
    </div>
</div>

<!--------------------------------------modal para escribir el motivo por el cual rechaza la unidad demo---------------------------------------------->
<!--modal-->
<div class="modal fade modaldescripcionnegacionunidademofisica" id="modaldescripcionnegacionunidademofisica" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rechazar autorización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodaldescripcionnegacionunidademofisica"></button>
            </div>
            <div class="modal-body" id="modaldescripcionnegacionunidademofisicabody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodaldescripcionnegacionunidademofisica" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="btndenegarunidaddemofisica">Enviar</button>
            </div>
        </div>
    </div>
</div>


<!--js para mandar a llamar el modal de informacion de la unidad y autorizacion demo-->
<script src="../js/autorizar_unidades_demos/autorizar_unidades_demos_morales.js"></script>
<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards_tabla.js"></script>