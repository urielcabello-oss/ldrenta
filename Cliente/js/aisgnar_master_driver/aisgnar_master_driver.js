document.addEventListener("DOMContentLoaded", function () {
  const modalasugnarrmasterdriver = new bootstrap.Modal(
    document.getElementById("modalasugnarrmasterdriver")
  );
  const modalasugnarrmasterdriverbody = document.getElementById("modalasugnarrmasterdriverbody");
  const contenedorspinner = document.getElementById("contenedorspinner");

  let valor_id_master_driver;
  let valor_id_asignacion;

  // Abrir modal con formulario
  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btasignarmasterdriver")) {
      const id_asignacion_demo = event.target.getAttribute("id-asignacion_demo");
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/asignacion_unidades_demo/formulario_asignar_master_driver.php",
        data: { id_asignacion: id_asignacion_demo },
        success: function (response) {
          modalasugnarrmasterdriverbody.innerHTML = response;
          modalasugnarrmasterdriver.show();

          // Inicialmente deshabilitar botón hasta seleccionar una card
          const btn = document.getElementById("btnasignarmasterdriver");
          if (btn) btn.disabled = true;

          // Evento de selección de cada card
          document.querySelectorAll(".master-driver-card").forEach(card => {
            card.addEventListener("click", function () {
              // Quitar selección previa
              document.querySelectorAll(".master-driver-card").forEach(c => c.classList.remove("border-primary", "border-3"));
              card.classList.add("border-primary", "border-3");

              // Guardar valor en input hidden
              let inputSeleccion = document.getElementById("id_master_driver");
              if (!inputSeleccion) {
                inputSeleccion = document.createElement("input");
                inputSeleccion.type = "hidden";
                inputSeleccion.id = "id_master_driver";
                inputSeleccion.name = "id_master_driver";
                document.body.appendChild(inputSeleccion);
              }
              inputSeleccion.value = card.getAttribute("data-id");

              // Habilitar botón
              if (btn) btn.disabled = false;
            });
          });
        },
      });
    }
  });

  // Asignar Master Driver
  document.body.addEventListener("click", function (event) {
    if (event.target.id === "btnasignarmasterdriver") {
      valor_id_master_driver = document.getElementById("id_master_driver").value;
      valor_id_asignacion = document.getElementById("id_asignacion").value;

      if (!valor_id_master_driver || !valor_id_asignacion) return;

      Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción asignará al Máster Driver seleccionado.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, asignar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          contenedorspinner.style.display = "flex";

          const formData = new FormData();
          formData.append("id_master_driver", valor_id_master_driver);
          formData.append("id_asignacion", valor_id_asignacion);

          $.ajax({
            type: "POST",
            url: "../../Servidor/solicitudes/unidades/asignacion_unidades_demo/asignar_master_driver.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
              contenedorspinner.style.display = "none";
              try {
                const data = JSON.parse(response);

                if (data.success) {
                  Swal.fire({
                    title: "Asignado",
                    text: data.message,
                    icon: "success",
                  }).then(() => {
                    window.location.href = "./asignar_master_driver.php?resultado=MasterDriverAsignado";
                  });
                } else {
                  Swal.fire({
                    title: "Error",
                    text: data.message,
                    icon: "error",
                  });
                }
              } catch (err) {
                console.error("Error al parsear respuesta:", err, response);
                Swal.fire("Error", "Respuesta inesperada del servidor.", "error");
              }
            },
            error: function (xhr, status, error) {
              contenedorspinner.style.display = "none";
              console.error("Error AJAX:", error);
              Swal.fire("Error", "No se pudo conectar con el servidor.", "error");
            },
          });
        }
      });
    }
  });
});
