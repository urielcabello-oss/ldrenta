document.addEventListener("DOMContentLoaded", () => {
  obtenerIncidencias();
  obtenerUnidades();
  obtenerDashboardIncidencias();

  //=====================================================
  // BOTON NUEVA INCIDENCIA
  //=====================================================

  const btnNueva = document.getElementById("btnNuevaIncidencia");

  if (btnNueva) {
    btnNueva.addEventListener("click", () => {
      const modal = new bootstrap.Modal(
        document.getElementById("modalCrearIncidencia"),
      );

      modal.show();
    });
  }

  //=====================================================
  // BOTON GUARDAR
  //=====================================================

  const btnGuardar = document.getElementById("btnGuardarIncidencia");

  if (btnGuardar) {
    btnGuardar.addEventListener("click", registrarIncidencia);
  }

  //=====================================================
  // BOTON ACTUALIZAR
  //=====================================================

  const btnActualizar = document.getElementById("btnActualizarIncidencia");

  if (btnActualizar) {
    btnActualizar.addEventListener("click", actualizarIncidencia);
  }

  //=====================================================
  // BOTON ACTUALIZAR CAMPOS DEL ALTA
  //=====================================================

  const btnGuardarGestion = document.getElementById(
    "btnGuardarGestionIncidencia",
  );

  if (btnGuardarGestion) {
    btnGuardarGestion.addEventListener("click", actualizarIncidenciaCompleta);
  }
});

async function registrarIncidencia() {
  try {
    const form = document.getElementById("formCrearIncidencia");

    const formData = new FormData(form);

    // agregar evidencias manualmente
    archivosEvidencias.forEach((file) => {
      formData.append("evidencias[]", file);
    });

    const response = await fetch(
      "../../Servidor/solicitudes/incidencias_unidades/registrar_incidencia.php",
      {
        method: "POST",
        body: formData,
      },
    );

    const data = await response.json();

    if (data.success) {
      Swal.fire({
        icon: "success",
        title: "Incidencia registrada",
        timer: 1500,
        showConfirmButton: false,
      });

      form.reset();

      // LIMPIAR SELECT2
      $("#id_unidad").val(null).trigger("change");

      archivosEvidencias = [];

      renderizarEvidencias();

      obtenerIncidencias();
      obtenerDashboardIncidencias();

      bootstrap.Modal.getInstance(
        document.getElementById("modalCrearIncidencia"),
      ).hide();
    } else {
      Swal.fire({
        icon: "error",
        title: data.message,
      });
    }
  } catch (error) {
    console.error(error);

    Swal.fire({
      icon: "error",
      title: "Error al registrar",
    });
  }
}

//=====================================================
// EVIDENCIAS MULTIPLES
//=====================================================

let archivosEvidencias = [];

const btnAgregarEvidencias = document.getElementById("btnAgregarEvidencias");

const inputEvidencias = document.getElementById("inputEvidencias");

const listaEvidencias = document.getElementById("listaEvidencias");

if (btnAgregarEvidencias) {
  btnAgregarEvidencias.addEventListener("click", () => {
    inputEvidencias.click();
  });
}

if (inputEvidencias) {
  inputEvidencias.addEventListener("change", (e) => {
    const nuevosArchivos = Array.from(e.target.files);

    nuevosArchivos.forEach((file) => {
      archivosEvidencias.push(file);
    });

    renderizarEvidencias();

    inputEvidencias.value = "";
  });
}

//=====================================================
// RENDER EVIDENCIAS
//=====================================================

function renderizarEvidencias() {
  listaEvidencias.innerHTML = "";

  if (archivosEvidencias.length === 0) {
    listaEvidencias.innerHTML = `
            <div class="text-muted small">
                No hay archivos seleccionados
            </div>
        `;

    return;
  }

  archivosEvidencias.forEach((file, index) => {
    listaEvidencias.innerHTML += `
            <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">

                <div>
                    <i class="bi bi-file-earmark me-2"></i>
                    ${file.name}
                </div>

                <button type="button"
                    class="btn btn-sm btn-danger"
                    onclick="eliminarEvidencia(${index})">

                    <i class="bi bi-trash"></i>

                </button>

            </div>
        `;
  });
}

