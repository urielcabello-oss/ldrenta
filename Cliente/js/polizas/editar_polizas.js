document.addEventListener("DOMContentLoaded", function () {
  //obtenemos la modal
  const modaleditarpolizasUnidades = new bootstrap.Modal(document.getElementById("modaleditarpolizasUnidades"));
  const modalEditarPolizasUnidadesBody = document.getElementById("modalEditarPolizasUnidadesBody");

  let id_poliza;
  let nombreaseguradoraeditar;
  let identificadopolizaseguroeditar;
  let fechaaltaseguroeditar;
  let fechavencimientoaseguradoraeditar;
  let estadoaseguradoraeditar;
  let estatusaseguradoraeditar;
  let editar_documento_poliza;

  const contenedorspinner = document.getElementById("contenedorspinner");

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btneditarpolizas")) {
      id_poliza = event.target.getAttribute("data-id");
      console.log(id_poliza);

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/polizas/formularioEditarPolizas.php",
        data: { idpoliza: id_poliza },
        success: function (response) {
          modalEditarPolizasUnidadesBody.innerHTML = response;
          modaleditarpolizasUnidades.show();
        },
      });
    }
  });

  const btnguardarpolizaeditada = document.getElementById("btnguardarpolizaeditada");
  btnguardarpolizaeditada.addEventListener("click", function () {
    
    btnguardarpolizaeditada.disabled = true;//desactivamos el boton para que no de dos clicks

    nombreaseguradoraeditar = document.getElementById("nombreaseguradoraeditar");
    identificadopolizaseguroeditar = document.getElementById("identificadopolizaseguroeditar");
    fechaaltaseguroeditar = document.getElementById("fechaaltaseguroeditar");
    fechavencimientoaseguradoraeditar = document.getElementById("fechavencimientoaseguradoraeditar");
    estadoaseguradoraeditar = document.getElementById("estadoaseguradoraeditar");
    estatusaseguradoraeditar = document.getElementById("estatusaseguradoraeditar");
    editar_documento_poliza = document.getElementById("editar_documento_poliza");

    contenedorspinner.style.display = "flex";

    if (validarllenado()) {
      insertardatos();
    }else{
      btnguardarpolizaeditada.disabled = false;//activamos el boton
      contenedorspinner.style.display = "none";//cerramos el spinner
    }
  });

  function obtenervalores() {
    return {
      valornombreaseguradoraeditar: nombreaseguradoraeditar.value,
      valoridentificadopolizaseguroeditar: identificadopolizaseguroeditar.value,
      valorfechaaltaseguroeditar: fechaaltaseguroeditar.value,
      valorfecvencimientoaseguradoraeditar: fechavencimientoaseguradoraeditar.value,
      valorestadoaseguradoraeditar: estadoaseguradoraeditar.value,
      valorestatusaseguradoraeditar: estatusaseguradoraeditar.value,
      valoreditar_documento_poliza: editar_documento_poliza.files[0],
    };
  }

  function validarllenado() {
    const { valornombreaseguradoraeditar, 
      valoridentificadopolizaseguroeditar, 
      valorfechaaltaseguroeditar, 
      valorfecvencimientoaseguradoraeditar, 
      valorestadoaseguradoraeditar, 
      valorestatusaseguradoraeditar } = obtenervalores();
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
            background: "linear-gradient(to right,rgb(0, 183, 255),rgb(0, 183, 255))",
          },
        }).showToast();
        contenedorspinner.style.display = "none";
        return false;
      }
    }
    return true;
  }

  function insertardatos() {
    const { valornombreaseguradoraeditar, 
          valoridentificadopolizaseguroeditar, 
          valorfechaaltaseguroeditar, 
          valorfecvencimientoaseguradoraeditar, 
          valorestadoaseguradoraeditar, 
          valorestatusaseguradoraeditar, 
          valoreditar_documento_poliza } = obtenervalores();

    const formData = new FormData();
    formData.append("id_poliza", id_poliza);
    formData.append("nombreaseguradoraeditar", valornombreaseguradoraeditar);
    formData.append("identificadopolizaseguroeditar", valoridentificadopolizaseguroeditar);
    formData.append("fechaaltaseguroeditar", valorfechaaltaseguroeditar);
    formData.append("fechavencimientoaseguradoraeditar", valorfecvencimientoaseguradoraeditar);
    formData.append("estadoaseguradoraeditar", valorestadoaseguradoraeditar);
    formData.append("estatusaseguradoraeditar", valorestatusaseguradoraeditar);
    formData.append("editar_documento_poliza", valoreditar_documento_poliza);

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/polizas/insertar_polizas_editadas.php",
      data: formData,
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
              background: "linear-gradient(to right,rgb(255, 230, 0),rgb(231, 208, 0))",
            },
          }).showToast();

          contenedorspinner.style.display = "none";
          window.location.href = "./unidades.php?resultado=Polizactualizada";
          modaleditarpolizasUnidades.hide();
        } else if (response.includes("Duplicate")) {
          Toastify({
            text: "Poliza ya registrada",
            duration: 3000,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
              background: "linear-gradient(to right,rgb(255, 0, 0),rgb(255, 0, 0))",
            },
          }).showToast();
          contenedorspinner.style.display = "none";
        } else if (response.includes("Error")) {
          Toastify({
            text: "Error al editar la poliza",
            duration: 3000,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
              background: "linear-gradient(to right,rgb(255, 0, 0),rgb(255, 0, 0))",
            },
          }).showToast();
          contenedorspinner.style.display = "none";
        }
      },
    });
  }
});
