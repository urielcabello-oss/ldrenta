document.addEventListener("DOMContentLoaded", function () {
  // abrimos la modal para poder ver la informacion de la unidad pool
  const modalinfounidadpool = new bootstrap.Modal(
    document.getElementById("modalinfounidadpool")
  );
  const modalinfounidadpoolbody = document.getElementById(
    "modalinfounidadpoolbody"
  );
  const contenedorspinner = document.getElementById("contenedorspinner");

  let idunidad = 0;

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnmostrarunidadpool")) {
      idunidad = event.target.getAttribute("data-id");
      console.log(idunidad);
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_pool/formularioinfounidadpool.php",
        data: { id_unidad: idunidad },
        success: function (response) {
          modalinfounidadpoolbody.innerHTML = response;
          modalinfounidadpool.show();
        },
      });
    }
  });
  
  //------------------------------------------------------------enviamos la solicitud del boton para realizar la insercion

  const btnsolicitaruniadpool = document.getElementById("btnsolicitaruniadpool");

  btnsolicitaruniadpool.addEventListener("click", function () {
    
    const id_usuario_pool = document.getElementById("id_usuario_pool");

    const fechasolicitudpool = document.getElementById("fechasolicitudpool");
    const fechadevolucionpool = document.getElementById("fechadevolucionpool");

    let valorid_usuario_pool;
    let valorfechasolicitudpool;
    let valorfechadevolucionpool;
    let valoridunidad;

    contenedorspinner.style.display = "flex";

    obtenervalores();
    if (validarllenado()) {
      insertardatos();
    } else {
      contenedorspinner.style.display = "none";
    }

    function obtenervalores() {
      valorid_usuario_pool = id_usuario_pool.value;
      valoridunidad = idunidad;
      valorfechasolicitudpool = fechasolicitudpool.value;
      valorfechadevolucionpool = fechadevolucionpool.value;

      console.log(valorid_usuario_pool);
      console.log(valoridunidad);
      console.log(valorfechasolicitudpool);
      console.log(valorfechadevolucionpool);
    }

    function validarllenado() {
      const campos = [
        { campo: valorid_usuario_pool, nombre: "id_usuario_pool" },
        { campo: valorfechasolicitudpool, nombre: "fechasolicitudpool" },
        { campo: valorfechadevolucionpool, nombre: "fechadevolucionpool" },
        { campo: valoridunidad, nombre: "idunidad" },
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
      console.log("entro a insertardatos");
      //meter en un formdata en este se puede meter informacion de todo tipo fyle, varchar etc etc
      const caja = new FormData();

      //metemos todo a la caja
      caja.append("id_usuario_pool", valorid_usuario_pool);
      caja.append("idunidad", valoridunidad);
      caja.append("fechasolicitudpool", valorfechasolicitudpool);
      caja.append("fechadevolucionpool", valorfechadevolucionpool);

      console.log(caja);

      $.ajax({
        type: "POST",
        data: caja,
        url: "../../Servidor/solicitudes/solicitud_unidades_pool/insertar_solicitud_unidad_pool.php",
        contentType: false,
        processData: false,
        success: function (response) {
          contenedorspinner.style.display = "none";
          window.location.href ="./solicitud_unidades_pool.php?resultado=Solicitudunidadpool";
          modalinfounidadpool.hide();
          console.log(response);
        },
      });
    }
  });
});
