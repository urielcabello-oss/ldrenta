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

      // DEBE SER seleccionar_persona_fisica_moral.php

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
  // ============================================
  // PERSONA FISICA / MORAL
  // ============================================

  document.body.addEventListener("click", function (event) {
    // ======================================
    // PERSONA FISICA
    // ======================================

    if (event.target.closest(".btnasignarpersonafisica")) {
      const boton = event.target.closest(".btnasignarpersonafisica");

      $.ajax({
        type: "POST",

        url: "../../Servidor/solicitudes/solicitud_unidades_demo/obtener_personas_fisicas_asignar_demo.php",

        data: {
          id_unidad: boton.dataset.idunidad,
          id_usuario_demo: boton.dataset.idusuario,
          data_fecha_solicitudemo: boton.dataset.fecha_solicitud,
          data_fecha_devoluciondemo: boton.dataset.fecha_devolucion,
        },

        success: function (response) {
          document.getElementById("tablasignacionunidadesdemos").innerHTML =
            response;
        },
      });
    }

    // ======================================
    // PERSONA MORAL
    // ======================================

    if (event.target.closest(".btnasignarpersonamoral")) {
      const boton = event.target.closest(".btnasignarpersonamoral");

      $.ajax({
        type: "POST",

        url: "../../Servidor/solicitudes/solicitud_unidades_demo/obtener_personas_morales_asignar_demo.php",

        data: {
          id_unidad: boton.dataset.idunidad,
          id_usuario_demo: boton.dataset.idusuario,
          data_fecha_solicitudemo: boton.dataset.fecha_solicitud,
          data_fecha_devoluciondemo: boton.dataset.fecha_devolucion,
        },

        success: function (response) {
          document.getElementById("tablasignacionunidadesdemos").innerHTML =
            response;
        },
      });
    }
  });

  // ============================================
  // ABRIR FORMULARIO FINAL DE SOLICITUD
  // ============================================

  document.body.addEventListener("click", function (event) {
    const boton = event.target.closest(".btnasignarunidademo");

    if (!boton) return;

    const id_unidad = boton.getAttribute("data-id_unidad");

    const data_id_persona_fisica = boton.getAttribute("data-id_persona_fisica");

    const data_id_persona_moral = boton.getAttribute("data-id_persona_moral");

    const data_id_colaborador = boton.getAttribute("data-id_colaborador");

    const data_fecha_solicitudemo = boton.getAttribute(
      "data-fecha_solicitudemo",
    );

    const data_fecha_devoluciondemo = boton.getAttribute(
      "data-fecha_devoluciondemo",
    );

    $.ajax({
      type: "POST",

      url: "../../Servidor/solicitudes/solicitud_unidades_demo/formularioinfounidademo.php",

      data: {
        id_unidad: id_unidad,
        data_id_persona_fisica: data_id_persona_fisica,
        data_id_persona_moral: data_id_persona_moral,
        data_id_colaborador: data_id_colaborador,
        data_fecha_solicitudemo: data_fecha_solicitudemo,
        data_fecha_devoluciondemo: data_fecha_devoluciondemo,
      },

      success: function (response) {
  document.getElementById("modalverunidaddemoasignacionbody").innerHTML =
    response;

  const modalFormulario = new bootstrap.Modal(
    document.getElementById("modalverunidaddemoasignacion"),
  );

  modalFormulario.show();

  // ============================================
  // BOTON FINAL SOLICITAR UNIDAD
  // ============================================

  const btnSolicitar = document.getElementById(
    "btnsolicitaruniaddemo",
  );

  if (!btnSolicitar) {
    console.error("No se encontró #btnsolicitaruniaddemo");
    return;
  }

  // Eliminamos listeners duplicados
  const nuevoBoton = btnSolicitar.cloneNode(true);

  btnSolicitar.parentNode.replaceChild(
    nuevoBoton,
    btnSolicitar,
  );

  nuevoBoton.addEventListener("click", function () {
    // ======================================
    // CAMPOS
    // ======================================

    const id_unidad =
      document.getElementById("id_unidad");

    const id_persona_fisica =
      document.getElementById("id_persona_fisica");

    const id_persona_moral =
      document.getElementById("id_persona_moral");

    const id_colaborador =
      document.getElementById("id_colaborador");

    const fecha_solicitudemo =
  document.getElementById(
    "fecha_solicitudemo",
  );

const fecha_devoluciondemo =
  document.getElementById(
    "fecha_devoluciondemo",
  );

    // ======================================
    // VALIDACIONES
    // ======================================

    if (
      !id_unidad ||
      !id_colaborador ||
      !fecha_solicitudemo ||
      !fecha_devoluciondemo
    ) {
      Toastify({
        text: "Faltan campos requeridos",
        duration: 3000,
        gravity: "top",
        position: "right",
        style: {
          background:
            "linear-gradient(to right,#ff0000,#ff0000)",
        },
      }).showToast();

      return;
    }

    const tienePersonaFisica =
      id_persona_fisica &&
      id_persona_fisica.value !== "";

    const tienePersonaMoral =
      id_persona_moral &&
      id_persona_moral.value !== "";

    if (!tienePersonaFisica && !tienePersonaMoral) {
      Toastify({
        text: "Debes asignar una persona física o moral",
        duration: 3000,
        gravity: "top",
        position: "right",
        style: {
          background:
            "linear-gradient(to right,#ff0000,#ff0000)",
        },
      }).showToast();

      return;
    }

    // ======================================
    // FORMDATA
    // ======================================

    const caja1 = new FormData();

    caja1.append(
      "id_unidad",
      id_unidad.value,
    );

    caja1.append(
      "id_colaborador",
      id_colaborador.value,
    );

    caja1.append(
      "fechasolicitudunidademo",
      fecha_solicitudemo.value,
    );

    caja1.append(
      "fechadevolucionunidademo",
      fecha_devoluciondemo.value,
    );

    if (tienePersonaFisica) {
      caja1.append(
        "id_persona_fisica",
        id_persona_fisica.value,
      );
    }

    if (tienePersonaMoral) {
      caja1.append(
        "id_persona_moral",
        id_persona_moral.value,
      );
    }

    // ======================================
    // CHECKBOXES
    // ======================================

    const emplacamiento_ldr =
      document.getElementById(
        "emplacamiento_ldr",
      );

    const asegurar_ldr =
      document.getElementById(
        "asegurar_ldr",
      );

    caja1.append(
      "emplacamiento_ldr",
      emplacamiento_ldr &&
        emplacamiento_ldr.checked
        ? "1"
        : "0",
    );

    caja1.append(
      "asegurar_ldr",
      asegurar_ldr &&
        asegurar_ldr.checked
        ? "1"
        : "0",
    );

    // ======================================
    // TEXTAREAS
    // ======================================

    const comentarios_pruebas_demo =
      document.getElementById(
        "comentarios_pruebas_demo",
      );

    const objetivo_prueba_demo =
      document.getElementById(
        "objetivo_prueba_demo",
      );

    caja1.append(
      "objetivo_prueba_demo",
      objetivo_prueba_demo
        ? objetivo_prueba_demo.value
        : "",
    );

    caja1.append(
      "comentarios_pruebas_demo",
      comentarios_pruebas_demo
        ? comentarios_pruebas_demo.value
        : "",
    );

    // ======================================
    // INSERTAR SOLICITUD
    // ======================================

    contenedorspinner.style.display = "flex";

    $.ajax({
      type: "POST",

      data: caja1,

      url: "../../Servidor/solicitudes/solicitud_unidades_demo/solicitar_comodato_demo.php",

      contentType: false,

      processData: false,

      success: function (response) {
        contenedorspinner.style.display = "none";

        console.log(response);

      },

      error: function () {
        contenedorspinner.style.display = "none";

        Toastify({
          text: "Error al registrar la solicitud",
          duration: 3000,
          gravity: "top",
          position: "right",
          style: {
            background:
              "linear-gradient(to right,#ff0000,#ff0000)",
          },
        }).showToast();
      },
    });
  });
},

      error: function () {
        Toastify({
          text: "No se pudo abrir el formulario",
          duration: 3000,
          gravity: "top",
          position: "right",
          style: {
            background: "linear-gradient(to right,#ff0000,#ff0000)",
          },
        }).showToast();
      },
    });
  });
});
