document.addEventListener("DOMContentLoaded", function () {
  //abrimos la modal del formulario para dra de alta las ines
  const modalagregarine = new bootstrap.Modal(document.getElementById("modalagregarine"));
  const modalagregarinebody = document.getElementById("modalagregarinebody");

    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("btnabrirmodalagregarine")) {
            $.ajax({
                type: "POST",
                url: "../../Servidor/solicitudes/ines/formularioagregarine.php",
                success: function (response) {
                    modalagregarine.show();
                    modalagregarinebody.innerHTML = response;
                },
            });
        }
    });

  //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");

  let valorcolaboradorine;
  let valorseccionine;
  let valorvigenciaine;
  let valorarchivoine;

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnagregarine")) {
      console.log("click en el boton");

      //mandamos a llamar los datos del formulario de ines
      const btnagregarine = document.getElementById("btnagregarine");

      const colaboradorine = document.getElementById("colaboradorine");
      const seccionine = document.getElementById("seccionine");
      const vigenciaine = document.getElementById("vigenciaine");
      const archivoine = document.getElementById("archivoine");

      contenedorspinner.style.display = "flex";
      obtenervalores();
      validarllenado();
      insertardatos();
    }
  });

  function obtenervalores() {

    const datalist = document.getElementById("datalistcolaborador");
    const inputValue = colaboradorine.value;
    valorcolaboradorine = "";

    for (let option of datalist.options) {
      if (option.value === inputValue) {
        valorcolaboradorine = option.getAttribute("data-id");
        break;
      }
    }

    valorseccionine = seccionine.value;
    valorvigenciaine = vigenciaine.value;
    valorarchivoine = archivoine.files[0];

    console.log(valorcolaboradorine);
    console.log(valorseccionine);
    console.log(valorvigenciaine);
    console.log(valorarchivoine);
  }

  function validarllenado() {
    const campos = [
      {
        campo: valorcolaboradorine,
        nombre: "colaboradorine",
      },
      {
        campo: valorseccionine,
        nombre: "seccionine",
      },
      {
        campo: valorvigenciaine,
        nombre: "vigenciaine",
      },
      {
        campo: valorarchivoine,
        nombre: "archivoine",
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
            background: "linear-gradient(to right, #b00000ff, #c93d3dff)",
          },
        }).showToast();
        return false;
      }
    }
  }

  function insertardatos() {
    const formData = new FormData();
    formData.append("colaboradorine", valorcolaboradorine);
    formData.append("seccionine", valorseccionine);
    formData.append("vigenciaine", valorvigenciaine);
    formData.append("archivoine", valorarchivoine);

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/ines/insertar_ine.php",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log("entro a success");
        console.log(response);
        if (response.includes("correctamente")) {
        contenedorspinner.style.display = "none";
        window.location.href = "./ine.php?resultado=ineinsertado";
        }
      },
    });
  }


});