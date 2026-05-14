document.addEventListener("DOMContentLoaded", function () {
  const modal = new bootstrap.Modal(
    document.getElementById("modalEditarUnidadesdemo"),
  );
  const body = document.getElementById("modalEditarUnidadesBody");
  const spinner = document.getElementById("contenedorspinner");

  let idUnidad = null;

  // 🔹 Mayúsculas automáticas
  document.addEventListener("input", function (e) {
    if (e.target.tagName === "INPUT" && e.target.type === "text") {
      e.target.value = e.target.value.toUpperCase();
    }
  });

  // 🔹 Abrir modal
  document.body.addEventListener("click", function (e) {
    if (e.target.classList.contains("btneditarunidadesdemo")) {
      idUnidad = e.target.dataset.id;

      $.post(
        "../../Servidor/solicitudes/unidades/formularioeditarunidadesdemo.php",
        { idunidad: idUnidad },
        function (response) {
          body.innerHTML = response;
          modal.show();
        },
      );
    }
  });

  // 🔹 Actualizar
  document.body.addEventListener("click", function (e) {
    if (e.target.id === "btnactualizarunidad") {
      e.preventDefault();
      actualizarUnidad();
    }
  });

  function actualizarUnidad() {
    spinner.style.display = "flex";

    const form = new FormData();

    form.append("id_unidad", idUnidad);

    // 🔹 Lista de campos
    const campos = [
      "marcaeditarunidad",
      "modeloeditarunidad",
      "editarVIN",
      "editarPlaca",
      "editarNumeroMotor",
      "editarCostoNeto",
      "editarColor",
      "editarañounidad",
      "editarEstadoUnidad",
      "editarEstatusUnidad",
      "editarTipoUnidad",
      "editsedeunidad",
      "editartipoadquisicionunidad",
      "editartipoarrendadoraunidad",
      "editarfoliofacturaunidad",
      "editarfechaadquisicionunidad",
      "editarPasoDiferencial",
      "editarCarga",
      "editarPasajeros",
      "editarCombustible",
      "editarTraccion",
      "editarCarroceria",
      "editarPuertas",
      "editarAsientos",
      "editarCaja",
      "editarFreno",
      "editarSuspencion",
      "editarEjes",
      "editarUso",
    ];

    for (let id of campos) {
      const el = document.getElementById(id);
      if (el) {
        form.append(id, el.value);
      }
    }

    // 🔹 Imagen solo si existe
    const img = document.getElementById("imagen_unidad");
    if (img && img.files.length > 0) {
      form.append("imagen_unidad", img.files[0]);
    }

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/unidades/actualizar_unidades_demo.php",
      data: form,
      processData: false,
      contentType: false,
      success: function (res) {
        spinner.style.display = "none";

        if (res.includes("OK")) {
          Swal.fire({
            title: "Unidad actualizada correctamente",
            text: "La unidad ha sido actualizada correctamente",
            icon: "success",
            confirmButtonText: "Aceptar",
          });

          modal.hide();
          setTimeout(() => location.reload(), 1000);
        } else {
          Toastify({
            text: res,
            duration: 4000,
            gravity: "top",
            position: "right",
            style: { background: "red" },
          }).showToast();
        }
      },
    });
  }
});
