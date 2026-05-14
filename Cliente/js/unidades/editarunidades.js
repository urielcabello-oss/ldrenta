document.addEventListener("DOMContentLoaded", function () {
    //----------------------------------------------------------esto hace que todas las entradas de texto sean mayusculas
  document.addEventListener("input", function (e) {
  const target = e.target;
  if (target.tagName === "INPUT" && target.type === "text") {
    target.value = target.value.toUpperCase();
  }
});



  const modalEditarUnidades = new bootstrap.Modal(document.getElementById("modalEditarUnidades"));
  const modalEditarUnidadesBody = document.getElementById("modalEditarUnidadesBody");

  let id_unidad_seleccionado = 0;

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btneditarunidades")) {
      id_unidad_seleccionado = event.target.getAttribute("data-id");
      console.log(id_unidad_seleccionado);
      
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/formularioeditarunidades.php",
        data: { idunidad: id_unidad_seleccionado },
        success: function (response) {
          console.log(response);
          modalEditarUnidadesBody.innerHTML = response;
          modalEditarUnidades.show();
        }
      });
    }
  });
  
//realizamos la actualizacion
  const btnactualizarunidad = document.getElementById("btnactualizarunidad");

  let marcaeditarunidad, modeloeditarunidad, editarVIN, editarPlaca, editarNumeroMotor, editarColor, editarTarjetaCirculacion;
  let editarañounidad, editarEstadoUnidad, editarEstatusUnidad, editarTipoUnidad, editsedeunidad, editarfechaadquisicionunidad;
  let editartipoadquisicionunidad, editartipoarrendadoraunidad, editarfoliofacturaunidad, imagen_unidad;


  const contenedorspinner = document.getElementById("contenedorspinner");

  let valormarcaeditarunidad, valormodeloeditarunidad, valorVINeditar, valorPlacaeditar, valorNumeroMotoreditar;
  let valoreditarColor, valorTarjetaCirculacioneditar, valoreditarañounidad, valorEstadoUnidadeditar, valorEstatusUnidadeditar;
  let valorTipoUnidadeditar, valorsedeunidadeditar, valorfechaadquisicionunidadeditar, valortipoadquisicionunidadeditar;
  let valoreditartipoarrendadoraunidad, valoreditarfoliofacturaunidad, valorimagen_unidad;


  btnactualizarunidad.addEventListener("click", function () {
    marcaeditarunidad = document.getElementById("marcaeditarunidad");
    modeloeditarunidad = document.getElementById("modeloeditarunidad");
    editarVIN = document.getElementById("editarVIN");
    editarPlaca = document.getElementById("editarPlaca");
    editarNumeroMotor = document.getElementById("editarNumeroMotor");
    editarColor = document.getElementById("editarColor");
    editarTarjetaCirculacion = document.getElementById("editarTarjetaCirculacion");
    editarañounidad = document.getElementById("editarañounidad");
    editarEstadoUnidad = document.getElementById("editarEstadoUnidad");
    editarEstatusUnidad = document.getElementById("editarEstatusUnidad");
    editarTipoUnidad = document.getElementById("editarTipoUnidad");
    editsedeunidad = document.getElementById("editsedeunidad");
    editarfechaadquisicionunidad = document.getElementById("editarfechaadquisicionunidad");
    editartipoadquisicionunidad = document.getElementById("editartipoadquisicionunidad");
    editartipoarrendadoraunidad = document.getElementById("editartipoarrendadoraunidad");
    editarfoliofacturaunidad = document.getElementById("editarfoliofacturaunidad");
    imagen_unidad = document.getElementById("imagen_unidad");
    editarCarga = document.getElementById("editarCarga");
    editarPasajeros = document.getElementById("editarPasajeros");
    editarCombustible = document.getElementById("editarCombustible");
    editarTraccion = document.getElementById("editarTraccion");
    editarCarroceria = document.getElementById("editarCarroceria");
    editarPuertas = document.getElementById("editarPuertas");
    editarAsientos = document.getElementById("editarAsientos");
    editarCaja = document.getElementById("editarCaja");
    editarFreno = document.getElementById("editarFreno");
    editarSuspencion = document.getElementById("editarSuspencion");
    editarEjes = document.getElementById("editarEjes");
    editarUso = document.getElementById("editarUso");
    editar_camara_reversa = document.getElementById("editar_camara_reversa");
    editar_sensores_reversa = document.getElementById("editar_sensores_reversa");

    contenedorspinner.style.display = "flex";
    obtenervalores();
    if (validarllenado()) {
      insertardatos();
    } else {
      contenedorspinner.style.display = "none";
    }
  });

  function obtenervalores() {
    valormarcaeditarunidad = marcaeditarunidad.value;
    valormodeloeditarunidad = modeloeditarunidad.value;
    valorVINeditar = editarVIN.value;
    valorPlacaeditar = editarPlaca.value;
    valorNumeroMotoreditar = editarNumeroMotor.value;
    valoreditarColor = editarColor.value;
    valorTarjetaCirculacioneditar = editarTarjetaCirculacion.value;
    valoreditarañounidad = editarañounidad.value;
    valorEstadoUnidadeditar = editarEstadoUnidad.value;
    valorEstatusUnidadeditar = editarEstatusUnidad.value;
    valorTipoUnidadeditar = editarTipoUnidad.value;
    valorsedeunidadeditar = editsedeunidad.value;
    valorfechaadquisicionunidadeditar = editarfechaadquisicionunidad.value;
    valortipoadquisicionunidadeditar = editartipoadquisicionunidad.value;
    valoreditartipoarrendadoraunidad = editartipoarrendadoraunidad.value;
    valoreditarfoliofacturaunidad = editarfoliofacturaunidad.value;
    valorimagen_unidad = imagen_unidad.files[0];
  }

  function validarllenado() {
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
            background: "linear-gradient(to right,rgb(255, 230, 0),rgb(231, 208, 0))",
          },
        }).showToast();
        return false;
      }
    }
    return true;
  }

  function insertardatos() {
    const formData = new FormData();
    formData.append("id_unidad", id_unidad_seleccionado);
    formData.append("marcaeditarunidad", valormarcaeditarunidad);
    formData.append("modeloeditarunidad", valormodeloeditarunidad);
    formData.append("editarVIN", valorVINeditar);
    formData.append("editarPlaca", valorPlacaeditar);
    formData.append("editarNumeroMotor", valorNumeroMotoreditar);
    formData.append("editarColor", valoreditarColor);
    formData.append("editarTarjetaCirculacion", valorTarjetaCirculacioneditar);
    formData.append("editarañounidad", valoreditarañounidad);
    formData.append("editarEstadoUnidad", valorEstadoUnidadeditar);
    formData.append("editarEstatusUnidad", valorEstatusUnidadeditar);
    formData.append("editarTipoUnidad", valorTipoUnidadeditar);
    formData.append("editsedeunidad", valorsedeunidadeditar);
    formData.append("editarfechaadquisicionunidad", valorfechaadquisicionunidadeditar);
    formData.append("editartipoadquisicionunidad", valortipoadquisicionunidadeditar);
    formData.append("editartipoarrendadoraunidad", valoreditartipoarrendadoraunidad);
    formData.append("editarfoliofacturaunidad", valoreditarfoliofacturaunidad);
    formData.append("imagen_unidad", valorimagen_unidad);

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/unidades/actualizar_unidades.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        console.log("entro a success");
        console.log(response);
        contenedorspinner.style.display = "none";

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

          window.location.href = "./unidades.php?resultado=Unidadactualizada";
          modalEditarUnidades.hide();
        } else if (response.includes("Duplicate")) {
          Toastify({
            text: "Unidad ya registrada",
            duration: 3000,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
              background: "linear-gradient(to right,rgb(255, 230, 0),rgb(231, 208, 0))",
            },
          }).showToast();
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
        }
      },
    });
  }
});
