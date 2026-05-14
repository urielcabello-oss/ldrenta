<div class="contenedoropcionesunidades">
    <h2 class="titulosletrasunidades text-nowrap">Registro de comprobantes de domocilio</h2>


    <!----------------------------------------------------------------------- Tabla Responsiva de las unidades ------------------------------------------------------------------->
    <div class="contendortablaunidades" id="contendortablaunidades">
        <div class="contenedorbuscador">
        <div style="float:right;">
                <button class="btn btn-primary btnabrirmodalagregardomicilio" id="btnabrirmodalagregardomicilio" name="btnabrirmodalagregardomicilio">Agregar nuevo domicilio</button>
            </div>
            <!-- Campo de búsqueda para filtrar la tabla -->
            <div class="buscador">
                <input type="text" id="filtroBusqueda" class="form-control me-auto" placeholder="Buscar domicilios..." onkeyup="filtrarTabla()">
            </div>

            <!--tabla de las unidades-->
            <table class="table table-hover tablaunidades" id="tablaUnidades">
                <thead style="background-color:rgba(87, 88, 88, 0.68); color: white;">
                    <tr class="titulostablaunidades">
                        <th class="titulostabladocumentos">ID</th>
                        <th class="titulostabladocumentos">Colaborador</th>
                        <th class="titulostabladocumentos">Dirección</th>
                        <th class="titulostabladocumentos">Comprobante</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include("../../Servidor/solicitudes/comprobantes_domicilios/obtener_comprobantes_domicilio.php"); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!----------------------------------------------------------------------- modal para agregar comprobantes de domicilio ------------------------------------------------------------------->
    <!-- Modal -->
    <div class="modal fade modalagregarcomprobantedomicilio" id="modalagregarcomprobantedomicilio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar nueva comprobante de domicilio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalagregarlicencia"></button>
                </div>
                <div class="modal-body" id="modalagregarcomprobantedomiciliobody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btncerrarmodalagregarlicencia" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary btnagregardomicilio" id="btnagregardomicilio">Agregar domicilio</button>
                </div>
            </div>
        </div>
    </div>

    <!--js para filtrar la tabla de unidades-->
    <script src="../js/unidades/filtrar_tabla.js"></script>
    <!--js licencias conducir-->
    <script src="../js/comprobante_domicilio/comprobante_domicilio.js"></script>