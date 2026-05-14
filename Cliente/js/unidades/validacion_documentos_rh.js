let dataGlobal = [];

document.addEventListener("DOMContentLoaded", () => {
  const panel = document.getElementById("panelValidaciones");
  const filtro = document.getElementById("filtroTipo");

  panel.addEventListener("show.bs.offcanvas", () => {
    cargarValidaciones();
  });

  filtro.addEventListener("change", () => {
    renderizar(dataGlobal);
  });
});

function cargarValidaciones() {
  const contenedor = document.getElementById("contenedorValidaciones");
  contenedor.innerHTML = "Cargando...";

  fetch("../../Servidor/componentes/obtener_documentacion_pendiente_rh.php")
    .then((res) => res.json())
    .then((data) => {
      dataGlobal = data;
      renderizar(data);
    });
}

function renderizar(data) {
  const contenedor = document.getElementById("contenedorValidaciones");
  const filtro = document.getElementById("filtroTipo").value;

  let filtrados = data;

  if (filtro !== "todos") {
    filtrados = data.filter((item) => item.tipo === filtro);
  }

  if (filtrados.length === 0) {
    contenedor.innerHTML = "<p class='text-success'>✔ Sin pendientes</p>";
    return;
  }

  let html = "";

  filtrados.forEach((item) => {
    html += `
      <div class="card mb-3 shadow-sm">
        <div class="card-body">

          <h6>${item.tipo.toUpperCase()}</h6>
          <p class="mb-1"><strong>${item.tipo === "licencia" ? "Colaborador" : "Unidad"}:</strong> ${item.unidad}</p>
          ${item.numero_licencia ? `<p>No. Licencia: ${item.numero_licencia}</p>` : ""}
${item.fecha_emision ? `<p>Emisión: ${item.fecha_emision}</p>` : ""}
${item.fecha_vencimiento ? `<p>Vence: ${item.fecha_vencimiento}</p>` : ""}
${item.licencia_permanente === "PERMANENTE" ? `<p>Tipo: Permanente</p>` : ""}

          <a href="${item.ruta}" target="_blank"
        onclick="event.stopPropagation()">
        Ver documento
        </a>

          <div class="mt-2 d-flex gap-2">
            <button class="btn btn-success btn-sm"
              onclick="validarDocumento(${item.id}, '${item.tipo}', 'APROBADO')">
              ✔ Aprobar
            </button>

            <button class="btn btn-danger btn-sm"
              onclick="validarDocumento(${item.id}, '${item.tipo}', 'RECHAZADO')">
              ✖ Rechazar
            </button>
          </div>

        </div>
      </div>
    `;
  });

  contenedor.innerHTML = html;
}

function validarDocumento(id, tipo, estatus) {
  fetch("../../Servidor/solicitudes/unidades/validar_documentos_rh.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id, tipo, estatus }),
  })
    .then((res) => res.text())
    .then((res) => {
      if (res === "ok") {
        cargarValidaciones();
      } else {
        alert("Error: " + res);
      }
    });
}
