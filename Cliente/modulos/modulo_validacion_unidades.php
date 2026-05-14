<!-------------------------------------------aqui comienza el contenedor Validacion de carta responsiva ----------------------------------------------------------->
<div class="contenedorvalidacionunidades">
    <h5 class="titulosletrasunidades text-nowrap">Vehículos pool</h5>
    <h4 class="letravalidacionunidadresponsiva text-nowrap">
        Asegúrate de que la unidad tenga la responsiva firmada.
    </h4>
    <!--contenedor de las cards de las unidades por asignar-->
    <div class="container mt-4">
        <div class="d-flex flex-wrap justify-content-center contenedor_botones">
            <!-- Botón estilizado -->
            <button onclick="window.location.href='../interfaces/validacion_unidades_comodato.php'" class="btn btn-comodato m-2 "><i class="fa-solid fa-file-contract"></i> Comodato</button>
            <!-- Botón estilizado -->
            <button onclick="window.location.href='../interfaces/validacion_unidades.php'" class="btn btn-responsiva m-2 "><i class="fa-solid fa-file-contract"></i> Carta Responsiva</button>


        </div>
    </div>

</div>
<!-- Campo de búsqueda para filtrar la tabla -->
<div class="contenedorbuscadorvalidacionunidades">
    <div class="buscadoresponsiva mb-3 col-md-8">
        <input type="text" id="filtroBusqueda" class="form-control" placeholder="Buscar unidades..." onkeyup="filtrarCards(), filtrarTabla()">
    </div>
    <!-- // Botón para alternar vista -->
    <div class="d-flex justify-center" style="left: 130px;"><button class="btn btn-cambiar_vista mb-3" id="botonCambiarVista" onclick="toggleVista()">Cambiar a vista de tabla</button> </div>
</div>
<div class="contenedorcardunidadescomodatoresponsiva">
    <?php include("../../Servidor/componentes/obtener_validacion_unidades_carta_responsiva_pool.php"); ?>
</div>



<!---------------------------------------modal para ver los detalles de la unidad y la carta responsiva de las unidades que el ususario cliente firmo----------------------->
<!--modal-->
<div class="modal fade modalinfounidadcartaresponsiva" id="modalinfounidadcartaresponsiva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalinfounidadcartaresponsiva"></button>
            </div>
            <div class="modal-body" id="modalinfounidadcartaresponsivabody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalinfounidadcartaresponsiva" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnaprovarcartaresponsivafirmada">Aprobar</button>
                <button type="button" class="btn btn-danger" id="btndenegarcartaresponsivafirmada">Denegar</button>
            </div>
        </div>
    </div>
</div>

<!--------------------------------------modal para escribir el motivo por el cual se denego la carta responsiva---------------------------------------------->
<!--modal-->
<div class="modal fade modaldescripcioncartadenegada" id="modaldescripcioncartadenegada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Denegar carta responsiva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodaldescripcioncartadenegada"></button>
            </div>
            <div class="modal-body" id="modaldescripcioncartadenegadabody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodaldescripcioncartadenegada" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="btndenegarcartaresponsivafirmadadenegar">Enviar motivo</button>
            </div>
        </div>
    </div>
</div>




<!--js para mandar a llamar el modal de informacion de la unidad y la carta responsiva de las unidades-->
<script src="../js/asignar_unidades/validacion_unidades.js"></script>
<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards.js"></script>
<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards_tabla.js"></script>