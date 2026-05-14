<!--Aqui comienza el contenedor de unidades-->

<div class="container-fluid px-3 px-md-4 mt-4">

  <!-- HEADER -->
  <section class="ldr-page-header">

    <div>
      <span class="ldr-page-badge">
        GESTIÓN DE PERSONAS MORALES
      </span>

      <h1 class="ldr-page-title">
        Administración de personas morales
      </h1>

      <p class="ldr-page-subtitle">
        Registro y administración de personas morales para renta de unidades.
      </p>
    </div>


    <div class="ldr-header-actions">

      <button class="btn ldr-btn-primary btnagregarpersonamoral">
        <i class="fa-solid fa-user-plus me-2"></i> Registrar persona moral
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
          <label class="form-label fw-semibold mb-1">Buscar persona moral</label>

          <div class="input-group">
            <span class="input-group-text bg-white">
              <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text"
              id="filtroBusqueda"
              class="form-control"
              placeholder="Buscar por razón social o RFC..."
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
                    Listado de personas morales
                </h2>

                <p>
                    Consulta y administra todas las personas morales.
                </p>
            </div>

        </div>
      <div class="table-responsive">
        <table class="table table-hover tablaunidades" id="tablaUnidades">
          <thead>
            <tr>
              <th class="titulostablaunidades"></th>
              <th class="titulostablaunidades">ID</th>
              <th class="titulostablaunidades">Persona moral</th>
              <th class="titulostablaunidades">RFC</th>
              <th class="titulostablaunidades">Domicilio</th>
              <th class="titulostablaunidades">Contacto</th>
              <th class="titulostablaunidades">Resguardo de unidad</th>
              <th class="titulostablaunidades">Identificación o pasaporte</th>
              <th class="titulostablaunidades">Poder representante legal</th>
              <th class="titulostablaunidades">Constancia situación fiscal</th>
              <th class="titulostablaunidades">Domicilio</th>
              <th class="titulostablaunidades">Escritura constitutiva</th>
              <th class="titulostablaunidades">Escritura estatutos sociales</th>
              <th class="titulostablaunidades">Resguardo de la unidad</th>
            </tr>
          </thead>
          <tbody>
            <?php include("../../Servidor/componentes/obtener_personas_morales.php"); ?>
          </tbody>
        </table>
      </div>
    </section>
  </div>



  <!--js para mandar a llamar el modal de edicion de unidades-->
  <script src="../js/asignar_unidades_demo/alta_personas_morales.js"></script>
  <!--js para filtrar la tabla de unidades-->
  <script src="../js/unidades/filtrar_tabla.js"></script>