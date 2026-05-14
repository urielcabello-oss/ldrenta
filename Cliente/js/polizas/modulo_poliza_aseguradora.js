document.addEventListener("DOMContentLoaded", function () {
  const btnguardaraseguradora = document.getElementById("btnguardaraseguradora");

  const nombreaseguradora = document.getElementById("nombreaseguradora");
  const identificadopolizaseguro = document.getElementById("identificadopolizaseguro");
  const fechaaltaseguro = document.getElementById("fechaaltaseguro");
  const fechavencimientoaseguradora = document.getElementById("fechavencimientoaseguradora");
  const estadoaseguradora = document.getElementById("estadoaseguradora");
  const estatusaseguradora = document.getElementById("estatusaseguradora");
  const documento_poliza = document.getElementById("documento_poliza");

  //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");

  let id_unidad = 0;
  let valornombreaseguradora;
  let valoridentificadopolizaseguro;
  let valorfechaaltaseguro;
  let valorfechavencimientoaseguradora;
  let valorestadoaseguradora;
  let valorestatusaseguradora;
  let valordocumento_poliza;
  
  //obtenemos modal
  const modalPolizasUnidades = new bootstrap.Modal(document.getElementById("modalPolizasUnidades"));

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnpolizasunidades")) {
      id_unidad = event.target.getAttribute("data-id");
      renderizarTablaPolizas();//muestra la tabla renderizada
      modalPolizasUnidades.show();
    }
  });

  btnguardaraseguradora.addEventListener("click", function () {
    btnguardaraseguradora.disabled = true;//desactivamos el boton
    contenedorspinner.style.display = "flex";

    console.log("entro a btnguardaraseguradora");
    obtenervalores();
    if (validarllenado()) {
      insertardatos();
    }else{
      btnguardaraseguradora.disabled = false;//activamos el boton
    }
  });

  function obtenervalores() {
    valornombreaseguradora = nombreaseguradora.value;
    valoridentificadopolizaseguro = identificadopolizaseguro.value;
    valorfechaaltaseguro = fechaaltaseguro.value;
    valorfechavencimientoaseguradora = fechavencimientoaseguradora.value;
    valorestadoaseguradora = estadoaseguradora.value;
    valorestatusaseguradora = estatusaseguradora.value;
    valordocumento_poliza = documento_poliza.files[0]; //obtenemos el archivo

    console.log(valornombreaseguradora);
    console.log(valoridentificadopolizaseguro);
    console.log(valorfechaaltaseguro);
    console.log(valorfechavencimientoaseguradora);
    console.log(valorestadoaseguradora);
    console.log(valorestatusaseguradora);
    console.log(valordocumento_poliza);
  }

  //validar que los campos esten llenos con toastyfy
  function validarllenado() {
    const campos = [
      {
        campo: valornombreaseguradora,
        nombre: "nombreaseguradora",
      },
      {
        campo: valoridentificadopolizaseguro,
        nombre: "identificadopolizaseguro",
      },
      {
        campo: valorfechaaltaseguro,
        nombre: "fechaaltaseguro",
      },
      {
        campo: valorfechavencimientoaseguradora,
        nombre: "fechavencimientoaseguradora",
      },
      {
        campo: valorestadoaseguradora,
        nombre: "estadoaseguradora",
      },
      {
        campo: valorestatusaseguradora,
        nombre: "estatusaseguradora",
      },
      {
        campo: valordocumento_poliza,
        nombre: "documento_poliza",
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
      //meter los datos en una caja
      const caja = new FormData();
      caja.append("id_unidad", id_unidad);
caja.append("nombreaseguradora", valornombreaseguradora);
caja.append("identificadopolizaseguro", valoridentificadopolizaseguro);
caja.append("fechaaltaseguro", valorfechaaltaseguro);
caja.append("fechavencimientoaseguradora", valorfechavencimientoaseguradora);
caja.append("estadoaseguradora", valorestadoaseguradora);
caja.append("estatusaseguradora", valorestatusaseguradora);
caja.append("documento_poliza", valordocumento_poliza);

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/polizas/insertar_polizas.php", //url para insertar las polizas
        data: caja,
        processData: false, //permite mandar imagenes
        contentType: false, //permite mandar imagenes
        success: function (response) {
          console.log("entro a success");
          console.log(response);
          if (response.includes("Poliza insertada correctamente")) {
            Toastify({
              text: "Poliza insertada correctamente",
              duration: 3000,
              gravity: "top", // `top` or `bottom`
              position: "right", // `left`, `center` or `right`
              stopOnFocus: true, // Prevents dismissing of toast on hover
              style: {
                background:
                  "linear-gradient(to right,rgb(255, 230, 0),rgb(231, 208, 0))",
              },
            }).showToast();

            contenedorspinner.style.display = "none";
            window.location.href = "./unidades.php?resultado=Polizainsertada"; //resultado nombre del parametro -> resultado del contenido
          }
          if (response.includes("Duplicate")) {
            Toastify({
              text: "Poliza ya registrada",
              duration: 3000,
              gravity: "top", // `top` or `bottom`
              position: "right", // `left`, `center` or `right`
              stopOnFocus: true, // Prevents dismissing of toast on hover
              style: {
                background:
                  "linear-gradient(to right,rgb(255, 0, 0),rgb(255, 0, 0))",
              },
            }).showToast();

            contenedorspinner.style.display = "none";
          } else if (response == "Error al insertar la poliza") {
            Toastify({
              text: "Error al insertar la poliza",
              duration: 3000,
              gravity: "top", // `top` or `bottom`
              position: "right", // `left`, `center` or `right`
              stopOnFocus: true, // Prevents dismissing of toast on hover
              style: {
                background:
                  "linear-gradient(to right,rgb(255, 0, 0),rgb(231, 0, 0))",
              },
            }).showToast();
            contenedorspinner.style.display = "none";
          }
          contenedorspinner.style.display = "none";
        },
      });
    }
  }

  const contenedor_poliza_tenencia = document.getElementById(
    "contenedor_poliza_tenencia"
  );
  const contenedor_poliza_seguro = document.getElementById(
    "contenedor_poliza_seguro"
  );

  //creación de componentes de tablas renderisadas desde el servidor
  function renderizarTablaPolizas() {
    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/polizas/obtener_tabla_seguro.php", //url para obtener las polizas
      data: {
        id_unidad: id_unidad,
      },
      success: function (response) {
        console.log(response);
        contenedor_poliza_seguro.innerHTML = response;
      },
    });

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/polizas/obtener_tabla_tenencias.php", //url para obtener las polizas
      data: {
        id_unidad: id_unidad,
      },
      success: function (response) {
        console.log(response);
        contenedor_poliza_tenencia.innerHTML = response;
      }
      });
  }
});