//=====================================================
// ELIMINAR ARCHIVO
//=====================================================

function eliminarEvidencia(index) {
  archivosEvidencias.splice(index, 1);

  renderizarEvidencias();
}

//=========================================================
// OBTENER INCIDENCIAS
//=========================================================

async function obtenerIncidencias() {
  try {
    const response = await fetch(
      "../../Servidor/solicitudes/incidencias_unidades/obtener_incidencias.php",
    );

    const data = await response.json();

    const tbody = document.getElementById("bodyIncidencias");

    tbody.innerHTML = "";

    if (!data.success) {
      return;
    }

    data.incidencias.forEach((incidencia) => {
      tbody.innerHTML += `

<tr>

    <td>
        ${incidencia.id_incidencia}
    </td>

    <td>
        ${incidencia.modelo}
    </td>

    <td>
        ${incidencia.tipo_incidencia}
    </td>

    <td>

        <span class="badge bg-${obtenerColorEstatus(incidencia.estatus)}">

            ${incidencia.estatus}

        </span>

    </td>

    <td>

        <span class="badge bg-${obtenerColorPrioridad(incidencia.prioridad)}">

            ${incidencia.prioridad}

        </span>

    </td>

    <td>
        ${incidencia.fecha_incidencia}
    </td>

    <td class="text-center">

        <button
            class="btn btn-sm btn-outline-primary rounded-pill"
            onclick="verIncidencia(${incidencia.id_incidencia})">

            <i class="bi bi-eye"></i>

        </button>

        <button
            class="btn btn-sm btn-outline-success rounded-pill"
            onclick="abrirModalEditar(${incidencia.id_incidencia})">

            <i class="bi bi-sliders"></i>

        </button>

        <button
    class="btn btn-sm btn-outline-warning rounded-pill"
    onclick="abrirGestionIncidencia(${incidencia.id_incidencia})">

    <i class="bi bi-pencil"></i>

</button>

    </td>

</tr>

`;
    });
  } catch (error) {
    console.error(error);
  }
}

//=========================================================
// COLORES PRIORIDAD
//=========================================================

function obtenerColorPrioridad(prioridad) {
  switch (prioridad) {
    case "BAJA":
      return "secondary";

    case "MEDIA":
      return "warning";

    case "ALTA":
      return "danger";

    case "CRITICA":
      return "dark";

    default:
      return "secondary";
  }
}

//=========================================================
// COLORES ESTATUS
//=========================================================

function obtenerColorEstatus(estatus) {
  switch (estatus) {
    case "ABIERTA":
      return "danger";

    case "EN_PROCESO":
      return "warning";

    case "RESUELTA":
      return "success";

    case "CERRADA":
      return "secondary";

    default:
      return "secondary";
  }
}

//=========================================================
// VER INCIDENCIA
//=========================================================

async function verIncidencia(id) {
  try {
    const response = await fetch(
      `../../Servidor/solicitudes/incidencias_unidades/obtener_incidencia.php?id=${id}`,
    );
    const data = await response.json();

    if (!data.success) {
      return;
    }

    const incidencia = data.incidencia;

    document.getElementById("detalleTitulo").innerText = incidencia.titulo;

    document.getElementById("detalleDescripcion").innerText =
      incidencia.descripcion;

    document.getElementById("detallePrioridad").innerText =
      incidencia.prioridad;

    document.getElementById("detalleEstatus").innerText = incidencia.estatus;

    document.getElementById("detalleUnidad").innerText = incidencia.modelo;

    //=====================================================
    // EVIDENCIAS
    //=====================================================

    const contenedorEvidencias = document.getElementById("detalleEvidencias");

    contenedorEvidencias.innerHTML = "";

    if (data.evidencias.length === 0) {
      contenedorEvidencias.innerHTML = `
  
    <div class="text-muted">
      No hay evidencias adjuntas
    </div>

  `;
    } else {
      data.evidencias.forEach((archivo) => {
        const esImagen = archivo.tipo_archivo.startsWith("image/");

        const ruta =
          "../../Servidor/evidencias/files/incidencias/" + archivo.ruta_archivo;

        contenedorEvidencias.innerHTML += `

      <div class="card border-0 shadow-sm mb-3">

        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center">

            <div>

              <div class="fw-semibold">
                ${archivo.nombre_archivo}
              </div>

              <small class="text-muted">
                ${archivo.tipo_archivo}
              </small>

            </div>

            <a href="${ruta}"
              target="_blank"
              class="btn btn-sm btn-primary rounded-pill">

              <i class="bi bi-eye me-1"></i>
              Ver

            </a>

          </div>

          ${
            esImagen
              ? `
              
              <div class="mt-3">

                <img
                  src="${ruta}"
                  class="img-fluid rounded-4 border"
                  style="max-height:300px; object-fit:cover;">

              </div>

              `
              : `
              
              <div class="mt-3 text-muted">

                <i class="bi bi-file-earmark-pdf fs-1"></i>

              </div>

              `
          }

        </div>

      </div>

    `;
      });
    }

    const modal = new bootstrap.Modal(
      document.getElementById("modalDetalleIncidencia"),
    );

    modal.show();
  } catch (error) {
    console.error(error);
  }
}

