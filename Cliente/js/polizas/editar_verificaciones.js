document.addEventListener("DOMContentLoaded", function () {
  //obtenemos la modal
  modalEditarVerificaciones = new bootstrap.Modal(
    document.getElementById("modalEditarVerificaciones")
  );
  modalEditarVerificacionesBody = document.getElementById(
    "modalEditarVerificacionesBody"
  );

  let id_verificacion;
  let folioverificacioneditar;
  let montoverificacioneditar;
  let añoverificacioneditar;
  let verificacionsemestreeditar;
  let fechaverificacioneditar;
  let fechaproximaverificacioneditar;
  let estatusverificacioneditar;

  const contenedorspinner = document.getElementById("contenedorspinner");

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btneditarverificaciones")) {
      id_verificacion = event.target.getAttribute("data-id");
      console.log(id_verificacion);
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/polizas/formularioEditarVerificaciones.php",
        data: { idverificacion: id_verificacion },
        success: function (response) {
          modalEditarVerificacionesBody.innerHTML = response;
          modalEditarVerificaciones.show();
        },
      });
    }
  });

  const btnguardarverificacioneditada = document.getElementById(
    "btnguardarverificacioneditada"
  );
  btnguardarverificacioneditada.addEventListener("click", function () {
    btnguardarverificacioneditada.disabled = true; //desactivamos el boton para que no de dos clicks

    folioverificacioneditar = document.getElementById(
      "folioverificacioneditar"
    );
    montoverificacioneditar = document.getElementById(
      "montoverificacioneditar"
    );
    añoverificacioneditar = document.getElementById("añoverificacioneditar");
    verificacionsemestreeditar = document.getElementById(
      "verificacionsemestreeditar"
    );
    fechaverificacioneditar = document.getElementById(
      "fechaverificacioneditar"
    );
    fechaproximaverificacioneditar = document.getElementById(
      "fechaproximaverificacioneditar"
    );
    estatusverificacioneditar = document.getElementById(
      "estatusverificacioneditar"
    );

    contenedorspinner.style.display = "flex";

    if (validarllenado()) {
      insertardatos();
    } else {
      btnguardarverificacioneditada.disabled = false; //activamos el boton
      contenedorspinner.style.display = "none"; //cerramos el spinner
    }
  });

  function obtenervalores() {
    return {
      valorfolioverificacioneditar: folioverificacioneditar.value,
      valormontoverificacioneditar: montoverificacioneditar.value,
      valorañoverificacioneditar: añoverificacioneditar.value,
      valorverificacionsemestreeditar: verificacionsemestreeditar.value,
      valorfechaverificacioneditar: fechaverificacioneditar.value,
      valorfechaproximaverificacioneditar: fechaproximaverificacioneditar.value,
      valorestatusverificacioneditar: estatusverificacioneditar.value,
    };
  }
  function validarllenado() {
    const {
      valorfolioverificacioneditar,
      valormontoverificacioneditar,
      valorañoverificacioneditar,
      valorverificacionsemestreeditar,
      valorfechaverificacioneditar,
      valorfechaproximaverificacioneditar,
      valorestatusverificacioneditar,
    } = obtenervalores();
    const campos = [
    ];

    for (let i = 0; i < campos.length; i++) {
      if (!campos[i].campo) {
        Toastify({
          text: "No obtuve " + campos[i].nombre,
          duration: 3000,
          gravity: "top",
          position: "right",
          stopOnFocus: true,
          style: {
            background:
              "linear-gradient(to right,rgb(0, 183, 255),rgb(0, 183, 255))",
          },
        }).showToast();
        contenedorspinner.style.display = "none";
        return false;
      }
    }
    return true;
  }
  function insertardatos() {
    const {
      valorfolioverificacioneditar,
      valormontoverificacioneditar,
      valorañoverificacioneditar,
      valorverificacionsemestreeditar,
      valorfechaverificacioneditar,
      valorfechaproximaverificacioneditar,
      valorestatusverificacioneditar,
    } = obtenervalores();

    const form = new FormData();
    form.append("id_verificacion", id_verificacion);
    form.append("folioverificacioneditar", valorfolioverificacioneditar);
    form.append("montoverificacioneditar", valormontoverificacioneditar);
    form.append("añoverificacioneditar", valorañoverificacioneditar);
    form.append("verificacionsemestreeditar", valorverificacionsemestreeditar);
    form.append("fechaverificacioneditar", valorfechaverificacioneditar);
    form.append("fechaproximaverificacioneditar",valorfechaproximaverificacioneditar);
    form.append("estatusverificacioneditar", valorestatusverificacioneditar);

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/polizas/insertar_verificaciones_editadas.php",
      data: form,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.includes("correctamente")) {
          Toastify({
            text: "Correctamente",
            duration: 3000,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
              background:
                "linear-gradient(to right,rgb(255, 230, 0),rgb(231, 208, 0))",
            },
          }).showToast();

          contenedorspinner.style.display = "none";
          window.location.href ="./unidades.php?resultado=Verificacionactualizada";
          modalEditarVerificaciones.hide();
        } else if (response.includes("Duplicate")) {
          Toastify({
            text: "Verificacion ya registrada",
            duration: 3000,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
              background:
                "linear-gradient(to right,rgb(255, 0, 0),rgb(255, 0, 0))",
            },
          }).showToast();
          contenedorspinner.style.display = "none";
        } else if (response.includes("Error")) {
          Toastify({
            text: "Error al editar la verificacion",
            duration: 3000,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
              background:
                "linear-gradient(to right,rgb(255, 0, 0),rgb(255, 0, 0))",
            },
          }).showToast();
          contenedorspinner.style.display = "none";
        }
      },
    });
  }
});
