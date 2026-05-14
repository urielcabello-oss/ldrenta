<div class="contenedoropcionesunidades">
    <h2 class="titulosletrasunidades text-nowrap">Registro de licencias de conducir</h2>


    <!----------------------------------------------------------------------- Tabla Responsiva de las unidades ------------------------------------------------------------------->
    <div class="contendortablaunidades" id="contendortablaunidades">
        <div class="contenedorbuscador">
        <div style="float:right;">
                <button class="btn btn-primary btnabrirmodalagregarlicencia" id="btnabrirmodalagregarlicencia" name="btnabrirmodalagregarlicencia">Agregar nueva licencia</button>
            </div>
            <!-- Campo de búsqueda para filtrar la tabla -->
            <div class="buscador">
                <input type="text" id="filtroBusqueda" class="form-control me-auto" placeholder="Buscar licencias de conducir..." onkeyup="filtrarTabla()">
            </div>

            <!--tabla de las unidades-->
            <table class="table table-hover tablaunidades" id="tablaUnidades">
                <thead style="background-color:rgba(87, 88, 88, 0.68); color: white;">
                    <tr class="titulostablaunidades">
                        <th>ID</th>
                        <th>Colaborador</th>
                        <th>Número de licencia</th>
                        <th>Emisión</th>
                        <th>Vencimiento</th>
                        <th>Permanente</th>
                        <th>Estado</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include("../../Servidor/solicitudes/licencias_conducir/obtener_licencias_conducir.php"); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!----------------------------------------------------------------------- modal para agregar licencias nuevas ------------------------------------------------------------------->
    <!-- Modal -->
    <div class="modal fade modalagregarlicencia" id="modalagregarlicencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar nueva licencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalagregarlicencia"></button>
                </div>
                <div class="modal-body" id="modalagregarlicenciabody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btncerrarmodalagregarlicencia" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary btnagregarlicencia" id="btnagregarlicencia">Agregar licencia</button>
                </div>
            </div>
        </div>
    </div>

    <!--js para filtrar la tabla de unidades-->
    <script src="../js/unidades/filtrar_tabla.js"></script>
    <!--js licencias conducir-->
    <script src="../js/licencias_conducir/licencias_conducir.js"></script>