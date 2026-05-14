document.addEventListener("DOMContentLoaded", function () {
//variable global para guardar el id de la prueba de la unidad con asignacion
    let id_asignacion_unidad_demo = 0;

  //----------------------------------------------------------esto hace que todas las entradas de texto sean mayusculas
  document.addEventListener("input", function (e) {
    const target = e.target;
    if (target.tagName === "INPUT" && target.type === "text") {
      target.value = target.value.toUpperCase();
    }
  });

  //abrimos modal para registrar la prueba de unidad
  const modalregistrarpruebas = new bootstrap.Modal(
    document.getElementById("modalregistrarpruebas")
  );
  const modalregistrarpruebasbody = document.getElementById(
    "modalregistrarpruebasbody"
  );

  let realizacion_prueba = 0;
  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("realizacion_prueba")) {
      realizacion_prueba = event.target.getAttribute("data-idpruebademo");
      id_asignacion_unidad_demo = event.target.getAttribute("data-idpruebademo");
      $.ajax({
        type: "POST",
        data: { id_realizacion_prueba: realizacion_prueba },
        url: "../../Servidor/solicitudes/pruebas_unidades_demo/formulario_registro_pruebas.php",
        success: function (response) {
          modalregistrarpruebasbody.innerHTML = response;
          modalregistrarpruebas.show();
        },
      });
    }
  });

  //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");

  //-------------------------------------------------------------------registramos la primera prueba--------------------------------------------------

  let valornombre_conductor;
  let valortipo_prueba;
  let valororigen_inicial;
  let valororigen_destino;
  let valortemperatura;
  let valorevoluciones;
  let valorvelocidad;
  let valorkilometraje;
  let valorfoto_cluster;
  let valorfoto_unidad_exterior;
  let valorcomentarios_pruebas_demo;

document.body.addEventListener("click", function (event) {
  if (event.target.id === "btnregistrarpruebademo") {
      console.log("click en el boton");

      //mandamos a llamar los datos del formulario de registro de la primera prueba
      const nombre_conductor = document.getElementById("nombre_conductor");
      const tipo_prueba = document.getElementById("tipo_prueba");
      const origen_inicial = document.getElementById("origen_inicial");
      const origen_destino = document.getElementById("origen_destino");
      const temperatura = document.getElementById("temperatura");
      const revoluciones = document.getElementById("revoluciones");
      const velocidad = document.getElementById("velocidad");
      const kilometraje = document.getElementById("kilometraje");
      const foto_cluster = document.getElementById("foto_cluster");
      const foto_unidad_exterior = document.getElementById(
        "foto_unidad_exterior"
      );
      const comentarios_pruebas_demo = document.getElementById(
        "comentarios_pruebas_demo"
      );

      obtenervalores();
      validarllenado();
      insertardatos();
    }
  });

  function obtenervalores() {
    valornombre_conductor = nombre_conductor.value;
    valortipo_prueba = tipo_prueba.value;
    valororigen_inicial = origen_inicial.value;
    valororigen_destino = origen_destino.value;
    valortemperatura = temperatura.value;
    valorevoluciones = revoluciones.value;
    valorvelocidad = velocidad.value;
    valorkilometraje = kilometraje.value;
    valorfoto_cluster = foto_cluster.files[0];
    valorfoto_unidad_exterior = foto_unidad_exterior.files[0];
    valorcomentarios_pruebas_demo = comentarios_pruebas_demo.value;

    console.log(valornombre_conductor);
    console.log(valortipo_prueba);
    console.log(valororigen_inicial);
    console.log(valororigen_destino);
    console.log(valortemperatura);
    console.log(valorevoluciones);
    console.log(valorvelocidad);
    console.log(valorkilometraje);
    console.log(valorfoto_cluster);
    console.log(valorfoto_unidad_exterior);
    console.log(valorcomentarios_pruebas_demo);
  }

  function validarllenado() {
    const campos = [
      {
        campo: valornombre_conductor,
        nombre: "Nombre del conductor",
      },
      {
        campo: valortipo_prueba,
        nombre: "Tipo de prueba",
      },
      {
        campo: valororigen_inicial,
        nombre: "Origen inicial",
      },
      {
        campo: valororigen_destino,
        nombre: "Origen destino",
      },
      {
        campo: valortemperatura,
        nombre: "Temperatura",
      },
      {
        campo: valorevoluciones,
        nombre: "Revoluciones",
      },
      {
        campo: valorvelocidad,
        nombre: "Velocidad",
      },
      {
        campo: valorkilometraje,
        nombre: "Kilómetraje",
      },
      {
        campo: valorfoto_cluster,
        nombre: "Foto del cloúster",
      },
      {
        campo: valorfoto_unidad_exterior,
        nombre: "Foto de la unidad exterior",
      },
      {
        campo: valorcomentarios_pruebas_demo,
        nombre: "Comentarios de la pruebas",
      },
    ];

    for (let i = 0; i < campos.length; i++) {
      if (!campos[i].campo) {
        Toastify({
          text: "Falta el campo " + campos[i].nombre,
          duration: 3000,
          gravity: "top",
          position: "right",
          style: {
            background:
              "linear-gradient(to right,rgb(176, 0, 0),rgb(201, 61, 61))",
          },
        }).showToast();
        return false;
      }
    }
    return true;
  }

 function insertardatos() {
    if (validarllenado()) {
      console.log("entro a insertardatos");

      const formdata = new FormData();
      formdata.append("id_asignacion_unidad_demo", id_asignacion_unidad_demo);
      formdata.append("nombre_conductor", valornombre_conductor);
      formdata.append("tipo_prueba", valortipo_prueba);
      formdata.append("origen_inicial", valororigen_inicial);
      formdata.append("origen_destino", valororigen_destino);
      formdata.append("temperatura", valortemperatura);
      formdata.append("revoluciones", valorevoluciones);
      formdata.append("velocidad", valorvelocidad);
      formdata.append("kilometraje", valorkilometraje);
      formdata.append("foto_cluster", valorfoto_cluster);
      formdata.append("foto_unidad_exterior", valorfoto_unidad_exterior);
      formdata.append("comentarios_pruebas_demo", valorcomentarios_pruebas_demo);

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/pruebas_unidades_demo/insertar_pruebas_unidades_demo.php",
        data: formdata,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log("entro a success");
          console.log(response);
          if (response.includes("correctamente")) {
            contenedorspinner.style.display = "none";
            window.location.href ="./realizacion_prueba_demo.php?id_unidad="+id_asignacion_unidad_demo+"&resultado=pruebasinsertadas"; //resultado nombre del parametro -> resultado del contenido
          }
        },
      });
    }
  }

  //finalizamos las pruebas
  $(document).on('click', '.finalizar_prueba', function () {
    const id_asignacion = $(this).data('idpruebademo');

    Swal.fire({
        title: "¿Estás seguro de finalizar las pruebas para esta unidad?",
        text: "No podrás registrar más.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, finalizar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../Servidor/solicitudes/pruebas_unidades_demo/finalizar_pruebas_demo.php',
                type: 'POST',
                data: { id_asignacion },
                success: function (response) {
          console.log("entro a success");
          console.log(response);
          if (response.includes("correctamente")) {
            contenedorspinner.style.display = "none";
            window.location.href ="./realizacion_prueba_demo.php?id_unidad="+id_asignacion+"&resultado=pruebafinalizada"; //resultado nombre del parametro -> resultado del contenido
          }
        },
            });
        }
    });
});
});