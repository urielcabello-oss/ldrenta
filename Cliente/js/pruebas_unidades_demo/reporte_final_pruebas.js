
document.addEventListener("DOMContentLoaded", function () {
//variable global para guardar el id de la prueba de la unidad con asignacion
    let id_asignacion_unidad_demo = 0;

    
//abrimos la modal para subir el reporte final de la prueba
const modalregistrarresultados = new bootstrap.Modal(document.getElementById('modalregistrarresultados'));
const modalregistrarresultadosbody = document.getElementById('modalregistrarresultadosbody');
 
let subir_reporte_final = 0;
  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("subir_reporte_final")) {
      subir_reporte_final = event.target.getAttribute("data-idpruebademo");
      id_asignacion_unidad_demo = event.target.getAttribute("data-idpruebademo");
      $.ajax({
        type: "POST",
        data: { id_subir_reporte_final: subir_reporte_final },
        url: "../../Servidor/solicitudes/pruebas_unidades_demo/formulario_subir_reporte_final.php",
        success: function (response) {
          modalregistrarresultadosbody.innerHTML = response;
          modalregistrarresultados.show();
        },
      });
    }
  });


  //registrar el reporte final de las pruebas

  let valoreporte_final;
  let valorcomentarios_finales;

   document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnregistrarresultados")) {
      console.log("click en el boton");

      const reporte_final = document.getElementById("reporte_final");
      const comentarios_finales = document.getElementById("comentarios_finales");

      contenedorspinner.style.display = "flex";
      obtenervalores();
      validarllenado();
      insertardatos();
    }
   });

   function obtenervalores() {
    valoreporte_final = reporte_final.files[0];
    valorcomentarios_finales = comentarios_finales.value;

    console.log(valoreporte_final);
    console.log(valorcomentarios_finales);
  }

  function validarllenado() {
    const campos = [
      {
        campo: valoreporte_final,
        nombre: "Reporte final",
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
        contenedorspinner.style.display = "none";
        return;
      }
    }
  }

  function insertardatos() {
    const formdata = new FormData();
    formdata.append("id_asignacion_unidad_demo", id_asignacion_unidad_demo);
    formdata.append("reporte_final", valoreporte_final);
    formdata.append("comentarios_finales", valorcomentarios_finales); 

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/pruebas_unidades_demo/insertar_reporte_final.php",
      data: formdata,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log("entro a success");
        console.log(response);
        if (response.includes("correctamente")) {
          contenedorspinner.style.display = "none";
          window.location.href = "./realizacion_prueba_demo.php?id_unidad="+id_asignacion_unidad_demo+"&resultado=reporteinsertado"; //resultado nombre del parametro -> resultado del contenido
        }
      },
    });
  }
});