document.addEventListener("DOMContentLoaded", function () {
  const modalinfounidademofisica = new bootstrap.Modal(document.getElementById("modalinfounidademofisica"));
  const modalinfounidademofisicabody = document.getElementById("modalinfounidademofisicabody");
  const contenedorspinner = document.getElementById("contenedorspinner");
  const modaldescripcionnegacionunidademofisica = new bootstrap.Modal(document.getElementById("modaldescripcionnegacionunidademofisica"));
  const modaldescripcionnegacionunidademofisicabody = document.getElementById("modaldescripcionnegacionunidademofisicabody");

  let id_unidad = 0;
  let id_asignacion_demo = 0;
  let id_persona_fisica = 0; 

  // Mostrar modal de información de unidad
  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnmosrarmodalunidadfisica")) {
      id_unidad = event.target.getAttribute("data-idunidad");
      id_asignacion_demo = event.target.getAttribute("data-id_asignacion_demo");
      id_persona_fisica = event.target.getAttribute("data-id_persona_fisica");
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_demo/formularioverunidadautorizacionfisica.php",
        data: { idunidad: id_unidad,
                idasignaciondemo: id_asignacion_demo,
                idpersonafisica: id_persona_fisica
              },
        success: function (response) {
          modalinfounidademofisicabody.innerHTML = response;
          modalinfounidademofisica.show();
        },
      });
    }
  });

  // Autorizar unidad
  document.body.addEventListener("click", function (event) {
    if (event.target && event.target.id === "btnaprovarunidademofisica") {
      Swal.fire({
        title: "¿Estás seguro de autorizar esta unidad?",
        text: "Una vez autorizada, no podrás revertir el proceso.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, autorizar",
      }).then((result) => {
        if (result.isConfirmed) {
          const formData = new FormData();
          formData.append("id_unidad", id_unidad);
          formData.append("id_asignacion_demo", id_asignacion_demo);
          formData.append("id_persona_fisica", id_persona_fisica);

          contenedorspinner.style.display = "flex";

          $.ajax({
            type: "POST",
            url: "../../Servidor/solicitudes/solicitud_unidades_demo/autorizar_unidad_demo_persona_fisica.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
              console.log(response);
              contenedorspinner.style.display = "none";
              if (response.includes("correctamente")) {
                window.location.href = "./autorizaciones_demos_personas_fisicas.php?resultado=Autorizacionunidademo";
              } else {
                Toastify({
                  text: "Hubo un error en la autorización.",
                  duration: 3000,
                  gravity: "top",
                  position: "right",
                  style: { background: "linear-gradient(to right, #ff5f6d, #ffc371)" },
                }).showToast();
              }
            },
          });
        }
      });
    }
  });

  // Mostrar modal de negación de la unidad
  document.body.addEventListener("click", function (event) {
    if (event.target && event.target.id === "btndenegarunidademofisica") {
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_demo/descripcion_negacion_unidad_demo_fisica.php",
        data: { idunidad: id_unidad,
                idasignaciondemo: id_asignacion_demo,
                idpersonafisica: id_persona_fisica
              },
        success: function (response) {
          modaldescripcionnegacionunidademofisicabody.innerHTML = response;
          modaldescripcionnegacionunidademofisica.show();
        },
      });
    }
  });

  // Denegar unidad (delegación porque se carga dinámicamente)
  document.body.addEventListener("click", function (event) {
    if (event.target && event.target.id === "btndenegarunidaddemofisica") {
      const descripcion = document.getElementById("descripcionegacionunidademofisica").value;


      if (descripcion.trim() === "") {
        Toastify({
          text: "El campo descripción no debe estar vacío.",
          duration: 3000,
          gravity: "top",
          position: "right",
          style: { background: "linear-gradient(to right, #b00000ff, #c93d3dff)" },
        }).showToast();
        return;
      }

      const formData = new FormData();
      formData.append("id_unidad", id_unidad);
      formData.append("id_asignacion_demo", id_asignacion_demo);
      formData.append("id_persona_fisica", id_persona_fisica);
      formData.append("descripcionegacionunidademofisica", descripcion);
      
      console.log(descripcion);
      console.log("id_unidad: " + id_unidad);
      console.log("id_asignacion_demo: " + id_asignacion_demo);
      console.log("id_persona_fisica: " + id_persona_fisica);
      contenedorspinner.style.display = "flex";
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/solicitud_unidades_demo/denegar_unidad_demo_fisica.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log("Éxito:", response);
          contenedorspinner.style.display = "none";
          window.location.href = "./validacion_unidades_comodato.php?resultado=Unidademodenegada";
        },
      });
    }
  });
});

//aqui usams este codigo para realizar el cambio de interfaz cards a tabla 
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