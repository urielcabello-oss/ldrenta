
<!-------------------------------------modal para subir el comodato correspondiente al usuario-------------------------------->
<!--modal-->
<div class="modal fade modalunidadcomodatodemo" id="modalunidadcomodatodemo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalunidadcomodatodemo"></button>
            </div>
            <div class="modal-body" id="modalunidadcomodatodemobody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalunidadcomodatodemo" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnenviarcomodato">Enviar</button>
            </div>
        </div>
    </div>
</div>

<!----------------------------------------modal para ver los archivos de las personas fisicas o morales------------------------------>
<!--modal-->
<div class="modal fade" id="modalArchivos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Archivos del solicitante</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="contenidoModalArchivos">
        <!-- Aquí se cargará el HTML desde AJAX -->
        <div class="text-center">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarComentarios">Guardar comentarios</button>
      </div>
    </div>
  </div>
</div>