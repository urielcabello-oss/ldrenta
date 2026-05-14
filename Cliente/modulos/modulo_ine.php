<div class="contenedoropcionesunidades">
    <h2 class="titulosletrasunidades text-nowrap">Registro de INE´s</h2>


    <!----------------------------------------------------------------------- Tabla Responsiva de las ines ------------------------------------------------------------------->
    <div class="contendortablaunidades" id="contendortablaunidades">
        <div class="contenedorbuscador">
        <div style="float:right;">
                <button class="btn btn-primary btnabrirmodalagregarine" id="btnabrirmodalagregarine" name="btnabrirmodalagregarine">Agregar nueva INE</button>
            </div>
            <!-- Campo de búsqueda para filtrar la tabla -->
            <div class="buscador">
                <input type="text" id="filtroBusqueda" class="form-control me-auto" placeholder="Buscar INE´s..." onkeyup="filtrarTabla()">
            </div>

            <!--tabla de las ines-->
            <table class="table table-hover tablaunidades" id="tablaUnidades">
                <thead style="background-color:rgba(87, 88, 88, 0.68); color: white;">
                    <tr class="titulostablaunidades">
                        <th>ID</th>
                        <th>Colaborador</th>
                        <th>Sección</th>
                        <th>Vigencia</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include("../../Servidor/solicitudes/ines/obtener_tabla_ine.php"); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!----------------------------------------------------------------------- modal para agregar Ine´s nuevas ------------------------------------------------------------------->
    <!-- Modal -->
    <div class="modal fade modalagregarine" id="modalagregarine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar nueva INE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalagregarlicencia"></button>
                </div>
                <div class="modal-body" id="modalagregarinebody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btncerrarmodalagregarlicencia" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary btnagregarine" id="btnagregarine">Agregar licencia</button>
                </div>
            </div>
        </div>
    </div>

    <!--js para filtrar la tabla de unidades-->
    <script src="../js/unidades/filtrar_tabla.js"></script>
    <!--js licencias conducir-->
    <script src="../js/ines/ines.js"></script>