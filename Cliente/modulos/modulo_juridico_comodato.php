<!-------------------------------------------aqui comienza el contenedor Validacion de los comodatos ----------------------------------------------------------->
<div class="contenedorvalidacionunidades">
    <h5 class="letravalidacionunidadjuridico text-nowrap">
        Sube el COMODATO correspondiente al usuario.
    </h5>
    <div class="container mt-4">
        <div class="d-flex flex-wrap justify-content-center contenedor_botones_subir_comodato_demo">
            <!-- Botón estilizado -->
            <button onclick="window.location.href='../interfaces/comodatos.php'" class="btn btn-comodato_interna m-2 "><i class="fa-solid fa-car"></i> Unidad Interna</button>
            <!-- Botón estilizado -->
            <button onclick="window.location.href='../interfaces/comodatos_demos.php'" class="btn btn-comodato_demo m-2 "><i class="fa-solid fa-truck"></i> Unidad DEMO</button>
        </div>
    </div>
</div>
<!-- Campo de búsqueda para filtrar la tabla -->
<div class="grupo-buscador-juridico">
    <div class="buscadorcomodatojuridico mb-3 col-md-8">
        <input type="text" id="filtroBusqueda" class="form-control" placeholder="Buscar unidades..." onkeyup="filtrarCards(), filtrarTabla()">
        <!-- // Botón para alternar vista -->
    </div>
    <div class="d-flex justify-center" style="left: 130px;"><button class="btn btn-cambiar_vista_juridico mb-3" id="botonCambiarVista" onclick="toggleVista()">Cambiar a vista de tabla</button> </div>
</div>

<!--contenedor de las cards de las unidades por asignar-->
<div class="contenedorcardunidadesjuridico">
    <?php include("../../Servidor/componentes/obtener_unidades_subir_comodato.php"); ?>
</div>


<!-------------------------------------modal para subir el comodato correspondiente al usuario-------------------------------->
<!--modal-->
<div class="modal fade modalunidadcomodato" id="modalunidadcomodato" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalunidadcomodato"></button>
            </div>
            <div class="modal-body" id="modalunidadcomodatobody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalunidadcomodato" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnenviarcomodato">Enviar</button>
            </div>
        </div>
    </div>
</div>

<!-------------------------------------js para subir el comodato correspondiente al usuario-------------------------------->
<script src="../js/juridico/comodato.js"></script>
<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards_tabla.js"></script>