//=========================================================
// ABRIR MODAL EDITAR
//=========================================================

async function abrirModalEditar(id) {
  try {
    const response = await fetch(
      `../../Servidor/solicitudes/incidencias_unidades/obtener_incidencia.php?id=${id}`,
    );

    const data = await response.json();

    if (!data.success) {
      return;
    }

    const incidencia = data.incidencia;

    document.getElementById("editar_id_incidencia").value =
      incidencia.id_incidencia;

    document.getElementById("editar_estatus").value = incidencia.estatus;

    document.getElementById("editar_observaciones").value =
      incidencia.observaciones || "";

    const modal = new bootstrap.Modal(
      document.getElementById("modalEditarIncidencia"),
    );

    modal.show();
  } catch (error) {
    console.error(error);
  }
}

async function obtenerUnidades() {
  try {
    const response = await fetch(
      "../../Servidor/solicitudes/incidencias_unidades/obtener_incidencias_unidades.php",
    );

    const data = await response.json();

    const select = document.getElementById("id_unidad");

    select.innerHTML = `
      <option value="">
        Seleccione unidad
      </option>
    `;

    data.unidades.forEach((unidad) => {
      select.innerHTML += `
        <option value="${unidad.id_unidad}">

          ${unidad.nombre_marca}
          ${unidad.nombre_modelo}

          | VIN: ${unidad.vin}

          | PLACA: ${unidad.placa}

        </option>
      `;
    });

    //=========================================
    // ACTIVAR SELECT2
    //=========================================

    $("#id_unidad").select2({
      placeholder: "Buscar unidad...",
      width: "100%",
      dropdownParent: $("#modalCrearIncidencia"),
    });
  } catch (error) {
    console.error(error);
  }
}

//=========================================================
// ACTUALIZAR INCIDENCIA
//=========================================================

async function actualizarIncidencia() {
  try {
    const formData = new FormData();

    formData.append(
      "id_incidencia",
      document.getElementById("editar_id_incidencia").value,
    );

    formData.append("estatus", document.getElementById("editar_estatus").value);

    formData.append(
      "observaciones",
      document.getElementById("editar_observaciones").value,
    );

    const response = await fetch(
      "../../Servidor/solicitudes/incidencias_unidades/actualizar_incidencia.php",
      {
        method: "POST",
        body: formData,
      },
    );

    const data = await response.json();

    if (data.success) {
      Swal.fire({
        icon: "success",
        title: "Incidencia actualizada",
        timer: 1500,
        showConfirmButton: false,
      });

      // cerrar modal
      bootstrap.Modal.getInstance(
        document.getElementById("modalEditarIncidencia"),
      ).hide();

      // refrescar tabla
      obtenerIncidencias();

      // refrescar dashboard
      obtenerDashboardIncidencias();
    } else {
      Swal.fire({
        icon: "error",
        title: data.message,
      });
    }
  } catch (error) {
    console.error(error);

    Swal.fire({
      icon: "error",
      title: "Error al actualizar",
    });
  }
}

//=========================================================
// DASHBOARD INCIDENCIAS
//=========================================================

