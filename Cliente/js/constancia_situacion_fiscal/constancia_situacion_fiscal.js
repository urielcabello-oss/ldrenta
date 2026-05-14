document.addEventListener("DOMContentLoaded", function () {
    //abrimos la modal del formulario de registro de constancias de situacion fiscal
    const modalagregarconstanciaiscal = new bootstrap.Modal(document.getElementById("modalagregarconstanciaiscal"));
    const modalagregarconstanciaiscalbody = document.getElementById("modalagregarconstanciaiscalbody");

    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("btnabrirmodalagregarconstanciafiscal")) {
            $.ajax({
                type: "POST",
                url: "../../Servidor/solicitudes/constancias_situacion_fiscal/formularioagregarconstanciafiscal.php",
                success: function (response) {
                    modalagregarconstanciaiscal.show();
                    modalagregarconstanciaiscalbody.innerHTML = response;
                },
            });
        }
    });

  //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");

  let valorcolaboradorconstanciafiscal;
  let valorrfcolaborador;
  let valorarchivoconprobantefiscal;

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnagregarconstanciafiscal")) {
      console.log("click en el boton");

      //mandamos a llamar los datos del formulario de constancias de situacion fiscal
      const btnagregarconstanciafiscal = document.getElementById("btnagregarconstanciafiscal");

      const colaboradorconstanciafiscal = document.getElementById("colaboradorconstanciafiscal");
      const rfcolaborador = document.getElementById("rfcolaborador");
      const archivocomprobantefiscal = document.getElementById("archivocomprobantefiscal");

      contenedorspinner.style.display = "flex";
      obtenervalores();
      validarllenado();
      insertardatos();
    }
  });

  function obtenervalores(){

    const datalist = document.getElementById("datalistcolaborador");
    const inputValue = colaboradorconstanciafiscal.value;
    valorcolaboradorconstanciafiscal = "";

    for (let option of datalist.options) {
      if (option.value === inputValue) {
        valorcolaboradorconstanciafiscal = option.getAttribute("data-id");
        break;
      }
    }

    valorrfcolaborador = rfcolaborador.value;
    valorarchivoconprobantefiscal = archivocomprobantefiscal.files[0];

    console.log(valorcolaboradorconstanciafiscal);
    console.log(valorrfcolaborador);
    console.log(valorarchivoconprobantefiscal);
  }

  function validarllenado(){
    const campos = [
      {
        campo: valorcolaboradorconstanciafiscal,
        nombre: "colaboradorconstanciafiscal",
      },
      {
        campo: valorrfcolaborador,
        nombre: "rfcolaborador",
      },
      {
        campo: valorarchivoconprobantefiscal,
        nombre: "archivocomprobantefiscal",
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
    formData.append("colaboradorconstanciafiscal", valorcolaboradorconstanciafiscal);
    formData.append("rfcolaborador", valorrfcolaborador);
    formData.append("archivocomprobantefiscal", valorarchivoconprobantefiscal);

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/constancias_situacion_fiscal/insertar_constancia_situacion_fiscal.php",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log("entro a success");
        console.log(response);
        if (response.includes("correctamente")) {
        contenedorspinner.style.display = "none";
        window.location.href = "./constancia_situacion_fiscal.php?resultado=constanciafiscalinsertada";
        }
      },
    });
  }

});