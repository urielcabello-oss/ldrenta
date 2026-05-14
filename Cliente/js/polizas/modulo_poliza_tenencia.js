document.addEventListener("DOMContentLoaded", function () {
    const btnguardartenencia = document.getElementById("btnguardartenencia");

    const foliotenencia = document.getElementById("foliotenencia");
    const añotenencia = document.getElementById("añotenencia");
    const estatustenencias = document.getElementById("estatustenencias");
    const montopago = document.getElementById("montopago");
    const fechapago = document.getElementById("fechapago");
    const fechavencimiento = document.getElementById("fechavencimiento");
    const documento_poliza_tenencia = document.getElementById("documento_poliza_tenencia");

      //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");
    let id_unidad = 0;
    let valorfoliotenencia;
    let valorañotenencia;
    let valorestatustenencias;
    let valormontopago;
    let valorfechapago;
    let valorfechavencimiento;
    let valordocumento_poliza_tenencia;

    //obtenemos modal
    modalTenenciasunidades = new bootstrap.Modal(document.getElementById("modalTenenciasunidades"));

    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("btntenencias")) {
          id_unidad = event.target.getAttribute("data-id");
          renderizarTablaPolizas();//muestra la tabla renderizada
          modalTenenciasunidades.show();
        }
      });

      btnguardartenencia.addEventListener("click", function () {
        btnguardartenencia.disabled = true;//desactivamos el boton
        contenedorspinner.style.display = "flex";
    
        console.log("entro a btnguardartenencia");
        obtenervalores();
        if (validarllenado()) {
          insertardatos();
        }else{
          btnguardartenencia.disabled = false;//activamos el boton
          contenedorspinner.style.display = "none";//cerramos el spinner
        }
      });

      function obtenervalores() {

         valorfoliotenencia = foliotenencia.value;
         valorañotenencia = añotenencia.value;
         valorestatustenencias = estatustenencias.value;
         valormontopago = montopago.value;
         valorfechapago = fechapago.value;
         valorfechavencimiento = fechavencimiento.value;
         valordocumento_poliza_tenencia = documento_poliza_tenencia.files[0]; //obtenemos el archivo

        console.log(valorfoliotenencia);
        console.log(valorañotenencia);
        console.log(valorestatustenencias);
        console.log(valormontopago);
        console.log(valorfechapago);
        console.log(valorfechavencimiento);
        console.log(valordocumento_poliza_tenencia);
      }

        //validar que los campos esten llenos con toastyfy
  function validarllenado() {
    const campos = [
      {
        campo: valorfoliotenencia,
        nombre: "foliotenencia",
      },
      {
        campo: valorañotenencia,
        nombre: "añotenencia",
      },
      {
        campo: valorestatustenencias,
        nombre: "estatustenencias",
      },
      {
        campo: valormontopago,
        nombre: "montopago",
      },
      {
        campo: valorfechapago,
        nombre: "fechapago",
      },
      {
        campo: valorfechavencimiento,
        nombre: "fechavencimiento",
      },
      {
        campo: valordocumento_poliza_tenencia,
        nombre: "documento_poliza_tenencia",
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
            background: "linear-gradient(to right, #00b09b, #96c93d)",
          },
        }).showToast();
        contenedorspinner.style.display = "none"; // Mueve esto antes del return
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
      caja.append("foliotenencia", valorfoliotenencia);
      caja.append("añotenencia", valorañotenencia);
      caja.append("estatustenencias", valorestatustenencias);
      caja.append("montopago", valormontopago);
      caja.append("fechapago", valorfechapago);
      caja.append("fechavencimiento", valorfechavencimiento);
      caja.append("documento_poliza_tenencia", valordocumento_poliza_tenencia);

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/polizas/insertar_polizas_tenencia.php", //url para insertar las polizas
        data: caja,
        processData: false, //permite mandar imagenes
        contentType: false, //permite mandar imagenes
        success: function (response) {
          console.log("Respuesta del servidor:", response);  // <-- muy importante
          console.log("entro a success");
          console.log(response);
          if (response.includes("Tenencia insertada correctamente")) {
            Toastify({
              text: "Tenencia insertada correctamente",
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
            window.location.href = "./unidades.php?resultado=Tenenciainsertada"; //resultado nombre del parametro -> resultado del contenido
          }
          if (response.includes("Duplicate")) {
            Toastify({
              text: "Tenencia ya registrada",
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
   //creación de componentes de tablas renderisadas desde el servidor
   function renderizarTablaPolizas() {
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