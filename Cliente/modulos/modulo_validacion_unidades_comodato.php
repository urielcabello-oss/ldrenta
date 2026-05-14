<!-------------------------------------------aqui comienza el contenedor Validacion de los comodatos ----------------------------------------------------------->
<div class="container">
    <div class="panel-validacion-comodato" style="padding-top: 100px;">

        <!-- HEADER -->
        <div class="header-validacion-comodato">
            <div>
                <h4 class="titulo-validacion">Validación de Unidades</h4>
                <p class="subtitulo-validacion">Revisión de comodatos firmados</p>
            </div>

            <div class="acciones-validacion">
                <button onclick="window.location.href='../interfaces/validacion_unidades_comodato.php'"
                    class="btn btn-comodato m-2 ">
                    <i class="fa-solid fa-file-contract"></i> Comodato
                </button>

                <button onclick="window.location.href='../interfaces/validacion_unidades.php'"
                    class="btn btn-responsiva m-2">
                    <i class="fa-solid fa-file-signature"></i> Carta Responsiva
                </button>
            </div>
        </div>


        <!-- TOOLBAR -->
        <div class="toolbar-validacion row align-items-center mt-3">
            <div class="col-md-7 mb-2">
                <input type="text" id="filtroBusqueda" class="form-control input-validacion"
                    placeholder="Buscar por colaborador, placa, VIN o modelo..."
                    onkeyup="filtrarCards(), filtrarTabla()">
            </div>

            <div class="col-md-3 mb-2">
                <button class="btn btn-toggle-vista w-100" id="botonCambiarVista" onclick="toggleVista()">
                    Cambiar a vista de tabla
                </button>
            </div>
        </div>

    </div>
</div>


<!--contenedor de las cards de las unidades por asignar-->
<div class="contenedorcardunidadescomodatoresponsiva">
    <?php include("../../Servidor/componentes/obtener_validacion_unidades_comodato.php"); ?>
</div>



<!---------------------------------------modal para ver los detalles de la unidad y el COMODATO que el usuario cliente firmo----------------------->
<!--modal-->
<div class="modal fade modalinfounidadcomodato" id="modalinfounidadcomodato" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad y COMODATO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalinfounidadcomodato"></button>
            </div>
            <div class="modal-body" id="modalinfounidadcomodatobody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" id="btnnotificarusuario"><i class="fas fa-bell"></i> Notificar</button>
                <button type="button" class="btn btn-secondary" id="btncerrarmodalinfounidadcomodato" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnaprovarcomodatofirmado">Asignar</button>
                <button type="button" class="btn btn-danger" id="btndenegarcomodatofirmado">Denegar</button>
            </div>
        </div>
    </div>
</div>

<!--------------------------------------modal para escribir el motivo por el cual se denego el comodato firmado---------------------------------------------->
<!--modal-->
<div class="modal fade modaldescripcionnegacioncomodatofirmado" id="modaldescripcionnegacioncomodatofirmado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Denegar carta responsiva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodaldescripcionnegacioncomodatofirmado"></button>
            </div>
            <div class="modal-body" id="modaldescripcionnegacioncomodatofirmadobody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodaldescripcionnegacioncomodatofirmado" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="btndenegarcartaresponsivafirmadadenegar">Enviar motivo de denegación</button>
            </div>
        </div>
    </div>
</div>




<!--js para mandar a llamar el modal de informacion de la unidad y la carta responsiva de las unidades-->
<script src="../js/asignar_unidades/validacion_unidades_comodato.js"></script>
<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards_tabla.js"></script>