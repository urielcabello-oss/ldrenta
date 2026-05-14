document.addEventListener("DOMContentLoaded", function () {
  const contenedorspinner = document.getElementById("contenedorspinner");
  const modalinfoformacionunidadpool = new bootstrap.Modal(
    document.getElementById("modalinfoformacionunidadpool")
  );

  const modalinfoformacionunidadpoolbody = document.getElementById(
    "modalinfoformacionunidadpoolbody"
  );

  const btnsolicitudunidadpool = document.getElementById("btnsolicitudunidadpool");
  const btnsolicitaruniadpool = document.getElementById("btnsolicitaruniadpool");

  let id_unidad = null;

  // ================= EVENTO GLOBAL PARA VERIFICAR UNIDAD =================
  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnmostrarunidadpool")) {
      id_unidad = event.target.getAttribute("data-id");

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_pool/formularioinfounidadpool.php",
        data: { id_unidad: id_unidad },
        success: function (response) {
          modalinfoformacionunidadpoolbody.innerHTML = response;
          modalinfoformacionunidadpool.show();
        },
      });
    }
  });

  // ================= BOTON VERIFICAR =================
  btnsolicitudunidadpool.addEventListener("click", function () {
    const sederecoleccionpool = document.getElementById("sederecoleccionpool");
    const fechasolicitudunidadpool = document.getElementById("fechasolicitudunidadpool");
    const horasolicitudunidadpool = document.getElementById("horasolicitudunidadpool");
    const sededevolucionunidadpool = document.getElementById("sededevolucionunidadpool");
    const fechadevolucionunidadpool = document.getElementById("fechadevolucionunidadpool");
    const horadevolucionunidadpool = document.getElementById("horadevolucionunidadpool");

    let valorsederecoleccionpool;
    let valorfechasolicitudunidadpool;
    let valorhorasolicitudunidadpool;
    let valorsededevolucionunidadpool;
    let valorfechadevolucionunidadpool;
    let valorhoradevolucionunidadpool;

    contenedorspinner.style.display = "flex";

    obtenervalores();

    if (validarllenado()) {
      consultar();
    } else {
      contenedorspinner.style.display = "none";
    }

    function obtenervalores() {
      valorsederecoleccionpool = sederecoleccionpool.value;
      valorfechasolicitudunidadpool = fechasolicitudunidadpool.value;
      valorhorasolicitudunidadpool = horasolicitudunidadpool.value;
      valorsededevolucionunidadpool = sededevolucionunidadpool.value;
      valorfechadevolucionunidadpool = fechadevolucionunidadpool.value;
      valorhoradevolucionunidadpool = horadevolucionunidadpool.value;
    }

    function validarllenado() {
      const campos = [
        { campo: valorsederecoleccionpool, atributo: "Ubicación de recolección" },
        { campo: valorfechasolicitudunidadpool, atributo: "Fecha de solicitud" },
        { campo: valorhorasolicitudunidadpool, atributo: "Hora de solicitud" },
        { campo: valorsededevolucionunidadpool, atributo: "Ubicación de devolución" },
        { campo: valorfechadevolucionunidadpool, atributo: "Fecha de devolución" },
        { campo: valorhoradevolucionunidadpool, atributo: "Hora de devolución" },
      ];

      for (let i = 0; i < campos.length; i++) {
        if (!campos[i].campo) {
          Toastify({
            text: "Completa: " + campos[i].atributo,
            duration: 3000,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: { background: "linear-gradient(to right,rgb(255,0,0),rgb(255,0,0))" },
          }).showToast();
          return false;
        }
      }
      return true;
    }

    function consultar() {
      const caja = new FormData();

      caja.append("sederecoleccionpool", valorsederecoleccionpool);
      caja.append("fechasolicitudunidadpool", valorfechasolicitudunidadpool);
      caja.append("horasolicitudunidadpool", valorhorasolicitudunidadpool);
      caja.append("sededevolucionunidadpool", valorsededevolucionunidadpool);
      caja.append("fechadevolucionunidadpool", valorfechadevolucionunidadpool);
      caja.append("horadevolucionunidadpool", valorhoradevolucionunidadpool);

      $.ajax({
        type: "POST",
        data: caja,
        url: "../../Servidor/solicitudes/solicitud_unidades_pool/consultar_unidades_disponibles.php",
        contentType: false,
        processData: false,
        success: function (response) {
          contenedorspinner.style.display = "none";
          document.getElementById("contenedorunidadesdisponiblespool").innerHTML = response;
        },
      });
    }
  });

  // ================= BOTON SOLICITAR =================
  btnsolicitaruniadpool.addEventListener("click", function () {

    if (!id_unidad) {
      Toastify({
        text: "Selecciona una unidad primero",
        duration: 3000,
        gravity: "top",
        position: "right",
        style: { background: "linear-gradient(to right,#ff0000,#ff0000)" },
      }).showToast();
      return;
    }

    contenedorspinner.style.display = "flex";

    const caja1 = new FormData();
    caja1.append("id_unidad", id_unidad);
    caja1.append("sederecoleccionpool", document.getElementById("sederecoleccionpool").value);
    caja1.append("fechasolicitudunidadpool", document.getElementById("fechasolicitudunidadpool").value);
    caja1.append("horasolicitudunidadpool", document.getElementById("horasolicitudunidadpool").value);
    caja1.append("sededevolucionunidadpool", document.getElementById("sededevolucionunidadpool").value);
    caja1.append("fechadevolucionunidadpool", document.getElementById("fechadevolucionunidadpool").value);
    caja1.append("horadevolucionunidadpool", document.getElementById("horadevolucionunidadpool").value);

    $.ajax({
      type: "POST",
      data: caja1,
      url: "../../Servidor/solicitudes/solicitud_unidades_pool/insertar_solicitud_unidad_pool.php",
      contentType: false,
      processData: false,
      success: function (response) {
        contenedorspinner.style.display = "none";
        modalinfoformacionunidadpool.hide();
        window.location.href = "./solicitud_unidades_pool.php?resultado=Solicitudunidadpool";
      },
    });
  });
});
