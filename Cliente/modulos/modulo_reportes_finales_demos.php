<!-------------------------------------------aqui comienza el contenedor Validacion de los comodatos ----------------------------------------------------------->
<div class="contenedormisunidades demo-wrapper">

    <div class="demo-panel">

        <!-- HEADER -->
        <div class="demo-header">
            <h2 class="titulosletrasunidades">Reportes finales Master Drivers</h2>
            <p class="demo-descripcion">
                Aquí puedes consultar los reportes finales de las unidades demo asignadas a Master Drivers.
            </p>
        </div>

        <!-- BUSCADOR Y BOTÓN DE VISTA -->
        <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
            <input type="text" id="filtroBusqueda" class="form-control flex-grow-1" placeholder="Buscar unidades..." onkeyup="filtrarCards(), filtrarTabla()">
            
            <button class="btn btn-primary" id="botonCambiarVista" onclick="toggleVista()">Cambiar a vista de tabla</button>
        </div>

        <!-- CONTENIDO DE LAS CARDS -->
        <div class="demo-contenido mt-4">
            <div class="contenedorcardunidadescliente demo-grid">
                <?php include("../../Servidor/componentes/obtener_unidades_reportes_finales_demos.php"); ?>
            </div>
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




<!--js para vizualisar el reporte final de la prueba demo-->
<script src="../js/reporte_final_prueba_demo/reportes_finales_demos.js"></script>
<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards_tabla.js"></script>