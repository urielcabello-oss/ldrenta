<?php
include("../../Servidor/conexion.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔐 Validar sesión
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['id_modulo'])) {
    header("Location: ../../default.php");
    exit;
}

// Datos desde sesión (ya vienen del login)
$id_usuario = $_SESSION['id_usuario'];
$id_tipo_usuario = $_SESSION['id_tipo_usuario'];
$id_modulo = $_SESSION['id_modulo'];
$colaborador = $_SESSION['id_colaborador'];

?>

<div class="container mt-4" style="padding-top: 80px;">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h4 class="titulo-validacion">Administración de unidades</h4>
      <p class="subtitulo-validacion">Alta y ediciones de registros</p>
    </div>

    <div class="d-flex flex-wrap gap-2">
      <button onclick="window.location.href='../interfaces/agrega_nuevas_unidades.php'"
        class="btn btn-agregarunidad">
        <i class="fa-solid fa-car"></i> Agregar
      </button>

      <button class="btn btn-asignarunidad btnasignarunidades">
        <i class="fa-solid fa-route"></i> Asignar
      </button>

      <button class="btn btn-asignarexterno btnasignarunidadesexternos">
        <i class="fa-solid fa-person-walking-arrow-right"></i> Asignar externos
      </button>
    </div>
  </div>

  <hr>

  <!-- Tabla -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="p-3 border rounded">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <button class="btn btn-warning" data-bs-toggle="offcanvas" data-bs-target="#panelValidaciones">
    <i class="fa-solid fa-circle-check"></i> Validaciones
  </button>
          <h5 class="mb-0">Listado</h5>
        </div>

        <div class="table-responsive">
          <table class="table table-hover" id="flotillaTable">
            <thead class="table-light">
              <tr>
                <th>Editar</th>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Placa</th>
                <th>VIN</th>
                <th>Estatus</th>
                <th>Asignado a</th> <!-- seguirá en el HTML -->
                <th>Tipo de unidad</th>
                <th>Sede</th>
                <th>Kilometraje</th>
                <th>Maps</th>
                <th>Seguros</th>
                <th>Tenencias</th>
                <th>Verificaciones</th>
              </tr>
            </thead>
            <tbody id="flotillaBody"></tbody>
          </table>
        </div>

      </div>
    </div>
  </div>

</div>

<!-- PANEL VALIDACIONES -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="panelValidaciones">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Archivos pendientes</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>

  <div class="offcanvas-body">

  <!-- 🔎 FILTROS -->
  <div class="mb-3">
    <select id="filtroTipo" class="form-select">
      <option value="todos">Todos</option>
      <option value="tenencia">Tenencias</option>
      <option value="verificacion">Verificaciones</option>
      <option value="licencia">Licencias</option>
    </select>
  </div>

  <!-- CONTENEDOR -->
  <div id="contenedorValidaciones">
    <p class="text-muted">Cargando...</p>
  </div>

</div>
</div>


<!----------------------------------------------------------------------- modal de edicion de unidades ------------------------------------------------------------------->
<!-- Modal -->
<div class="modal fade modaleditarunidades" id="modalEditarUnidades" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


<!--js para mandar a llamar el modal de edicion de unidades-->
<script src="../js/unidades/modulo_flotilla.js"></script>
<!--js para mandar a llamar el modal de edicion de unidades-->
<script src="../js/unidades/editarunidades.js"></script>
<!--js para mandar a llamar el modal de edicion de unidades-->
<script src="../js/unidades/validacion_documentos_rh.js"></script>
<!--js para mandar a llamar el modal de polizas aseguradoras-->
<script src="../js/polizas/modulo_poliza_aseguradora.js"></script>
<!--js para mandar a llamar el modal de polizas tenencias-->
<script src="../js/polizas/modulo_poliza_tenencia.js"></script>
<!--js para mandar a llamar el modal de polizas tenencias-->
<script src="../js/polizas/modulo_poliza_verificacion.js"></script>
<!--js para filtrar la tabla de unidades-->
<script src="../js/unidades/filtrar_tabla.js"></script>
<!--js para editar polizas de seguros-->
<script src="../js/polizas/editar_polizas.js"></script>
<!--js para editar polizas tenencias-->
<script src="../js/polizas/editar_tenencias.js"></script>
<!--js para editar polizas verificaciones-->
<script src="../js/polizas/editar_verificaciones.js"></script>
<!--asignar unidades-->
<script src="../js/asignar_unidades/asignar_unidades.js"></script>
<!--asignar unidades externos-->
<script src="../js/asignar_unidades/asignar_unidades_externos.js"></script>
<!--js para poder obtener iinformacion del mapa -->
<script src="../js/api/obtener_mapa_telematics.js"></script>