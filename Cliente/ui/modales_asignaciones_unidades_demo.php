
 <!---------------------------------------modal para solicitar prorrogas---------------------------------->
 <!--modal-->
 <div class="modal fade modalprorrogaunidaddemo" id="modalprorrogaunidaddemo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-fullscreen">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Solicitud de prórroga</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalprorrogaunidaddemo"></button>
             </div>
             <div class="modal-body" id="modalprorrogaunidaddemobody">
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" id="btncerrarmodalprorrogaunidaddemo" data-bs-dismiss="modal">Cerrar</button>
                 <button type="button" class="btn btn-primary btnsolicitarprorroga" id="btnsolicitarprorroga">Solicitar</button>
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

 <!--modal para suir el comodato firmado de la asignacion demo-->
 <!--modal-->
 <div class="modal fade modalsubircomodatodemo" id="modalsubircomodatodemo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Comodato de asignación</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalpruebademo"></button>
             </div>
             <div class="modal-body" id="modalsubircomodatodemobody">
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" id="btncerrarmodalpruebademo" data-bs-dismiss="modal">Cerrar</button>
                 <button type="button" class="btn btn-primary btnsubircomodatofirmado" id="btnsubircomodatofirmado">Guardar</button>
             </div>
         </div>
     </div>
 </div>

 <!--modal para ver las observaciones de la documentacion por parte de juridico-->
 <!--modal-->
 <div class="modal fade" id="modalObservaciones" tabindex="-1">
     <div class="modal-dialog modal-lg modal-dialog-scrollable">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Observaciones y Archivos</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
             </div>
             <div class="modal-body" id="contenidoModalObservaciones">
                 <!-- Aquí se cargará por AJAX:
             - Observaciones existentes
             - Archivos existentes con vista previa
             - Input para subir nuevo archivo -->
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                 <button type="button" class="btn btn-primary" id="guardarArchivoModal">Guardar Cambios</button>
             </div>
         </div>
     </div>
 </div>
