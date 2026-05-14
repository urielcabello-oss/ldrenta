<!-------------------------------------------aqui comienza el contenedor mis unidades cliente----------------------------------------------------------->
<!------------------------------------------- CONTENEDOR PRINCIPAL ------------------------------------------->
<div class="container-fluid py-4" style="padding-top: 90px;">

    <div class="container" style="padding-top: 90px;">

        <div class="mb-4">
            <h2 class="fw-bold mb-1">
                Solicitud de Unidades Pool
            </h2>
            <small class="text-muted">
                Selecciona fechas, horarios y ubicación para consultar disponibilidad.
            </small>
        </div>


        <!-- ================= FORMULARIO ================= -->
        <div class="mb-4">
            <?php include("../../Servidor/componentes/solicitar_unidades_pool.php"); ?>
        </div>

        <!-- ================= RESULTADOS ================= -->
        <div class="contenedorunidadesdisponiblespool mt-4" id="contenedorunidadesdisponiblespool"></div>

    </div>

</div>



<!-----------------------------------modal para ver los detalles de la unidad pool que el ususario cliente solicita-------------------------------->
<!--modal-->
<div class="modal fade modalinfoformacionunidadpool" id="modalinfoformacionunidadpool" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalinfounidadpool"></button>
            </div>
            <div class="modal-body" id="modalinfoformacionunidadpoolbody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalinfounidadpool" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnsolicitaruniadpool">Solicitar</button>
            </div>
        </div>
    </div>
</div>

<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards.js"></script>
<!--js para mandar a llmamar la informacion de unidades pool-->
<script src="../js/solicitud_unidades_pool/solicitud_unidades_pool.js"></script>