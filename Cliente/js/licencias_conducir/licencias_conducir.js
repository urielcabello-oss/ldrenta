document.addEventListener("DOMContentLoaded", function () {
  //abrimos la modal del formulario de alta de licencias
  const modalagregarlicencia = new bootstrap.Modal(
    document.getElementById("modalagregarlicencia")
  );
  const modalagregarlicenciabody = document.getElementById(
    "modalagregarlicenciabody"
  );

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnabrirmodalagregarlicencia")) {
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/licencias_conducir/formularioagregarlicencia.php",
        success: function (response) {
          modalagregarlicencia.show();
          modalagregarlicenciabody.innerHTML = response;
        },
      });
    }
  });


  //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");

  let valorcolaboradorlicenciaconducir;
  let valornumerolicenciaconducir;
  let valorestadolicenciaconducir;
  let valorfechaemision;
  let valorfechavencimiento;
  let valorlicenciaPermanente;
  let valorarchivolicenciaconducir;

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnagregarlicencia")) {
        console.log("click en el boton");

        //mandamos a llamar los datos del formulario de alta de licencias
  const btnagregarlicencia = document.getElementById("btnagregarlicencia");

  const colaboradorlicenciaconducir = document.getElementById("colaboradorlicenciaconducir");
  const numerolicenciaconducir = document.getElementById("numerolicenciaconducir");
  const estadolicenciaconducir = document.getElementById("estadolicenciaconducir");
  const fechaemision = document.getElementById("fechaemision");
  const fechavencimiento = document.getElementById("fechavencimiento");
  const licenciaPermanente = document.getElementById("licenciaPermanente");
  const archivolicenciaconducir = document.getElementById("archivolicenciaconducir");

      obtenervalores();
      validarllenado();
      insertardatos();
    }
  });


  function obtenervalores() {
    const datalist = document.getElementById("datalistcolaborador");
const inputValue = colaboradorlicenciaconducir.value;
valorcolaboradorlicenciaconducir = "";

for (let option of datalist.options) {
  if (option.value === inputValue) {
    valorcolaboradorlicenciaconducir = option.getAttribute("data-id");
    break;
  }
}

    valornumerolicenciaconducir = numerolicenciaconducir.value;
    valorestadolicenciaconducir = estadolicenciaconducir.value;
    valorfechaemision = fechaemision.value;
    valorfechavencimiento = fechavencimiento.value;
    valorlicenciaPermanente = licenciaPermanente.value;
    valorarchivolicenciaconducir = archivolicenciaconducir.files[0];

    console.log(valorcolaboradorlicenciaconducir);
    console.log(valornumerolicenciaconducir);
    console.log(valorestadolicenciaconducir);
    console.log(valorfechaemision);
    console.log(valorfechavencimiento);
    console.log(licenciaPermanente);
    console.log(valorarchivolicenciaconducir);
  }

  function validarllenado() {
    const campos = [
      {
        campo: valorcolaboradorlicenciaconducir,
        nombre: "colaboradorlicenciaconducir",
      },
      {
        campo: valornumerolicenciaconducir,
        nombre: "numerolicenciaconducir",
      },
      {
        campo: valorestadolicenciaconducir,
        nombre: "estadolicenciaconducir",
      },
      {
        campo: valorfechaemision,
        nombre: "fechaemision",
      },
      {
        campo: valorarchivolicenciaconducir,
        nombre: "archivolicenciaconducir",
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
              "linear-gradient(to right,rgb(0, 183, 255),rgb(0, 183, 255))",
          },
        }).showToast();
        return false;
      }
    }
    return true;
  }

  function insertardatos() {
    if (validarllenado()) {
      console.log("entro a insertardatos");

      const formdata = new FormData();
      formdata.append("colaboradorlicenciaconducir",valorcolaboradorlicenciaconducir);
      formdata.append("numerolicenciaconducir", valornumerolicenciaconducir);
      formdata.append("estadolicenciaconducir", valorestadolicenciaconducir);
      formdata.append("fechaemision", valorfechaemision);
      formdata.append("fechavencimiento", valorfechavencimiento);
      formdata.append("licenciaPermanente", licenciaPermanente.checked ? "PERMANENTE" : "");
      formdata.append("archivolicenciaconducir", valorarchivolicenciaconducir);

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/licencias_conducir/insertar_licencias_conducir.php",
        data: formdata,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log("entro a success");
          console.log(response);
          if (response.includes("correctamente")) {
            contenedorspinner.style.display = "none";
            window.location.href ="./licencias_conducir.php?resultado=licenciasinsertada"; //resultado nombre del parametro -> resultado del contenido
          }
        },
      });
    }
  }
});
