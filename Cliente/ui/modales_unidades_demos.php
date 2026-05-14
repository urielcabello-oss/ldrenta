
<!----------------------------------------------------------------------- modal de edicion de unidades ------------------------------------------------------------------->
<!-- Modal -->
<div class="modal fade modalEditarUnidadesdemo" id="modalEditarUnidadesdemo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar unidades</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalEditarUnidadesBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnactualizarunidad">Actualizar</button>
      </div>
    </div>
  </div>
</div>

<!----------------------------------------------------------------------- modal traslado de unidades ------------------------------------------------------------------->
<!--modal-->
<div class="modal fade" id="modalTrasladoUnidad" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Solicitud de traslado de unidad</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="row">

          <div class="col-md-6 mb-3">
            <label>Modelo</label>
            <input type="text" class="form-control" id="traslado_modelo" readonly>
          </div>

          <div class="col-md-6 mb-3">
            <label>Placa</label>
            <input type="text" class="form-control" id="traslado_placa" readonly>
          </div>

          <div class="row">

            <div class="col-md-6 mb-3">
              <label>Ubicación actual</label>
              <input type="text" class="form-control" id="traslado_origen">
            </div>

            <div class="col-md-6 mb-3">
              <label>Nueva ubicación</label>
              <input type="text" class="form-control" id="traslado_destino">
            </div>

            <div class="col-12 mb-3">
              <label>Motivo del traslado</label>
              <textarea class="form-control" id="traslado_motivo"></textarea>
            </div>

          </div>

        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" id="btnEnviarTraslado">Solicitar traslado</button>
      </div>

    </div>
  </div>
</div>


<!----------------------------------------------------------------------- modal de registro de aseguradoras ------------------------------------------------------------------->
<!-- Modal -->
<div class="modal fade modalpolizasunidades" id="modalPolizasUnidades" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seguros</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalPolizasUnidadesBody">
        <?php
        include("../../Servidor/componentes/formularioPolizas.php");
        ?>

        <div class="d-flex " style="padding-left: 20px;">
          <button type="button" class="btn btn-primary btn" id="btnguardaraseguradora">Guardar</button>
        </div>
        <div>
          <div class="contenedor_tabla_polizas">
            <div class="row">
              <div class="col-md">
                <h4>Historial</h4>
                <div class="contenedor_poliza_seguro" id="contenedor_poliza_seguro">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!--------------------------------------------------------------------------modal editar aseguradoras ------------------------------------------------------------------>
<!-- Modal -->
<div class="modal fade modalEditarPolizasUnidades" id="modaleditarpolizasUnidades" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar aseguradora</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalEditarPolizasUnidadesBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnguardarpolizaeditada">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!----------------------------------------------------------------------------modal registro tenencias------------------------------------------------------------>
<!-- Modal -->
<div class="modal fade modalTenenciasunidades" id="modalTenenciasunidades" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tenencias</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalTenenciasunidadesBody">
        <?php
        include("../../Servidor/componentes/formularioTenencias.php");
        ?>
        <div class="d-flex " style="padding-left: 20px;">
          <button type="button" class="btn btn-primary btn" id="btnguardartenencia">Guardar</button>
        </div>
        <div>
          <div class="contenedor_tabla_polizas">
            <div class="row">
              <div class="col-md">
                <h4>Historial</h4>
                <div class="contenedor_poliza_tenencia" id="contenedor_poliza_tenencia">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!--------------------------------------------------------------------------modal editar tenencias ------------------------------------------------------------------>
<!-- Modal -->
<div class="modal fade modalEditarTenencias" id="modalEditarTenencias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar tenencia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalEditarTenenciasBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnguardartenenciaedotada">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!----------------------------------------------------------------------------modal registro verificaciones------------------------------------------------------------>
<!-- Modal -->
<div class="modal fade modalverificaciones" id="modalverificaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verificaciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalverificacionesBody">
        <?php  ?>

        <?php
        include("../../Servidor/componentes/formularioVerificaciones.php");
        ?>
        <div class="d-flex " style="padding-left: 20px;">
          <button type="button" class="btn btn-primary btn" id="btnguardarverificacion">Guardar</button>
        </div>
        <div>
          <div class="contenedor_tabla_polizas">
            <div class="row">
              <div class="col-md">
                <h4>Historial</h4>
                <div class="contenedor_poliza_verificacion" id="contenedor_poliza_verificacion">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--------------------------------------------------------------------------modal editar verificaciones ------------------------------------------------------------------>
<!-- Modal -->
<div class="modal fade modalEditarVerificaciones" id="modalEditarVerificaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Aseguradora</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalEditarVerificacionesBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnguardarverificacioneditada">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!----------------------------------------------------------------------- Modal filtro de unidades ------------------------------------------------------------------>
<!-- Modal -->
<div class="modal fade modalfiltrounidades" id="modalfiltrounidades" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignar unidades</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalfiltrounidades"></button>
      </div>
      <div class="modal-body" id="modalfiltrounidadesbody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btncerrarmodalfiltrounidades" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<!------------------------------------------------------------------------- Modal ver unidad para asignacion exclusiva------------------------------------------------------------------>
<!--modal-->
<div class="modal fade modalasignarunidadexclusiva" id="modalasignarunidadexclusiva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Unidad exclusiva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalasignarunidadexclusivabody">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnasignarunidadexclusiva">Asignar</button>
      </div>
    </div>
  </div>
</div>

<!------------------------------------------------------------------------modal para asignar unidad a externos---------------------------------------------------->
<!--modal-->
<div class="modal fade modalasignarunidadexterno" id="modalasignarunidadexterno" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignar unidad a usuario externo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalasignarunidadexterno"></button>
      </div>
      <div class="modal-body" id="modalasignarunidadexternobody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btncerrarmodalasignarunidadexterno" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnasignarunidadexterno">Registrar</button>
      </div>
    </div>
  </div>
</div>


<!--------------------------------------------------------------------------Modal para ver el Mapa y saber donde esta la unidad-->
<!--modal-->
<div class="modal fade" id="modalMapa" tabindex="-1" aria-labelledby="modalMapaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ultima actualización de la ubicación de la unidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="mapaUnidad" style="height: 500px;"></div>
      </div>
    </div>
  </div>
</div>