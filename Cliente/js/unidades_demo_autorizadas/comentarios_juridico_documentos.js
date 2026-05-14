document.addEventListener("DOMContentLoaded", () => {
  const modal = new bootstrap.Modal(document.getElementById("modalObservaciones"));
  const modalBody = document.getElementById("contenidoModalObservaciones");

  document.querySelectorAll(".btnVerObservaciones").forEach(btn => {
    btn.addEventListener("click", () => {
      const idAsignacion = btn.dataset.idAsignacionDemo;
      modalBody.innerHTML = '<div class="text-center p-3">Cargando...</div>';
      modal.show();

      fetch(`../../Servidor/solicitudes/unidades_demo_autorizadas/obtener_observaciones_solicitante.php?id_asignacion_demo=${idAsignacion}`)
        .then(res => res.text())
        .then(data => {
          modalBody.innerHTML = data;

          // Crear input file solo para actualizar archivo
          document.querySelectorAll(".archivo-observado").forEach(item => {
            const input = document.createElement("input");
            input.type = "file";
            input.accept = ".pdf";
            input.name = "archivo_actualizado_" + item.dataset.campo;
            input.classList.add("form-control", "mt-2");
            item.parentNode.appendChild(input);
          });

          // Guardar ID asignación para el submit
          modalBody.dataset.id_asignacion = idAsignacion;
        });
    });
  });

  // Botón de guardar cambios
  document.getElementById("guardarArchivoModal").addEventListener("click", () => {
    const formData = new FormData();
    const idAsignacion = modalBody.dataset.id_asignacion;
    formData.append("id_asignacion", idAsignacion);

    document.querySelectorAll("#contenidoModalObservaciones input[type=file]").forEach(input => {
      if (input.files[0]) {
        formData.append(input.name, input.files[0]);
      }
    });

    fetch("../../Servidor/solicitudes/unidades_demo_autorizadas/actualizar_archivo_observacion.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.text())
    .then(data => {
      if(data.trim() === "ok"){
        Swal.fire("Listo", "Archivos actualizados correctamente", "success");
        modal.hide();
      } else {
        Swal.fire("Error", data, "error");
      }
    });
  });
});
