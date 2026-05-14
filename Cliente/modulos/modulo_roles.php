<div class="ldr-dashboard-section">

    <!-- HEADER -->
    <div class="ldr-page-header">

        <div>

            <span class="ldr-page-badge">
                MÓDULO ADMINISTRACIÓN DE ROLES
            </span>

            <h1 class="ldr-page-title">
                Roles y permisos
            </h1>

            <p class="ldr-page-subtitle">
                Administra roles y accesos del sistema
            </p>

        </div>

        <div class="ldr-header-actions">

            <button class="btn-orange"
                    data-bs-toggle="modal"
                    data-bs-target="#modalRol">

                <i class="fas fa-plus"></i>
                Nuevo rol

            </button>

        </div>

    </div>

    <!-- TABLA -->
    <div class="ldr-table-card">

        <div class="ldr-table-header">

            <div>

                <h2>Roles registrados</h2>

                <p>
                    Gestión de permisos y accesos
                </p>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table ldr-table" id="tableRoles">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Rol</th>
                        <th>Descripción</th>
                        <th>Estatus</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody></tbody>

            </table>

        </div>

    </div>

</div>

<!-- MODAL ROL -->
<div class="modal fade"
     id="modalRol"
     tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content panel-acciones-final border-0">

            <div class="modal-body p-4">

                <div class="titulo-seccion-orange mb-4">

                    <div class="icono-seccion">
                        <i class="fas fa-user-shield"></i>
                    </div>

                    <div>

                        <h5 class="mb-1 fw-bold titulo-modal-rol">
                            Alta de rol
                        </h5>

                        <small>
                            Registra roles del sistema
                        </small>

                    </div>

                </div>

                <form id="formRol">

                    <input type="hidden"
                           id="idrol"
                           name="idrol">

                    <div class="row">

                        <div class="col-md-12 mb-4">

                            <label class="label-form">
                                Nombre del rol
                            </label>

                            <input type="text"
                                   class="form-control input-moderno"
                                   id="nombrerol"
                                   name="nombrerol"
                                   required>

                        </div>

                        <div class="col-md-12 mb-4">

                            <label class="label-form">
                                Descripción
                            </label>

                            <textarea class="form-control input-moderno"
                                      id="descripcion"
                                      name="descripcion"
                                      rows="3"></textarea>

                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2">

                        <button type="button"
                                class="btn btn-light btn-modern"
                                data-bs-dismiss="modal">

                            Cancelar

                        </button>

                        <button type="submit"
                                class="btn-orange btnGuardarRol">

                            <i class="fas fa-save"></i>
                            Guardar rol

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- MODAL PERMISOS -->
<div class="modal fade"
     id="modalPermisos"
     tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content panel-acciones-final border-0">

            <div class="modal-body p-4">

                <div class="titulo-seccion-orange mb-4">

                    <div class="icono-seccion">
                        <i class="fas fa-key"></i>
                    </div>

                    <div>

                        <h5 class="mb-1 fw-bold">
                            Permisos del rol
                        </h5>

                        <small>
                            Configura permisos por módulo
                        </small>

                    </div>

                </div>

                <input type="hidden" id="idrolPermiso">

                <div class="table-responsive">

                    <table class="table table-bordered align-middle">

                        <thead>

                            <tr>

                                <th>Módulo</th>
                                <th>Leer</th>
                                <th>Escribir</th>
                                <th>Actualizar</th>
                                <th>Eliminar</th>

                            </tr>

                        </thead>

                        <tbody id="tbodyPermisos"></tbody>

                    </table>

                </div>

                <div class="d-flex justify-content-end mt-4">

                    <button class="btn-orange"
                            id="btnGuardarPermisos">

                        <i class="fas fa-save"></i>
                        Guardar permisos

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>