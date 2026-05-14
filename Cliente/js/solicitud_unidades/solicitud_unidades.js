//abrimos la modal de la informacion de la unidad que esta por ser adquirida por el usuario en ella muestra la carta responsiva
document.addEventListener("DOMContentLoaded", function () {
  const modalinfounidadpolitica = new bootstrap.Modal(document.getElementById("modalinfounidadpolitica"));
  const modalinfounidadpoliticabody = document.getElementById("modalinfounidadpoliticabody");

  let asignacion = 0;

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("checkpolitica")) {
      asignacion = event.target.getAttribute("data-id");
      console.log(asignacion);

      const btnsolicitudunidad = document.getElementById(
        `btnpoliticaunidades${asignacion}`
      );

      if (event.target.checked) {
        btnsolicitudunidad.removeAttribute("disabled");
      } else {
        btnsolicitudunidad.setAttribute("disabled", "");
      }
    }
  });

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnmosrarmodalunidadsolicitud")) {
      asignacion = event.target.getAttribute("data-id");
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades/formularioinfounidadpolitica.php",
        data: { idasignacion: asignacion },
        success: function (response) {
          modalinfounidadpolitica.show();
          modalinfounidadpoliticabody.innerHTML = response;
        },
      });
    }
  });

  //---------------------------------------------obtenemos la información del pdf que subio el ususario (firmado)--------------------------------

  const btnenviarpolitica = document.getElementById("btnenviarpolitica");

  let archivo_responsiva_sin_asignar;

  const contenedorspinner = document.getElementById("contenedorspinner");

  let valor_archivo_responsiva_sin_asignar;

  btnenviarpolitica.addEventListener("click", function () {
    archivo_responsiva_sin_asignar = document.getElementById(
      "archivo_responsiva_sin_asignar"
    );
    console.log(archivo_responsiva_sin_asignar.value);

    contenedorspinner.style.display = "flex";
    obtenervaloresresponsivasinasignar();
    if (validarllenado()) {
      insertardatos();
    } else {
      contenedorspinner.style.display = "none";
    }
  });
  function obtenervaloresresponsivasinasignar() {
    valor_archivo_responsiva_sin_asignar =
      archivo_responsiva_sin_asignar.files[0];
  }
  function validarllenado() {
    const campos = [
      {
        campo: valor_archivo_responsiva_sin_asignar,
        nombre: "archivo_responsiva_sin_asignar",
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
    const formData = new FormData();
    formData.append("id_asignaciones", asignacion);
    formData.append(
      "archivo_responsiva_sin_asignar",
      valor_archivo_responsiva_sin_asignar
    );
    console.log(valor_archivo_responsiva_sin_asignar);
    console.log(asignacion + "asignacion");

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/solicitud_unidades/enviarpolitica.php",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        if (response.includes("correctamente")) {
          contenedorspinner.style.display = "none";
          window.location.href =
            "./solicitud_unidades.php?resultado=Responsivaenviadayfirmada"; //resultado nombre del parametro -> resultado del contenido
        } else {
          if (response == "error") {
          }
        }
      },
    });
  }

  //abrimos la modal para mostrar la informacion de la unidad y con el COMODATO que juridico subio
  const modalinfounidadcomodato = new bootstrap.Modal(document.getElementById("modalinfounidadcomodato"));
  const modalinfounidadcomodatobody = document.getElementById("modalinfounidadcomodatobody");

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnsubircomodato")) {
      asignacion = event.target.getAttribute("data-id");
      console.log(asignacion);
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades/formularioinfounidadcomodato.php",
        data: { idasignacion: asignacion },
        success: function (response) {
          modalinfounidadcomodato.show();
          modalinfounidadcomodatobody.innerHTML = response;
        },
      });
    }
  });

  //obtenemos el comodato que sube el ususario cliente
  const btnenviarcomodato = document.getElementById("btnenviarcomodato");

  let comodato_archivo_sin_firmar;

  let valor_comodato_archivo_sin_firmar;

  btnenviarcomodato.addEventListener("click", function () {
    comodato_archivo_sin_firmar = document.getElementById("comodato_archivo_sin_firmar");
    console.log(comodato_archivo_sin_firmar.value);
    obtenervaloresenciarcomodato();
    if (validarllenado()) {
      insertardatos();
    }

    function obtenervaloresenciarcomodato() {
      valor_comodato_archivo_sin_firmar = comodato_archivo_sin_firmar.files[0];
    }


    function validarllenado() {
      const campos = [
        {
          campo: valor_comodato_archivo_sin_firmar,
          nombre: "comodato_archivo_sin_firmar",
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
      const formData = new FormData();
      formData.append("id_asignaciones", asignacion);
      formData.append(
        "comodato_archivo_sin_firmar",
        valor_comodato_archivo_sin_firmar
      );
      console.log(valor_comodato_archivo_sin_firmar);
      console.log(asignacion + "asignacion");

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades/enviarcomodato.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response);
          if (response.includes("correctamente")) {
            contenedorspinner.style.display = "none";
            window.location.href =
              "./solicitud_unidades.php?resultado=Comodatoenviado"; //resultado nombre del parametro -> resultado del contenido
          } else {
            if (response == "error") {
            }
          }
        },
      });
    }
  });
});
