document.addEventListener("DOMContentLoaded", function () {
  //abrimos la modal del formulario de alta de licencias
  const modalagregarcomprobantedomicilio = new bootstrap.Modal(document.getElementById("modalagregarcomprobantedomicilio"));
  const modalagregarcomprobantedomiciliobody = document.getElementById("modalagregarcomprobantedomiciliobody");

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnabrirmodalagregardomicilio")) {
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/comprobantes_domicilios/formularioagregarcomprobantedomicilio.php",
        success: function (response) {
          modalagregarcomprobantedomicilio.show();
          modalagregarcomprobantedomiciliobody.innerHTML = response;
        },
      });
    }
  });

  
  //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");

  let valorcolaboradordomicilio;
  let valordomicilio;
  let valorarchivodomicilio;

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnagregardomicilio")) {
      console.log("click en el boton");

      //mandamos a llamar los datos del formulario de los domicilios
      const btnagregardomicilio = document.getElementById("btnagregardomicilio");

      const colaboradordomicilio = document.getElementById("colaboradordomicilio");
      const domicilio = document.getElementById("domicilio");
      const archivodomicilio = document.getElementById("archivodomicilio");

      contenedorspinner.style.display = "flex";
      obtenervalores();
      validarllenado();
      insertardatos();
    }
  });

  function obtenervalores() {

    const datalist = document.getElementById("datalistcolaborador");
    const inputValue = colaboradordomicilio.value;
    valorcolaboradordomicilio = "";

    for (let option of datalist.options) {
      if (option.value === inputValue) {
        valorcolaboradordomicilio = option.getAttribute("data-id");
        break;
      }
    }

    valordomicilio = domicilio.value;
    valorarchivodomicilio = archivodomicilio.files[0];

    console.log(valorcolaboradordomicilio);
    console.log(valordomicilio);
    console.log(valorarchivodomicilio);
  }

  function validarllenado() {
    const campos = [
      {
        campo: valorcolaboradordomicilio,
        nombre: "colaboradordomicilio",
      },
      {
        campo: valordomicilio,
        nombre: "domicilio",
      },
      {
        campo: valorarchivodomicilio,
        nombre: "archivodomicilio",
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
        return false;
      }
    }
    return true;
  }

  function insertardatos() {
    const formData = new FormData();
    formData.append("colaboradordomicilio", valorcolaboradordomicilio);
    formData.append("domicilio", valordomicilio);
    formData.append("archivodomicilio", valorarchivodomicilio);

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/comprobantes_domicilios/insertar_comprobante_domicilio.php",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log("entro a success");
        console.log(response);
        contenedorspinner.style.display = "none";
        window.location.href ="./comprobante_domicilio.php?resultado=comprobantedomicilioinsertado";
      },
    });
  }

});