//abrimos la modal para que juridico pueda subir el comodato
document.addEventListener("DOMContentLoaded", function () {
  const modalunidadcomodato = new bootstrap.Modal(document.getElementById("modalunidadcomodato"));
  const modalunidadcomodatobody = document.getElementById("modalunidadcomodatobody");
  const contenedorspinner = document.getElementById("contenedorspinner");

  let asignacion = 0;
  let colaborador = 0;
  let usuarioexterno = 0;

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnmosrarmodalunidadcomodato")) {
      asignacion = event.target.getAttribute("data-id");
      colaborador = event.target.getAttribute("data-idcolaborador");
      usuarioexterno = event.target.getAttribute("data-idusuario");
      console.log('holaaaaa'+asignacion);
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/comodato/formulariosubircomodato.php",
        data: { idasignacion: asignacion,
                idcolaborador: colaborador,
                idusuarioexterno: usuarioexterno
         },
        success: function (response) {
          modalunidadcomodatobody.innerHTML = response;
          modalunidadcomodato.show();
        },
      });
    }
  });

  //Obtenemos la informacion del comodato que subio el area de juridico
  const btnenviarcomodato = document.getElementById("btnenviarcomodato");

  let archivo_subir_comodato;

  let valor_archivo_subir_comodato;

  btnenviarcomodato.addEventListener("click", function () {
    archivo_subir_comodato = document.getElementById("archivo_subir_comodato");
    console.log(archivo_subir_comodato.value);

    contenedorspinner.style.display = "flex";
    obtenervalores();
    if (validarllenado()) {
      insertardatos();
    } else {
      contenedorspinner.style.display = "none";
    }

    function obtenervalores() {
      valor_archivo_subir_comodato = archivo_subir_comodato.files[0];
    }
    function validarllenado() {
      const campos = [
        {
          campo: valor_archivo_subir_comodato,
          nombre: "Archivo del comodato",
        },
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
                "linear-gradient(to right,rgb(255, 230, 0),rgb(231, 208, 0))",
            },
          }).showToast();
          return false;
        }
      }
      return true;
    }

    function insertardatos() {
      const formData = new FormData(); //mandamos el archivo a la carpeta del servidor
      formData.append("id_asignaciones", asignacion);
      formData.append("id_colaborador", colaborador);
      formData.append("id_usuarioexterno", usuarioexterno);
      formData.append("archivo_subir_comodato", valor_archivo_subir_comodato);
      console.log(valor_archivo_subir_comodato);
      console.log(asignacion + "asignacion");
      console.log(colaborador + "colaborador");
      console.log(usuarioexterno + "usuarioexterno");

      if (colaborador) {
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/comodato/enviarcomodato.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response);
          if (response.includes("correctamente")) {
            contenedorspinner.style.display = "none";
            window.location.href = "./comodatos.php?resultado=Comodatoenviado";
          } else {
            if (response == "error") {
            }
          }
        },
      });
    }else if (usuarioexterno) {
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/comodato/enviarcomodatoexterno.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response);
          if (response.includes("correctamente")) {
            contenedorspinner.style.display = "none";
            window.location.href = "./comodatos.php?resultado=Comodatoenviado";
          } else {
            if (response == "error") {
            }
          }
        },
      });

    }
    }
  });
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