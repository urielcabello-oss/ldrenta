<!-------------------------------------------aqui comienza el contenedor mis unidades cliente----------------------------------------------------------->
<!------------------------------------------- UNIDADES ASIGNADAS ------------------------------------------->
<div class="container">
  <div class="panel-unidades-asignadas">

    <!-- HEADER -->
    <div class="header-unidades-asignadas">
      <div>
        <h4 class="titulo-unidades-asignadas">Unidades asignadas</h4>
        <p class="subtitulo-unidades-asignadas">Gestión rápida de vehículos vinculados</p>
      </div>

      <div class="acciones-unidades">
        <button
          id="botonCambiarVistaUnidades"
          class="btn btn-toggle-vista"
          onclick="toggleVistaUnidades()">
          <i class="fa-solid fa-grip"></i> Cambiar a cards
        </button>

      </div>
    </div>

    <!-- TOOLBAR -->
    <div class="toolbar-unidades-asignadas row align-items-center mt-3">
      <div class="col-md-5 mb-2">
        <input
          type="text"
          id="filtroBusqueda"
          class="form-control input-unidades-asignadas"
          placeholder="Buscar por usuario, placa, VIN o modelo..."
          onkeyup="filtrarCards(); filtrarTablaUnidades()">
      </div>

      <div class="col-md-3 mb-2">
        <select id="filtroTipo" class="form-select" onchange="filtrarCards(); filtrarTablaUnidades()">
          <option value="">Todos</option>
          <option value="exclusivo">Exclusivo</option>
          <option value="pool">Pool</option>
          <option value="externo">Externo</option>
        </select>
      </div>

      <div class="col-md-2 mb-2">
        <select id="filtroEstado" class="form-select" onchange="filtrarCards(); filtrarTablaUnidades()">
          <option value="">Estado</option>
          <option value="activo">Activo</option>
          <option value="devuelto">Devuelto</option>
        </select>
      </div>
    </div>

  </div>
</div>


<!-- CONTENIDO -->
<div class="contenedormisunidades">

  <!-- VISTA CARDS -->
  <div id="vistaCardsUnidades" style="display:none;">

    <h5 class="seccion-mis-unidades">Vehículos exclusivos</h5>
    <div class="contenedorcardunidades">
      <?php include("../../Servidor/componentes/obtener_unidades_asignadas.php"); ?>
    </div>

    <h5 class="seccion-mis-unidades">Vehículos pool</h5>
    <div class="contenedorcardunidades">
      <?php include("../../Servidor/componentes/obtener_unidades_asignadas_pool.php"); ?>
    </div>

    <h5 class="seccion-mis-unidades">Vehículos asignados a usuarios externos</h5>
    <div class="contenedorcardunidades">
      <?php include("../../Servidor/componentes/obtener_unidades_asignadas_externos.php"); ?>
    </div>

  </div>


  <!-- VISTA TABLA -->
  <div id="vistaTablaUnidades" style="display:block;">
    <?php include("../../Servidor/componentes/obtener_unidades_asignadas_tabla.php"); ?>
  </div>

</div>



<!---------------------------------------------modal para la informacion de asignascion de unidades de manera precencial---------------------------------->
<!--modal-->
<div class="modal fade modalasignacionpresencial" id="modalasignacionpresencial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalles de la unidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalasignacionpresencial"></button>
      </div>
      <div class="modal-body" id="modalasignacionpresencialbody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btncerrarmodalasignacionpresencial" data-bs-dismiss="modal">Cerrar</button>


      </div>
    </div>
  </div>
</div>

<!--------------------------------------------modal para el cheklist de las unidades----------------------------------->
<!--modal-->
<div class="modal fade modalcheklistunidad" id="modalcheklistunidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cheklist de la unidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalcheklistunidad"></button>
      </div>
      <div class="modal-body" id="modalcheklistunidadbody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btncerrarmodalcheklistunidad" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnguardarcheklistunidad">Entregar</button>
      </div>
    </div>
  </div>
</div>


<script>
  function toggleVistaUnidades() {
    const vistaCards = document.getElementById("vistaCardsUnidades");
    const vistaTabla = document.getElementById("vistaTablaUnidades");
    const boton = document.getElementById("botonCambiarVistaUnidades");

    if (!vistaCards || !vistaTabla) return;

    if (vistaCards.style.display === "none") {
      vistaCards.style.display = "block";
      vistaTabla.style.display = "none";
      boton.innerHTML = '<i class="fa-solid fa-table"></i> Cambiar a tabla';
    } else {
      vistaCards.style.display = "none";
      vistaTabla.style.display = "block";
      boton.innerHTML = '<i class="fa-solid fa-grip"></i> Cambiar a cards';
    }
  }

  function filtrarTablaUnidades() {
    const texto = document.getElementById("filtroBusqueda").value.toLowerCase();
    const tipo = document.getElementById("filtroTipo").value.toLowerCase();
    const estado = document.getElementById("filtroEstado").value.toLowerCase();

    const tabla = document.getElementById("tablaUnidadesAsignadas");
    if (!tabla) return;

    const rows = tabla.querySelectorAll("tbody tr");

    rows.forEach(row => {
      const contenido = row.innerText.toLowerCase();

      let visible = true;

      if (texto && !contenido.includes(texto)) {
        visible = false;
      }

      if (tipo && !contenido.includes(tipo)) {
        visible = false;
      }

      if (estado && !contenido.includes(estado)) {
        visible = false;
      }

      row.style.display = visible ? "" : "none";
    });
  }

  function devolverUnidad(idAsignacion, idUnidad) {
  Swal.fire({
    title: '¿Devolver unidad?',
    text: 'La unidad volverá a estar disponible.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, devolver',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {

      fetch("../../Servidor/solicitudes/unidades/asignacion_unidades/devolver_unidad.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id_asignaciones=${idAsignacion}&id_unidad=${idUnidad}`
      })
      .then(r => r.json())
      .then(data => {
        if (data.status) {
          Swal.fire("Correcto", data.msg, "success");
          location.reload();
        } else {
          Swal.fire("Error", data.msg, "error");
        }
      });

    }
  });
}
</script>

<!--js para filtrar las cards de unidades-->
<script src="../js/unidades/filtrar_cards.js"></script>
<!--js para asignar la unidad de manera precencial-->
<script src="../js/asignar_unidades/asignar_unidades_presencial.js"></script>