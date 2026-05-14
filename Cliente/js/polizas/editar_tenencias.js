document.addEventListener("DOMContentLoaded", function () {
  //obtenemos la modal
  const modalEditarTenencias = new bootstrap.Modal(document.getElementById("modalEditarTenencias"));
  const modalEditarTenenciasBody = document.getElementById("modalEditarTenenciasBody");

  let id_tenencia;
  let foliotenenciaeditar;
  let añotenenciaeditar;
  let estatustenenciaeditar;
  let montopagoeditar;
  let fechapagoeditar;
  let fechavencimientoeditar;
  let documento_poliza_tenencia_editar;

  const contenedorspinner = document.getElementById("contenedorspinner");

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btneditartenencias")) {
      id_tenencia = event.target.getAttribute("data-id");
      console.log(id_tenencia);
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/polizas/formularioEditarTenencias.php",
        data: { idtenencia: id_tenencia },
        success: function (response) {
          modalEditarTenenciasBody.innerHTML = response;
          modalEditarTenencias.show();
        },
      });
    }
  });

  const btnguardartenenciaedotada = document.getElementById("btnguardartenenciaedotada");
  btnguardartenenciaedotada.addEventListener("click", function () {
    btnguardartenenciaedotada.disabled = true;//desactivamos el boton para que no de dos clicks

    foliotenenciaeditar = document.getElementById("foliotenenciaeditar");
    añotenenciaeditar = document.getElementById("añotenenciaeditar");
    estatustenenciaeditar = document.getElementById("estatustenenciaeditar");
    montopagoeditar = document.getElementById("montopagoeditar");
    fechapagoeditar = document.getElementById("fechapagoeditar");
    fechavencimientoeditar = document.getElementById("fechavencimientoeditar");
    documento_poliza_tenencia_editar = document.getElementById("documento_poliza_tenencia_editar");

    contenedorspinner.style.display = "flex";

    if (validarllenado()) {
      insertardatos();
    }else{
      btnguardartenenciaedotada.disabled = false;//activamos el boton
      contenedorspinner.style.display = "none";//cerramos el spinner
    }
  });

  function obtenervalores() {
    return {
      valorfoliotenenciaeditar: foliotenenciaeditar.value,
      valorañotenenciaeditar: añotenenciaeditar.value,
      valorestatustenenciaeditar: estatustenenciaeditar.value,
      valormontopagoeditar: montopagoeditar.value,
      valorfechapagoeditar: fechapagoeditar.value,
      valorfechavencimientoeditar: fechavencimientoeditar.value,
      valordocumento_poliza_tenencia_editar: documento_poliza_tenencia_editar.files[0],
    };
  }
  function validarllenado() {
    const { valorfoliotenenciaeditar, 
        valorañotenenciaeditar, 
        valorestatustenenciaeditar,  } = obtenervalores();
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
    const { valorfoliotenenciaeditar, 
        valorañotenenciaeditar, 
        valorestatustenenciaeditar, 
        valormontopagoeditar, 
        valorfechapagoeditar, 
        valorfechavencimientoeditar, 
        valordocumento_poliza_tenencia_editar} = obtenervalores();

        const formData = new FormData();
        formData.append("id_tenencia", id_tenencia);
        formData.append("foliotenenciaeditar", valorfoliotenenciaeditar);
        formData.append("añotenenciaeditar", valorañotenenciaeditar);
        formData.append("estatustenenciaeditar", valorestatustenenciaeditar);
        formData.append("montopagoeditar", valormontopagoeditar);
        formData.append("fechapagoeditar", valorfechapagoeditar);
        formData.append("fechavencimientoeditar", valorfechavencimientoeditar);
        formData.append("documento_poliza_tenencia_editar", valordocumento_poliza_tenencia_editar);

        $.ajax({
          type: "POST",
          url: "../../Servidor/solicitudes/polizas/insertar_tenencias_editadas.php",
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
              window.location.href = "./unidades.php?resultado=Teneciactualizada";
              modalEditarTenencias.hide();
            } else if (response.includes("Duplicate")) {
          Toastify({
            text: "Tenencia ya registrada",
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
            text: "Error al editar la tenencia",
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
