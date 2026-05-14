document.addEventListener("DOMContentLoaded", function () {
  const modalinfounidadcomodato = new bootstrap.Modal(document.getElementById("modalinfounidadcomodato"));
  const modalinfounidadcomodatobody = document.getElementById("modalinfounidadcomodatobody");
  const contenedorspinner = document.getElementById("contenedorspinner");
  const modaldescripcionnegacioncomodatofirmado = new bootstrap.Modal(document.getElementById("modaldescripcionnegacioncomodatofirmado"));
  const modaldescripcionnegacioncomodatofirmadobody = document.getElementById("modaldescripcionnegacioncomodatofirmadobody");

  let asignacion = 0;
  let colaborador = 0;
  let usuarioexterno = 0;

  // Mostrar modal de información de unidad
  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnmosrarmodalunidadCOMODATO")) {
      asignacion = event.target.getAttribute("data-id");
      colaborador = event.target.getAttribute("data-idcolaborador");
      usuarioexterno = event.target.getAttribute("data-idusuario");
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/comodato/formulariovercomodatofirmado.php",
        data: { idasignacion: asignacion,
                idcolaborador: colaborador,
                idusuarioexterno: usuarioexterno
         },
        success: function (response) {
          modalinfounidadcomodatobody.innerHTML = response;
          modalinfounidadcomodato.show();
        },
      });
    }
  });

  // Aprobar comodato
  document.body.addEventListener("click", function (event) {
    if (event.target && event.target.id === "btnaprovarcomodatofirmado") {
      const btn = event.target;
      btn.disabled = true;

      const comodato_archivo_sin_firmar = document.getElementById("comodato_archivo_sin_firmar");

      if (!comodato_archivo_sin_firmar || !comodato_archivo_sin_firmar.files.length) {
        Toastify({
          text: "No se seleccionó ningún archivo para el comodato.",
          duration: 3000,
          gravity: "top",
          position: "right",
          stopOnFocus: true,
          style: { background: "linear-gradient(to right, rgb(255, 230, 0), rgb(231, 208, 0))" },
        }).showToast();
        btn.disabled = false;
        return;
      }

      const formData = new FormData();
      formData.append("id_asignaciones", asignacion);
      formData.append("comodato_archivo_sin_firmar", comodato_archivo_sin_firmar.files[0]);

      contenedorspinner.style.display = "flex";

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_ver_comodato/aprobarcomodatofirmado.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response);
          contenedorspinner.style.display = "none";
          if (response.includes("correctamente")) {
            window.location.href = "./validacion_unidades_comodato.php?resultado=Comodatoenviado";
          } else {
            Toastify({
              text: "Hubo un error al aprobar el comodato.",
              duration: 3000,
              gravity: "top",
              position: "right",
              style: { background: "linear-gradient(to right, #ff5f6d, #ffc371)" },
            }).showToast();
          }
          btn.disabled = false;
        },
      });
    }
  });

  // Mostrar modal de negación
  document.body.addEventListener("click", function (event) {
    if (event.target && event.target.id === "btndenegarcomodatofirmado") {
      const btn = event.target;
      btn.disabled = true;
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_ver_comodato/descripciondenegacioncomodatofirmado.php",
        data: { idasignacion: asignacion,
                idcolaborador: colaborador,
                idusuarioexterno: usuarioexterno
         },
        success: function (response) {
          modaldescripcionnegacioncomodatofirmadobody.innerHTML = response;
          modaldescripcionnegacioncomodatofirmado.show();
          btn.disabled = false;
        },
      });
    }
  });

  // Denegar comodato (delegación porque se carga dinámicamente)
  document.body.addEventListener("click", function (event) {
    if (event.target && event.target.id === "btndenegarcartaresponsivafirmadadenegar") {
      const descripcion = document.getElementById("descripciondenegacioncomodato").value;


      if (descripcion.trim() === "") {
        Toastify({
          text: "El campo de descripción no debe estar vacío.",
          duration: 3000,
          gravity: "top",
          position: "right",
          style: { background: "linear-gradient(to right, #00b09b, #96c93d)" },
        }).showToast();
        return;
      }

      const formData = new FormData();
      formData.append("idasignacion", asignacion);
      formData.append("idcolaborador", colaborador);
      formData.append("idusuarioexterno", usuarioexterno);
      formData.append("descripciondenegacioncomodato", descripcion);
      console.log(descripcion);
      console.log(asignacion);
      console.log(colaborador);
      console.log(usuarioexterno);

      contenedorspinner.style.display = "flex";
      if(colaborador){
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_ver_comodato/denegarcomodatofirmado.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log("Éxito:", response);
          contenedorspinner.style.display = "none";
          window.location.href = "./validacion_unidades_comodato.php?resultado=Comodatodenegado";
        },
      });
    }else if (usuarioexterno) {
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_ver_comodato/denegarcomodatofirmadoexterno.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log("Éxito:", response);
          contenedorspinner.style.display = "none";
          window.location.href = "./validacion_unidades_comodato.php?resultado=Comodatodenegado";
        },
      });
    }
    }
  });

  // Notificar usuario (una vez)
  const btnnotificarusuario = document.getElementById("btnnotificarusuario");
  if (btnnotificarusuario) {
    btnnotificarusuario.addEventListener("click", function () {
      btnnotificarusuario.disabled = true;
      contenedorspinner.style.display = "flex";

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_ver_comodato/notificarusuario.php",
        data: { idasignacion: asignacion },
        success: function (response) {
          console.log("Éxito:", response);
          contenedorspinner.style.display = "none";
          window.location.href = "./validacion_unidades_comodato.php?resultado=Notificaciónenviada";
        },
      });
    });
  }
});

//aqui usams este codigo para realizar el cambio de interfaz cards a tabla 
function toggleVista() {
    const button = document.getElementById("botonCambiarVista");
    const cards = document.getElementById("vistaCards");
    const tabla = document.getElementById("vistaTabla");
    const boton = event.target;

    if (cards.style.display === "none") {
        cards.style.display = "flex";
        tabla.style.display = "none";
        boton.textContent = "Cambiar a vista de tabla";
    } else {
        cards.style.display = "none";
        tabla.style.display = "block";
        boton.textContent = "Cambiar a vista de cards";
    }
}