async function obtenerDashboardIncidencias() {
  try {
    const response = await fetch(
      "../../Servidor/solicitudes/incidencias_unidades/dashboard_incidencias.php",
    );

    const data = await response.json();

    if (!data.success) {
      return;
    }

    document.getElementById("cardAbiertas").innerText = data.abiertas;

    document.getElementById("cardAccidentes").innerText = data.accidentes;

    document.getElementById("cardRobos").innerText = data.robos;

    document.getElementById("cardTotalIncidencias").innerText = data.total;

    document.getElementById("cardTotalIncidencias2").innerText = data.total;

    document.getElementById("cardProceso").innerText = data.proceso;

    document.getElementById("cardFinalizadas").innerText = data.finalizadas;

    document.getElementById("cardCriticas").innerText = data.criticas;
  } catch (error) {
    console.error(error);
  }
}

//=========================================================
// ABRIR GESTION INCIDENCIA
//=========================================================

async function abrirGestionIncidencia(id) {
  try {
    const response = await fetch(
      `../../Servidor/solicitudes/incidencias_unidades/obtener_incidencia.php?id=${id}`,
    );

    const data = await response.json();

    if (!data.success) {
      return;
    }

    const i = data.incidencia;

    const contenedor = document.getElementById("contenedorGestionEvidencias");

    contenedor.innerHTML = "";

    if (data.evidencias.length === 0) {
      contenedor.innerHTML = `
    <div class="text-muted">
      Sin evidencias
    </div>
  `;
    } else {
      data.evidencias.forEach((archivo) => {
        const ruta =
          "../../Servidor/evidencias/files/incidencias/" + archivo.ruta_archivo;

        contenedor.innerHTML += `

      <div class="border rounded p-2 mb-2 d-flex justify-content-between align-items-center">

        <div>

          <div class="fw-semibold">
            ${archivo.nombre_archivo}
          </div>

        </div>

        <div class="d-flex gap-2">

          <a href="${ruta}"
            target="_blank"
            class="btn btn-sm btn-primary">

            Ver

          </a>

          <button
    type="button"
    class="btn btn-sm btn-danger"
    onclick="eliminarEvidenciaBD(${archivo.id_evidencia})">

    Eliminar

</button>

        </div>

      </div>

    `;
      });
    }

    document.getElementById("gestion_id_incidencia").value = i.id_incidencia;

    document.getElementById("gestion_prioridad").value = i.prioridad;

    document.getElementById("gestion_tipo").value = i.tipo_incidencia;

    document.getElementById("gestion_titulo").value = i.titulo;

    document.getElementById("gestion_descripcion").value = i.descripcion;

    document.getElementById("gestion_ubicacion").value = i.ubicacion;

    document.getElementById("gestion_taller").checked = i.requiere_taller == 1;

    document.getElementById("gestion_seguro").checked = i.requiere_seguro == 1;

    document.getElementById("gestion_juridico").checked =
      i.requiere_juridico == 1;

    const modal = new bootstrap.Modal(
      document.getElementById("modalGestionIncidencia"),
    );

    modal.show();
  } catch (error) {
    console.error(error);
  }
}

//=========================================================
// ACTUALIZAR COMPLETO
//=========================================================

