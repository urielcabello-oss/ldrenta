<!-------------------------------------------aqui comienza el contenedor mis unidades cliente----------------------------------------------------------->
<div class="contenedormisunidades">

    <h2 class="titulosletrasunidades text-nowrap">Solicitud de unidades</h2>
    <h5 class="titulosletrasunidadescliente text-nowrap">Estás por adquirir la siguiente unidad:</h5>
    <!--contenedor de las cards de las unidades por asignar-->
    <div class="contenedorcardunidadescliente">
        <?php include("../../Servidor/componentes/obtener_unidades_preasignadas.php"); ?>
    </div>
</div>

<!---------------------------------------modal para ver los detalles de la unidad y la politica de prestamos de unidades---------------------------------->
<!--modal-->
<div class="modal fade modalinfounidadpolitica" id="modalinfounidadpolitica" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalinfounidadpolitica"></button>
            </div>
            <div class="modal-body" id="modalinfounidadpoliticabody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalinfounidadpolitica" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnenviarpolitica">Enviar política</button>
            </div>
        </div>
    </div>
</div>

<!-------------------------------------modal para ver los detalles de la unidad y el COMODATO que juridico subio-->
<!--modal-->
<div class="modal fade modalinfounidadcomodato" id="modalinfounidadcomodato" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalinfounidadcomodato"></button>
            </div>
            <div class="modal-body" id="modalinfounidadcomodatobody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalinfounidadcomodato" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!--------------------------------------modal para rechazar el comodato y mandar de nuevo a juridico-------------------------------------->
<!--modal-->
<div class="modal fade modalrechazarcomodatousuario" id="modalrechazarcomodatousuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rechazar COMODATO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalrechazarcomodatousuario"></button>
            </div>
            <div class="modal-body" id="modalrechazarcomodatousuariobody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalrechazarcomodatousuario" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnrechazarcomodato">Regresar COMODATO</button>
            </div>
        </div>
    </div>
</div>



<!--js para mandar a llamar el modal de informacion de la unidad y la politica de prestamos de unidades-->
<script src="../js/solicitud_unidades/solicitud_unidades.js"></script>
<script src="../js/solicitud_unidades/solicitud_unidades_comodato.js"></script>
