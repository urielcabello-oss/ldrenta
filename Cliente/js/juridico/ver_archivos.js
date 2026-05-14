document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("modalArchivos");
  const contenidoModal = document.getElementById("contenidoModalArchivos");
  const btnGuardar = document.getElementById("guardarComentarios");
  const contenedorspinner = document.getElementById("contenedorspinner");

  // Escuchar clic en cualquier botón con clase .btnverarchivos
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("btnverarchivos")) {
      const idUnidad = e.target.getAttribute("data-idunidad");
      const idAsignacion = e.target.getAttribute("data-idasignacion");
      const idColaborador = e.target.getAttribute("data-idcolaborador");

      // Mostrar spinner mientras carga
      contenidoModal.innerHTML = `
        <div class="text-center my-4">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
        </div>`;

      // Cargar los archivos del solicitante
      fetch("../../Servidor/solicitudes/unidades/comodato/obtener_archivos_solicitante_demo.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id_unidad=${idUnidad}&id_asignacion=${idAsignacion}`
      })
        .then((res) => res.text())
        .then((html) => {
          contenidoModal.innerHTML = html;
          const modalBootstrap = new bootstrap.Modal(modal);
          modalBootstrap.show();
        })
        .catch((err) => {
          console.error(err);
          contenidoModal.innerHTML = `<p class="text-danger text-center">Error al cargar archivos.</p>`;
        });
    }
  });

  // Guardar observaciones al hacer clic en el botón de la modal
  btnGuardar.addEventListener("click", function () {
    contenedorspinner.style.display = "flex";
    const form = document.querySelector("#contenidoModalArchivos form");
    if (!form) {
      alert("No se encontró el formulario de comentarios.");
      return;
    }

    const formData = new FormData(form);

    fetch("../../Servidor/solicitudes/unidades/comodato/guardar_observaciones_juridico.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then((data) => {
        console.log("Respuesta del servidor:", data);
        if (data.trim() === "ok") {
          contenedorspinner.style.display = "none";
         window.location.href = "./comodatos_demos.php?resultado=Observaciones";
        } else {
          alert("⚠️ " + data);
        }
      })
      .catch((err) => {
        console.error(err);
        alert("❌ Error al guardar observaciones.");
      });
  });
});
