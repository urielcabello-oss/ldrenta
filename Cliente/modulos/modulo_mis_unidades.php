<!-------------------------------------------aqui comienza el contenedor mis unidades cliente----------------------------------------------------------->
<div class="contenedormisunidades">
    <h2 class="titulosletrasunidades text-nowrap">Mis unidades</h2>
    <!-- Campo de búsqueda para filtrar las cards -->
     <div class="contenedorbuscador">
  <div class="buscador">
    <input type="text" id="filtroBusqueda" class="form-control" placeholder="Buscar unidades..." onkeyup="filtrarCards()">
  </div>
  </div>
    <div class="contenedorcardunidadescliente">
        <?php include("../../Servidor/componentes/obtener_mis_unidades_cliente.php"); ?>
    </div>
</div>

<!-----------------------------------------modal registrar incidencia---------------------------------->
<!--modal-->
<div class="modal fade modalregistrarincidencia" id="modalregistrarincidencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar incidencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalregistrarincidencia"></button>
            </div>
            <div class="modal-body" id="modalregistrarincidenciabody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalregistrarincidencia" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnregistrarincidencia">Registrar</button>
            </div>
        </div>
    </div>
</div>



<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards.js"></script>
<!--js para las incidencias-->
<script src="../js/mis_unidades_cliente/incidencias_cliente.js"></script>