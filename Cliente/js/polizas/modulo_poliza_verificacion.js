document.addEventListener("DOMContentLoaded", function () {
  const btnguardarverificacion = document.getElementById(
    "btnguardarverificacion"
  );

  const folioverificacion = document.getElementById("folioverificacion");
  const montoverificacion = document.getElementById("montoverificacion");
  const añoverificacion = document.getElementById("añoverificacion");
  const semestreverificacion = document.getElementById("semestreverificacion");
  const fechaverificacion = document.getElementById("fechaverificacion");
  const fechaproximaverificacion = document.getElementById(
    "fechaproximaverificacion"
  );
  const estatusverificacion = document.getElementById("estatusverificacion");

  //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");
  let id_unidad = 0;
  let valorfolioverificacion;
  let valormontoverificacion;
  let valorañoverificacion;
  let valorsemestreverificacion;
  let valorfechaverificacion;
  let valorfechaproximaverificacion;
  let valorestatusverificacion;

  //obtenemos modal
  modalverificaciones = new bootstrap.Modal(
    document.getElementById("modalverificaciones")
  );

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnverificaciones")) {
      id_unidad = event.target.getAttribute("data-id");
      renderizarTablaPolizas(); //muestra la tabla renderizada
      modalverificaciones.show();
    }
  });

  btnguardarverificacion.addEventListener("click", function () {
    btnguardarverificacion.disabled = true; //desactivamos el boton
    contenedorspinner.style.display = "flex";

    console.log("entro a btnguardarverificacion");
    obtenervalores();
    if (validarllenado()) {
      insertardatos();
    } else {
      btnguardarverificacion.disabled = false; //activamos el boton
      contenedorspinner.style.display = "none"; //cerramos el spinner
    }
  });

  function obtenervalores() {
    valorfolioverificacion = folioverificacion.value;
    valormontoverificacion = montoverificacion.value;
    valorañoverificacion = añoverificacion.value;
    valorsemestreverificacion = semestreverificacion.value;
    valorfechaverificacion = fechaverificacion.value;
    valorfechaproximaverificacion = fechaproximaverificacion.value;
    valorestatusverificacion = estatusverificacion.value;

    console.log(valorfolioverificacion);
    console.log(valormontoverificacion);
    console.log(valorañoverificacion);
    console.log(valorsemestreverificacion);
    console.log(valorfechaverificacion);
    console.log(valorfechaproximaverificacion);
    console.log(valorestatusverificacion);
  }

  //validar que los campos esten llenos con toastyfy
  function validarllenado() {
    const campos = [
      {
        campo: valorañoverificacion,
        nombre: "añoverificacion",
      },
      {
        campo: valorsemestreverificacion,
        nombre: "semestreverificacion",
      },
      {
        campo: valorfechaverificacion,
        nombre: "fechaverificacion",
      },
      {
        campo: valorfechaproximaverificacion,
        nombre: "fechaproximaverificacion",
      },
      {
        campo: valorestatusverificacion,
        nombre: "estatusverificacion",
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
    if (validarllenado()) {
      console.log("entro a insertardatos");
      //meter los datos en una caja
      const caja = new FormData();
      caja.append("id_unidad", id_unidad);
      caja.append("folioverificacion", valorfolioverificacion);
      caja.append("montoverificacion", valormontoverificacion);
      caja.append("añoverificacion", valorañoverificacion);
      caja.append("semestreverificacion", valorsemestreverificacion);
      caja.append("fechaverificacion", valorfechaverificacion);
      caja.append("fechaproximaverificacion", valorfechaproximaverificacion);
      caja.append("estatusverificacion", valorestatusverificacion);

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/polizas/insertar_polizas_verificaciones.php", //url para insertar las polizas
        data: caja,
        processData: false, //permite mandar imagenes
        contentType: false, //permite mandar imagenes
        success: function (response) {
          console.log("Respuesta del servidor:", response); // <-- muy importante
          console.log("entro a success");
          console.log(response);
          if (response.includes("Verificacion insertada correctamente")) {
            Toastify({
              text: "Verificacion insertada correctamente",
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
            window.location.href ="./unidades.php?resultado=Verificacioninsertada"; //resultado nombre del parametro -> resultado del contenido
          }
          if (response.includes("Duplicate")) {
            Toastify({
              text: "Verificacion ya registrada",
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
          }else if (response == "Error al insertar la poliza") {
            Toastify({
              text: "Error al insertar la poliza",
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
          }
          contenedorspinner.style.display = "none";
        },
      });
    }
  }
    const contenedor_poliza_verificacion = document.getElementById(
    "contenedor_poliza_verificacion"
    //creación de componentes de tablas renderisadas desde el servidor
  );
     function renderizarTablaPolizas() {
    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/polizas/obtener_tabla_verificaciones.php", //url para obtener las polizas
      data: {
        id_unidad: id_unidad,
      },
      success: function (response) {
        console.log(response);
        contenedor_poliza_verificacion.innerHTML = response;
      }
      });
  }
});
