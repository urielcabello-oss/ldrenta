document.addEventListener("DOMContentLoaded", function () {
  //abrimos la modal de la informacion de la unidad para que carlos Admin pueda ver la carta responsiva firmada por parte del colaborador
  const modalinfounidadcartaresponsiva = new bootstrap.Modal(
    document.getElementById("modalinfounidadcartaresponsiva")
  );
  const modalinfounidadcartaresponsivabody = document.getElementById(
    "modalinfounidadcartaresponsivabody"
  );
  const contenedorspinner = document.getElementById("contenedorspinner");

  let asignacion = 0;

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnmosrarmodalunidadsolicitud")) {
      asignacion = event.target.getAttribute("data-id");
      console.log(asignacion);
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_ver_responsiva/formularioverpolizafirmada.php", //mandamos al formulario
        data: { idasignacion: asignacion },
        success: function (response) {
          modalinfounidadcartaresponsivabody.innerHTML = response;
          modalinfounidadcartaresponsiva.show();
        },
      });
    }
  });

  //eventos click de los botones

  document.addEventListener("click", function (event) {
    if (event.target.id === "btnaprovarcartaresponsivafirmada") {
      btnaprovarcartaresponsivafirmada.disabled = true;
      console.log(asignacion);
      contenedorspinner.style.display = "flex";
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_ver_responsiva/aprobarcartaresponsivafirmada.php", //mandamos al formulario
        data: { idasignacion: asignacion },
        success: function (response) {
          console.log(response);
          contenedorspinner.style.display = "none";
          window.location.href =
            "./validacion_unidades.php?resultado=Responsivaaprovada";
          btnaprovarcartaresponsivafirmada.disabled = false;
          modalinfounidadcartaresponsiva.hide();
        },
      });
    }
  });

  //abrimos la modal para escribir el motivo de la denegacion de la carta responsiva

  const modaldescripcioncartadenegada = new bootstrap.Modal(
    document.getElementById("modaldescripcioncartadenegada")
  );
  const modaldescripcioncartadenegadabody = document.getElementById(
    "modaldescripcioncartadenegadabody"
  );

  document.body.addEventListener("click", function (event) {
    if (event.target.id === "btndenegarcartaresponsivafirmada") {
      console.log(asignacion);
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_ver_responsiva/descripciondenegacioncartaresponsiva.php", //mandamos al formulario
        data: { idasignacion: asignacion },
        success: function (response) {
          modaldescripcioncartadenegadabody.innerHTML = response;
          modaldescripcioncartadenegada.show();
        },
      });
    }
  });

  //----------------------------------------------realizamos el reporte de denegacion de la carta y lo insertamos
  const btndenegarcartaresponsivafirmadadenegar = document.getElementById(
    "btndenegarcartaresponsivafirmadadenegar"
  );
  let descripciondenegacion = document.getElementById("descripciondenegacion");
  let valordescripciondenegacion;

  btndenegarcartaresponsivafirmadadenegar.addEventListener(
    "click",
    function () {
      btndenegarcartaresponsivafirmadadenegar.disabled = true;
      descripciondenegacion = document.getElementById("descripciondenegacion");
      contenedorspinner.style.display = "flex";

      obtenervalores();
      if (validarllenado()) {
        insertardatos();
      } else {
      }

      function obtenervalores() {
        valordescripciondenegacion = descripciondenegacion.value;
        console.log(valordescripciondenegacion);
      }

      function validarllenado() {
        const campos = [
          {
            campo: valordescripciondenegacion,
            nombre: "descripciondenegacion",
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
        formData.append("descripciondenegacion", valordescripciondenegacion);

        $.ajax({
          type: "POST",
          url: "../../Servidor/solicitudes/solicitud_unidades_ver_responsiva/denegarcartaresponsivafirmada.php",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            console.log("entro a success");
            console.log(response);
            contenedorspinner.style.display = "none";
            window.location.href =
              "./validacion_unidades.php?resultado=Responsivadenegada";
            btndenegarcartaresponsivafirmadadenegar.disabled = false;
            modaldescripcioncartadenegada.hide();
          },
        });
      }
    }
  );
});
function toggleVista() {
    const button = document.getElementById("botonCambiarVista");
    const cards = document.getElementById("vistaCards");
    const tabla = document.getElementById("vistaTabla");
    const boton = event.target;

    if (cards.style.display === "none") {
        cards.style.display = "flex";
        tabla.style.display = "none";
        boton.textContent = "Cambiar a vista de tabla";
    } else {
        cards.style.display = "none";
        tabla.style.display = "block";
        boton.textContent = "Cambiar a vista de cards";
    }
}
