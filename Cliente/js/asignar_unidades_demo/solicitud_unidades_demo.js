document.addEventListener("DOMContentLoaded", function () {
  const btnsolicitudunidademo = document.getElementById(
    "btnsolicitudunidademo",
  );

  if (!btnsolicitudunidademo) {
    return;
  }

  btnsolicitudunidademo.addEventListener("click", function () {
    const fechasolicitudunidademo = document.getElementById(
      "fechasolicitudunidademo",
    ).value;
    const fechadevolucionunidademo = document.getElementById(
      "fechadevolucionunidademo",
    ).value;

    if (!fechasolicitudunidademo || !fechadevolucionunidademo) {
      Toastify({
        text: "Completa las fechas para continuar",
        duration: 3000,
        gravity: "top",
        position: "right",
        style: {
          background: "linear-gradient(to right, #ff0000, #ff0000)",
        },
      }).showToast();

      return;
    }

    consultar();
  });

  document
    .getElementById("busqueda_global")
    .addEventListener("keyup", function () {
      const fecha1 = document.getElementById("fechasolicitudunidademo").value;
      const fecha2 = document.getElementById("fechadevolucionunidademo").value;

      if (fecha1 && fecha2) {
        consultar();
      }
    });

  function consultar() {
    contenedorspinner.style.display = "flex";

    const caja = new FormData();

    caja.append(
      "fechasolicitudunidademo",
      document.getElementById("fechasolicitudunidademo").value,
    );

    caja.append(
      "fechadevolucionunidademo",
      document.getElementById("fechadevolucionunidademo").value,
    );

    const filtros = ["nombre_modelo", "busqueda_global"];

    filtros.forEach((id) => {
      const elemento = document.getElementById(id);

      caja.append(id, elemento ? elemento.value : "");
    });

    $.ajax({
      type: "POST",
      data: caja,
      url: "../../Servidor/solicitudes/solicitud_unidades_demo/consultar_unidades_demo_disponibles.php",
      contentType: false,
      processData: false,

      success: function (response) {
        contenedorspinner.style.display = "none";

        document.getElementById("contenedorunidadesdisponiblesdemo").innerHTML =
          response;
      },

      error: function () {
        contenedorspinner.style.display = "none";

        Toastify({
          text: "Ocurrió un error al consultar unidades",
          duration: 3000,
          gravity: "top",
          position: "right",
          style: {
            background: "linear-gradient(to right, #ff0000, #ff0000)",
          },
        }).showToast();
      },
    });
  }

  // ============================================
  // MOSTRAR MODAL ASIGNAR PERSONA
  // ============================================

  document.body.addEventListener("click", function (event) {
    const boton = event.target.closest(".btnmostrarunidademofisicamoral");

    if (!boton) return;

    const id_unidad = boton.getAttribute("data-id");

    const id_usuario_demo = boton.getAttribute("data-id-usuario-demo");

    const data_fecha_solicitudemo = boton.getAttribute(
      "data-fecha-solicitudemo",
    );

    const data_fecha_devoluciondemo = boton.getAttribute(
      "data-fecha-devoluciondemo",
    );

    $.ajax({
      type: "POST",

      url: "../../Servidor/solicitudes/solicitud_unidades_demo/seleccionar_persona_fisica_moral.php",

      data: {
        id_unidad: id_unidad,
        id_usuario_demo: id_usuario_demo,
        data_fecha_solicitudemo: data_fecha_solicitudemo,
        data_fecha_devoluciondemo: data_fecha_devoluciondemo,
      },

      success: function (response) {
        document.getElementById("modalinfoformacionunidademobody").innerHTML =
          response;

        const modal = new bootstrap.Modal(
          document.getElementById("modalinfoformacionunidademo"),
        );

        modal.show();
      },
    });
  });
});
