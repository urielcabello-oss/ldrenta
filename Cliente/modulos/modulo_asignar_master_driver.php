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

<!-------------------------------------------aqui comienza el contenedor Asignacion de mater driver porparte del ususario tipo 11 ----------------------------------------------------------->
<div class="contenedormisunidades demo-wrapper">

    <div class="demo-panel">

        <!-- HEADER -->
        <div class="demo-header">
            <h2 class="titulosletrasunidades">Asignación de Máster Driver</h2>
            <p class="demo-descripcion">
                Aquí puedes asignar Máster Driver a las unidades demo disponibles.
            </p>
        </div>

        <!-- BUSCADOR -->
        <div class="d-flex flex-wrap gap-2 mt-3">
            <input type="text" id="filtroBusqueda" class="form-control flex-grow-1" placeholder="Buscar unidades..." onkeyup="filtrarCards(), filtrarTabla()">
        </div>

        <!-- CONTENIDO DE LAS CARDS -->
        <div class="demo-contenido mt-4">
            <div class="contenedorcardunidadescliente demo-grid">
                <?php include("../../Servidor/componentes/obtener_unidades_demo_asignar_master_driver.php"); ?>
            </div>
        </div>

    </div>

</div>



<!---------------------------------------modal para asignar master drver a la unidad------------------------------------------------------->
<!--modal-->
<div class="modal fade modalasugnarrmasterdriver" id="modalasugnarrmasterdriver" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Máster Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalasugnarrmasterdriver"></button>
            </div>
            <div class="modal-body" id="modalasugnarrmasterdriverbody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalasugnarrmasterdriver" data-bs-dismiss="modal">Cerrar</button>
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




<!--js para mandar a llamar el modal de informacion de la unidad y la carta responsiva de las unidades-->
<script src="../js/aisgnar_master_driver/aisgnar_master_driver.js"></script>
<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards_tabla.js"></script>