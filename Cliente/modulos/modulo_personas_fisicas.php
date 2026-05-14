<?php
include("../../Servidor/conexion.php");

if (!isset($_SESSION)) {
  session_start();
}

// Verificar que la sesión tenga los datos necesarios
if (!isset($_SESSION['id_colaborador']) || !isset($_SESSION['id_tipo_usuario'])) {
  echo "Sesión inválida";
  exit;
}

$colaborador = $_SESSION['id_colaborador'];
$id_tipo_usuario = $_SESSION['id_tipo_usuario'];

?>


<!--Aqui comienza el contenedor de unidades-->
<div class="container-fluid px-3 px-md-4 mt-4">

  <!-- HEADER -->
  <section class="ldr-page-header">

    <div>
      <span class="ldr-page-badge">
        GESTIÓN DE PERSONAS FÍSICAS
      </span>

      <h1 class="ldr-page-title">
        Administración de personas físicas
      </h1>

      <p class="ldr-page-subtitle">
        Registro y administración de personas físicas para renta de unidades.
      </p>
    </div>


      <div class="ldr-header-actions">

        <button class="btn ldr-btn-primary btnagregarpersonafisica">
            <i class="fa-solid fa-user-plus me-2"></i> Registrar persona
          </button>

          <button class="btn btn-outline-secondary" onclick="window.history.back()">
            <i class="fa-solid fa-arrow-left me-2"></i> Regresar
          </button>

      </div>

  </section>
  <!----------------------------------------------------------------------- Tabla Responsiva de las unidades ------------------------------------------------------------------->
  <div class="contendortablaunidades" id="contendortablaunidades">
    <!-- Campo de búsqueda para filtrar la tabla -->
    <div class="panel-acciones-final p-3 mb-3">

      <div class="d-flex align-items-center gap-3 flex-wrap">

        <div class="flex-grow-1">
          <label class="form-label fw-semibold mb-1">Buscar persona</label>
          <div class="input-group">
            <span class="input-group-text bg-white">
              <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text"
              id="filtroBusqueda"
              class="form-control"
              placeholder="Buscar por nombre, CURP o RFC..."
              onkeyup="filtrarTabla()">
          </div>
        </div>

      </div>

    </div>
    <!--tabla de las unidades-->
    <section class="ldr-table-card">

      <div class="ldr-table-header">

            <div>
                <h2>
                    Listado de personas físicas
                </h2>

                <p>
                    Consulta y administra todas las personas físicas.
                </p>
            </div>

        </div>


      <div class="table-responsive">
        <table class="table align-middle ldr-table" id="tablaUnidades">
          <thead>
            <tr>
              <th class="titulostablaunidades"></th>
              <th class="titulostablaunidades">ID</th>
              <th class="titulostablaunidades">Nombre</th>
              <th class="titulostablaunidades">Género</th>
              <th class="titulostablaunidades">Curp</th>
              <th class="titulostablaunidades">RFC</th>
              <th class="titulostablaunidades">Domicilio</th>
              <th class="titulostablaunidades">Contacto</th>
              <th class="titulostablaunidades">Resguardo de unidad</th>
              <?php if ($id_tipo_usuario == 4): // Administrador demos 
              ?>
                <th class="titulostablaunidades">Creador de la persona</th>
              <?php endif; ?>
              <th class="titulostablaunidades">Identificación o pasaporte</th>
              <th class="titulostablaunidades">CURP</th>
              <th class="titulostablaunidades">Constancia de situación fiscal</th>
              <th class="titulostablaunidades">Comprobante de domicilio</th>
              <th class="titulostablaunidades">Resguardo de la unidad</th>
            </tr>
          </thead>
          <tbody>
            <?php include("../../Servidor/componentes/obtener_personas_fisicas.php"); ?>
          </tbody>
        </table>
      </div>
    </section>
  </div>


  <!--js para mandar a llamar el modal para dar de alta a las personas fisicas-->
  <script src="../js/asignar_unidades_demo/alta_personas_fisicas.js"></script>
  <!--js para mandar a llamar el modal para editar a las personas fisicas-->
  <script src="../js/asignar_unidades_demo/editar_persona_fisica.js"></script>
  <!--js para filtrar la tabla de unidades-->
  <script src="../js/unidades/filtrar_tabla.js"></script>