async function actualizarIncidenciaCompleta() {
  try {
    const formData = new FormData();

    formData.append(
      "id_incidencia",
      document.getElementById("gestion_id_incidencia").value,
    );

    formData.append(
      "prioridad",
      document.getElementById("gestion_prioridad").value,
    );

    formData.append(
      "tipo_incidencia",
      document.getElementById("gestion_tipo").value,
    );

    formData.append("titulo", document.getElementById("gestion_titulo").value);

    formData.append(
      "descripcion",
      document.getElementById("gestion_descripcion").value,
    );

    formData.append(
      "ubicacion",
      document.getElementById("gestion_ubicacion").value,
    );

    formData.append(
      "requiere_taller",
      document.getElementById("gestion_taller").checked ? 1 : 0,
    );

    formData.append(
      "requiere_seguro",
      document.getElementById("gestion_seguro").checked ? 1 : 0,
    );

    formData.append(
      "requiere_juridico",
      document.getElementById("gestion_juridico").checked ? 1 : 0,
    );
    //=====================================================
    // NUEVAS EVIDENCIAS
    //=====================================================

    archivosGestionEvidencias.forEach((file) => {
      formData.append("evidencias[]", file);
    });

    const response = await fetch(
      "../../Servidor/solicitudes/incidencias_unidades/actualizar_incidencia_completa.php",
      {
        method: "POST",
        body: formData,
      },
    );

    const data = await response.json();

    if (data.success) {
      Swal.fire({
        icon: "success",
        title: "Incidencia actualizada",
        timer: 1500,
        showConfirmButton: false,
      });

      archivosGestionEvidencias = [];
      document.getElementById("inputGestionEvidencias").value = "";

      renderizarGestionEvidencias();

      bootstrap.Modal.getInstance(
        document.getElementById("modalGestionIncidencia"),
      ).hide();

      obtenerIncidencias();
      obtenerDashboardIncidencias();
    } else {
      Swal.fire({
        icon: "error",
        title: data.message || "Error al actualizar",
      });
    }
  } catch (error) {
    console.error(error);

    Swal.fire({
      icon: "error",
      title: "Error del servidor",
    });
  }
}

//=====================================================
// EVIDENCIAS NUEVAS EN GESTION
//=====================================================

let archivosGestionEvidencias = [];

const btnAgregarGestionEvidencias = document.getElementById(
  "btnAgregarGestionEvidencias",
);

const inputGestionEvidencias = document.getElementById(
  "inputGestionEvidencias",
);

const listaGestionEvidencias = document.getElementById(
  "listaGestionEvidencias",
);

if (btnAgregarGestionEvidencias) {
  btnAgregarGestionEvidencias.addEventListener("click", () => {
    inputGestionEvidencias.click();
  });
}

if (inputGestionEvidencias) {
  inputGestionEvidencias.addEventListener("change", (e) => {
    const nuevos = Array.from(e.target.files);

    nuevos.forEach((file) => {
      archivosGestionEvidencias.push(file);
    });

    renderizarGestionEvidencias();

    inputGestionEvidencias.value = "";
  });
}
//=====================================================
// RENDER GESTION EVIDENCIAS
//=====================================================

function renderizarGestionEvidencias() {
  listaGestionEvidencias.innerHTML = "";

  if (archivosGestionEvidencias.length === 0) {
    listaGestionEvidencias.innerHTML = `
    
      <div class="text-muted small">
        No hay archivos seleccionados
      </div>
    
    `;

    return;
  }

  archivosGestionEvidencias.forEach((file, index) => {
    listaGestionEvidencias.innerHTML += `

      <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">

        <div>

          <i class="bi bi-file-earmark me-2"></i>

          ${file.name}

        </div>

        <button
          type="button"
          class="btn btn-sm btn-danger"
          onclick="eliminarGestionEvidencia(${index})">

          <i class="bi bi-trash"></i>

        </button>

      </div>

    `;
  });
}

//=========================================================
// ELIMINAR EVIDENCIA BD
//=========================================================

async function eliminarEvidenciaBD(id_evidencia) {
  event.preventDefault();

  const confirmacion = await Swal.fire({
    title: "¿Eliminar evidencia?",
    text: "Esta acción no se puede deshacer",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  });

  if (!confirmacion.isConfirmed) {
    return;
  }

  try {
    const formData = new FormData();

    formData.append("id_evidencia", id_evidencia);

    const response = await fetch(
      "../../Servidor/solicitudes/incidencias_unidades/eliminar_evidencia.php",
      {
        method: "POST",
        body: formData,
      },
    );

    const data = await response.json();

    console.log(data);

    if (data.success) {
      Swal.fire({
        icon: "success",
        title: "Evidencia eliminada",
        timer: 1200,
        showConfirmButton: false,
      });

      abrirGestionIncidencia(
        document.getElementById("gestion_id_incidencia").value,
      );
    } else {
      Swal.fire({
        icon: "error",
        title: data.message || "Error al eliminar",
      });
    }
  } catch (error) {
    console.error(error);

    Swal.fire({
      icon: "error",
      title: "Error del servidor",
    });
  }
}
