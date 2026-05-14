//abrimos otra modal para la descripcion de la denegacion del comodato por parte del usuario
document.addEventListener("DOMContentLoaded", function () {
  const modalrechazarcomodatousuario = new bootstrap.Modal(document.getElementById("modalrechazarcomodatousuario"));
  const modalrechazarcomodatousuariobody = document.getElementById("modalrechazarcomodatousuariobody");
  let asignacion = 0;

  document.body.addEventListener("click", function (event) {
    if (event.target.id === "btnRechazarComodatousuario") {
        asignacion = event.target.getAttribute("data-id");
      console.log(asignacion);
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades/descripcionrechazarcomodatousuario.php",
        data: { idasignacion: asignacion },
        success: function (response) {
          modalrechazarcomodatousuariobody.innerHTML = response;
          modalrechazarcomodatousuario.show();
        },
      });
    }
  });
  //realizamos el reporte del porque se esta regresando el comodato
  const btnrechazarcomodato = document.getElementById("btnrechazarcomodato");
  let descripciondenegacioncomodatousuario;
  let valordescripciondenegacioncomodatousuario;

  btnrechazarcomodato.addEventListener("click", function () {
    descripciondenegacioncomodatousuario = document.getElementById(
      "descripciondenegacioncomodatousuario"
    );
    contenedorspinner.style.display = "flex";
    obtenervaloresrechazarcomodato();
    if (validarllenado()) {
      insertardatos();
    }
  });

  function obtenervaloresrechazarcomodato() {
    valordescripciondenegacioncomodatousuario =
      descripciondenegacioncomodatousuario.value;
    console.log(valordescripciondenegacioncomodatousuario);
  }

  function validarllenado() {
    const campos = [
      {
        campo: valordescripciondenegacioncomodatousuario,
        nombre: "descripciondenegacioncomodatousuario",
      },
    ];

    for (let i = 0; i < campos.length; i++) {
      if (campos[i].campo == "") {
        Toastify({
          text: "El campo " + campos[i].nombre + " no deve estar vacio",
          duration: 3000,
          gravity: "top", // `top` or `bottom`
          position: "right", // `left`, `center` or `right`
          stopOnFocus: true, // Prevents dismissing of toast on hover
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
    formData.append("idasignacion", asignacion);
    formData.append(
      "descripciondenegacioncomodatousuario",
      valordescripciondenegacioncomodatousuario
    );
    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/solicitud_unidades/rechazarcomodatousuario.php",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log("entro a success");
        console.log(response);
        contenedorspinner.style.display = "none";
        window.location.href =
          "./solicitud_unidades.php?resultado=Comodatoregresadoajuridico"; //resultado nombre del parametro -> resultado del contenido
        modalrechazarcomodatousuario.hide();
      },
    });
  }
});
