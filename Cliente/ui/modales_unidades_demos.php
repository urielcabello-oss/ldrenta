<!-- =========================================================
MODAL EDITAR UNIDAD DEMO
========================================================= -->
<div class="modal fade"
    id="modalEditarUnidadesdemo"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content panel-acciones-final border-0 position-relative">
      <!-- BOTÓN CERRAR -->
      <button type="button"
        class="btn-close btn-close-white ldr-btn-close"
        data-bs-dismiss="modal"
        aria-label="Close">
      </button>
      <div class="modal-body p-4">
        <!-- HEADER -->
        <div class="titulo-seccion-orange mb-4">
          <div class="icono-seccion">
            <i class="fas fa-truck"></i>
          </div>
          <div>
            <h5 class="mb-1 fw-bold">
              Editar unidad
            </h5>
            <small>
              Actualiza la información general de la unidad
            </small>
          </div>
        </div>
        <!-- BODY DINÁMICO -->
        <div id="modalEditarUnidadesBody"></div>
        <!-- FOOTER -->
        <div class="d-flex justify-content-end gap-2 mt-4">
          <button type="button"
            class="btn btn-light btn-modern"
            data-bs-dismiss="modal">
            Cancelar
          </button>
          <button type="button"
            class="btn-orange"
            id="btnactualizarunidad">
            <i class="fas fa-save"></i>
            Actualizar unidad
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- =========================================================
MODAL PÓLIZAS / SEGUROS
========================================================= -->
<div class="modal fade modalpolizasunidades"
    id="modalPolizasUnidades"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content panel-acciones-final border-0 position-relative">
            <!-- BOTÓN CERRAR -->
            <button type="button"
                class="btn-close btn-close-white ldr-btn-close"
                data-bs-dismiss="modal"
                aria-label="Close">
            </button>
            <div class="modal-body p-4">
                <!--  HEADER -->
                <div class="titulo-seccion-orange mb-4">
                    <div class="icono-seccion">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">
                            Gestión de seguros
                        </h4>
                        <small>
                            Administra pólizas, aseguradoras e historial de cobertura
                        </small>
                    </div>
                </div>
                <!-- CONTENIDO -->
                <div class="row g-4">
                    <!-- FORMULARIO -->
                    <div class="col-xl-4">
                        <div class="ldr-card-form h-100">
                            <div class="ldr-card-header">
                                <h5>
                                    <i class="fas fa-file-circle-plus me-2"></i>
                                    Registrar póliza
                                </h5>
                            </div>
                            <div class="ldr-card-body">
                                <?php
                                include("../../Servidor/componentes/formularioPolizas.php");
                                ?>
                                <div class="d-grid mt-4">
                                    <button type="button"
                                        class="btn-orange"
                                        id="btnguardaraseguradora">
                                        <i class="fas fa-save me-2"></i>
                                        Guardar póliza
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  HISTORIAL -->
                    <div class="col-xl-8">
                        <div class="ldr-card-form h-100">
                            <div class="ldr-card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-clock-rotate-left me-2"></i>
                                    Historial de pólizas
                                </h5>
                                <span class="badge bg-primary">
                                    Seguros registrados
                                </span>
                            </div>
                            <div class="ldr-card-body">
                                <div id="contenedor_poliza_seguro"
                                    class="contenedor_poliza_seguro">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FOOTER -->
            <div class="modal-footer border-0">
                <button type="button"
                    class="btn btn-light btn-modern"
                    data-bs-dismiss="modal">
                    Cerrar
                </button>
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

<!-- =========================================================
MODAL TENENCIAS
========================================================= -->
<div class="modal fade modalTenenciasunidades"
    id="modalTenenciasunidades"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content panel-acciones-final border-0 position-relative">
            <!-- BOTÓN CERRAR -->
            <button type="button"
                class="btn-close btn-close-white ldr-btn-close"
                data-bs-dismiss="modal"
                aria-label="Close">
            </button>
            <div class="modal-body p-4">
                <!--  HEADER -->
                <div class="titulo-seccion-orange mb-4">
                    <div class="icono-seccion">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">
                            Gestión de tenencias
                        </h4>
                        <small>
                            Administra pólizas, tenencias e historial
                        </small>
                    </div>
                </div>
                <!-- CONTENIDO -->
                <div class="row g-4">
                    <!-- FORMULARIO -->
                    <div class="col-xl-4">
                        <div class="ldr-card-form h-100">
                            <div class="ldr-card-header">
                                <h5>
                                    <i class="fas fa-file-circle-plus me-2"></i>
                                    Registrar póliza
                                </h5>
                            </div>
                            <div class="ldr-card-body">
                                <?php
                                include("../../Servidor/componentes/formularioTenencias.php");
                                ?>
                                <div class="d-grid mt-4">
                                    <button type="button"
                                        class="btn-orange"
                                        id="btnguardartenencia">
                                        <i class="fas fa-save me-2"></i>
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  HISTORIAL -->
                    <div class="col-xl-8">
                        <div class="ldr-card-form h-100">
                            <div class="ldr-card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-clock-rotate-left me-2"></i>
                                    Historial 
                                </h5>
                                <span class="badge bg-primary">
                                    Tenencias registrados
                                </span>
                            </div>
                            <div class="ldr-card-body">
                                <div id="contenedor_poliza_tenencia"
                                    class="contenedor_poliza_tenencia">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FOOTER -->
            <div class="modal-footer border-0">
                <button type="button"
                    class="btn btn-light btn-modern"
                    data-bs-dismiss="modal">
                    Cerrar
                </button>
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


<!-- =========================================================
MODAL TENENCIAS
========================================================= -->
<div class="modal fade modalverificaciones"
    id="modalverificaciones"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content panel-acciones-final border-0 position-relative">
            <!-- BOTÓN CERRAR -->
            <button type="button"
                class="btn-close btn-close-white ldr-btn-close"
                data-bs-dismiss="modal"
                aria-label="Close">
            </button>
            <div class="modal-body p-4">
                <!--  HEADER -->
                <div class="titulo-seccion-orange mb-4">
                    <div class="icono-seccion">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">
                            Gestión de verificaciones
                        </h4>
                        <small>
                            Administra pólizas, verificaciones e historial
                        </small>
                    </div>
                </div>
                <!-- CONTENIDO -->
                <div class="row g-4">
                    <!-- FORMULARIO -->
                    <div class="col-xl-4">
                        <div class="ldr-card-form h-100">
                            <div class="ldr-card-header">
                                <h5>
                                    <i class="fas fa-file-circle-plus me-2"></i>
                                    Registrar póliza
                                </h5>
                            </div>
                            <div class="ldr-card-body">
                                <?php
                                include("../../Servidor/componentes/formularioVerificaciones.php");
                                ?>
                                <div class="d-grid mt-4">
                                    <button type="button"
                                        class="btn-orange"
                                        id="btnguardarverificacion">
                                        <i class="fas fa-save me-2"></i>
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  HISTORIAL -->
                    <div class="col-xl-8">
                        <div class="ldr-card-form h-100">
                            <div class="ldr-card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-clock-rotate-left me-2"></i>
                                    Historial 
                                </h5>
                                <span class="badge bg-primary">
                                    Tenencias registrados
                                </span>
                            </div>
                            <div class="ldr-card-body">
                                <div id="contenedor_poliza_verificacion"
                                    class="contenedor_poliza_verificacion">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FOOTER -->
            <div class="modal-footer border-0">
                <button type="button"
                    class="btn btn-light btn-modern"
                    data-bs-dismiss="modal">
                    Cerrar
                </button>
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