<div class="ldr-dashboard-section">

    <!-- HEADER -->
    <div class="ldr-page-header">

        <div>

            <span class="ldr-page-badge">
                MÓDULO ADMINISTRACIÓN DE USUARIOS
            </span>

            <h1 class="ldr-page-title">
                Usuarios
            </h1>

            <p class="ldr-page-subtitle">
                Administra accesos, roles y permisos del sistema
            </p>

        </div>

        <div class="ldr-header-actions">

            <button class="btn-orange"
                data-bs-toggle="modal"
                data-bs-target="#modalUsuario">

                <i class="fas fa-plus"></i>
                Nuevo usuario

            </button>

        </div>

    </div>

    <!-- TABLA -->
    <div class="ldr-table-card">

        <div class="ldr-table-header">

            <div>
                <h2>Usuarios registrados</h2>

                <p>
                    Gestión de accesos y perfiles
                </p>
            </div>

        </div>

        <div class="table-responsive">

            <table class="table ldr-table" id="tableUsuarios">

                <thead>

                    <tr>

                        <th>Colaborador</th>
                        <th>Rol</th>
                        <th>Estatus</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody></tbody>

            </table>

        </div>

    </div>

</div>

<div class="modal fade"
    id="modalUsuario"
    tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content panel-acciones-final border-0">

            <div class="modal-body p-4">

                <!-- HEADER -->
                <div class="titulo-seccion-orange mb-4">

                    <div class="icono-seccion">
                        <i class="fas fa-users"></i>
                    </div>

                    <div>

                        <h5 class="mb-1 fw-bold titulo-modal-usuario">
                            Alta de usuario
                        </h5>

                        <small>
                            Registra nuevos accesos al sistema
                        </small>

                    </div>

                </div>

                <!-- FORM -->
                <form id="formUsuario">

                    <input type="hidden"
                        id="idusuario"
                        name="idusuario">

                    <input type="hidden"
                        id="id_colaborador"
                        name="id_colaborador">

                    <div class="row">

                        <!-- COLABORADOR -->
                        <div class="col-md-12 mb-4">

                            <label class="label-form">
                                Colaborador
                            </label>

                            <input type="text"
                                class="form-control input-moderno"
                                id="buscarColaborador"
                                placeholder="Buscar colaborador..."
                                autocomplete="off"
                                required>

                            <div id="resultadoColaborador"
                                class="resultado-buscador">
                            </div>

                        </div>

                        <!-- ROL -->
                        <div class="col-md-12 mb-4">

                            <label class="label-form">
                                Rol
                            </label>

                            <select class="form-select input-moderno"
                                id="idrol"
                                name="idrol"
                                required>

                                <option value="">
                                    Seleccionar rol
                                </option>

                                <?php

                                $sqlRoles = "
                                    SELECT *
                                    FROM roles
                                    WHERE status = 1
                                ";

                                $resultRoles = $conexion->query($sqlRoles);

                                while ($rol = $resultRoles->fetch_assoc()) {

                                    echo '
                                        <option value="' . $rol['idrol'] . '">
                                            ' . $rol['nombrerol'] . '
                                        </option>
                                    ';
                                }

                                ?>

                            </select>

                        </div>

                    </div>

                    <!-- BOTONES -->
                    <div class="d-flex justify-content-end gap-2">

                        <button type="button"
                            class="btn btn-light btn-modern"
                            data-bs-dismiss="modal">

                            Cancelar

                        </button>

                        <button type="submit"
                            class="btn-orange btnGuardarUsuario">

                            <i class="fas fa-save"></i>
                            Guardar usuario

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>