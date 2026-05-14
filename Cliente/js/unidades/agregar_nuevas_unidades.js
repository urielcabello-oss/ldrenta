document.addEventListener("DOMContentLoaded", function () {

    //----------------------------------------------------------esto hace que todas las entradas de texto sean mayusculas
  document.addEventListener("input", function (e) {
  const target = e.target;
  if (target.tagName === "INPUT" && target.type === "text") {
    target.value = target.value.toUpperCase();
  }
});


  const btnregistrarunidad = document.getElementById("btnregistrarunidad");

  const marcaunidad = document.getElementById("marcaunidad");
  const modelounidad = document.getElementById("modelounidad");
  const VIN = document.getElementById("VIN");
  const placaunidad = document.getElementById("placaunidad");
  const motorunidad = document.getElementById("motorunidad");
  const añounidad = document.getElementById("añounidad");
  const colorunidad = document.getElementById("colorunidad");
  const tarjetacirculacionunidad = document.getElementById("tarjetacirculacionunidad");
  const estadounidad = document.getElementById("estadounidad");
  const estatusunidad = document.getElementById("estatusunidad");
  const tipounidad = document.getElementById("tipounidad");
  const sedeunidad = document.getElementById("sedeunidad");
  const tipoadquisicionunidad = document.getElementById("tipoadquisicionunidad");
  const fechaadquisicionunidad = document.getElementById("fechaadquisicionunidad" );
  const foliofactura = document.getElementById("foliofactura");
  const arrendadora = document.getElementById("arrendadora");
  const imagen_unidad = document.getElementById("imagen_unidad");
 

  //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");

  let valormarcaunidad;
  let valormodelounidad;
  let valorVIN;
  let valorplacaunidad;
  let valormotorunidad;
  let valorañounidad;
  let valorcolorunidad;
  let valortarjetacirculacionunidad;
  let valorestadounidad;
  let valorestatusunidad;
  let valortipounidad;
  let valoresedeunidad;
  let valortipoadquisicionunidad;
  let valorfechaadquisicionunidad;
  let valorfoliofactura;
  let valorarrendadora;
  let valorimagenunidad;

  btnregistrarunidad.addEventListener("click", async function () {
    // Desactiva el botón para evitar múltiples clics
    btnregistrarunidad.disabled = true;
    contenedorspinner.style.display = "flex";

    try {
        obtenervalores();
        validarllenado();

        await insertardatos(); // Asegúrate que esta función sea asincrónica si hace algo que tarda

    } catch (error) {
        console.error("Ocurrió un error:", error);
        // Aquí puedes mostrar un mensaje de error al usuario si lo deseas
    } finally {
        // Siempre se ejecuta, con éxito o con error
        btnregistrarunidad.disabled = false;
        contenedorspinner.style.display = "none";
    }
});


  function obtenervalores() {
    //obtenemos todos los valores de los inputs
    valormarcaunidad = marcaunidad.value;
    valormodelounidad = modelounidad.value;
    valorVIN = VIN.value;
    valorplacaunidad = placaunidad.value;
    valormotorunidad = motorunidad.value;
    valorañounidad = añounidad.value;
    valorcolorunidad = colorunidad.value;
    valortarjetacirculacionunidad = tarjetacirculacionunidad.value;
    valorestadounidad = estadounidad.value;
    valorestatusunidad = estatusunidad.value;
    if (tipounidad) {
      valortipounidad = tipounidad.value;
    }
    valorsedeunidad = sedeunidad.value;
    valortipoadquisicionunidad = tipoadquisicionunidad.value;
    valorfechaadquisicionunidad = fechaadquisicionunidad.value;
    valorfoliofactura = foliofactura.value;
    valorarrendadora = arrendadora.value;
    valorimagen_unidad = imagen_unidad.value;

  

    console.log(valormarcaunidad);
    console.log(valormodelounidad);
    console.log(valorVIN);
    console.log(valorplacaunidad);
    console.log(valormotorunidad);
    console.log(valorañounidad);
    console.log(valorcolorunidad);
    console.log(valortarjetacirculacionunidad);
    console.log(valorestadounidad);
    console.log(valorestatusunidad);
    if (tipounidad) {
      console.log(valortipounidad);
    }
    console.log(valorsedeunidad);
    console.log(valortipoadquisicionunidad);
    console.log(valorfechaadquisicionunidad);
    console.log(valorfoliofactura);
    console.log(valorarrendadora);
    console.log(valorimagen_unidad);

  }

  //validar que todos los campos esten llenos con toastify
  function validarllenado() {
    const campos = [
      {
        campo: valormarcaunidad,
        nombre: "marcaunidad",
      },
      {
        campo: valormodelounidad,
        nombre: "modelounidad",
      },
      {
        campo: valorVIN,
        nombre: "VIN",
      },
      {
        campo: valorplacaunidad,
        nombre: "placaunidad",
      },
      {
        campo: valormotorunidad,
        nombre: "motorunidad",
      },
      {
        campo: valorañounidad,
        nombre: "añounidad",
      },
      {
        campo: valorcolorunidad,
        nombre: "colorunidad",
      },
      {
        campo: valortarjetacirculacionunidad,
        nombre: "tarjetacirculacionunidad",
      },
      {
        campo: valorestadounidad,
        nombre: "estadounidad",
      },
      {
        campo: valorestatusunidad,
        nombre: "estatusunidad",
      },
      ...(typeof valortipounidad !== "undefined"
        ? [
            {
              campo: valortipounidad,
              nombre: "tipounidad",
            },
          ]
        : []),
      {
        campo: valorsedeunidad,
        nombre: "sedeunidad",
      },
      {
        campo: valortipoadquisicionunidad,
        nombre: "tipoadquisicionunidad",
      },
      {
        campo: valorfechaadquisicionunidad,
        nombre: "fechaadquisicionunidad",
      },
      {
        campo: valorfoliofactura,
        nombre: "foliofactura",
      },
      {
        campo: valorarrendadora,
        nombre: "arrendadora",
      },
    ];

    for (let i = 0; i < campos.length; i++) {
      if (!campos[i].campo) {
        Toastify({
          text: "No obtuve " + campos[i].nombre,
          duration: 3000,
          gravity: "top", // `top` or `bottom`
          position: "right", // `left`, `center` or `right`
          stopOnFocus: true, // Prevents dismissing of toast on hover
          style: {
            background:
              "linear-gradient(to right,rgb(0, 183, 255),rgb(0, 183, 255))",
          },
        }).showToast();
      }
    }

    return true;
  }

  function insertardatos() {
    if (validarllenado()) {
      console.log("entro a insertardatos");
      //meter en un formdata en este se puede meter informacion de todo tipo fyle, varchar etc etc
      const caja = new FormData();

      //metemos todo a la caja
      caja.append("marcaunidad", valormarcaunidad);
      caja.append("modelounidad", valormodelounidad);
      caja.append("VIN", valorVIN);
      caja.append("placaunidad", valorplacaunidad);
      caja.append("motorunidad", valormotorunidad);
      caja.append("añounidad", valorañounidad);
      caja.append("colorunidad", valorcolorunidad);
      caja.append("tarjetacirculacionunidad", valortarjetacirculacionunidad);
      caja.append("estadounidad", valorestadounidad);
      caja.append("estatusunidad", valorestatusunidad);
      caja.append("tipounidad", valortipounidad);
      caja.append("sedeunidad", valorsedeunidad);
      caja.append("tipoadquisicionunidad", valortipoadquisicionunidad);
      caja.append("fechaadquisicionunidad", valorfechaadquisicionunidad);
      caja.append("foliofactura", valorfoliofactura);
      caja.append("arrendadora", valorarrendadora);
      caja.append("imagen_unidad", imagen_unidad.files[0]);



      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/insertar_unidades.php",
        data: caja,
        processData: false, //permite mandar imagenes
        contentType: false, //permite mandar imagenes
        success: function (response) {
          console.log("entro a success");
          console.log(response);
          if (response.includes("correctamente")) {
            contenedorspinner.style.display = "none";
            window.location.href =
              "./agrega_nuevas_unidades.php?resultado=Unidadinsertada"; //resultado nombre del parametro -> resultado del contenido
          }
          if (response.includes("Duplicate")) {
            Toastify({
              text: "Unidad ya registrada",
              duration: 3000,
              gravity: "top", // `top` or `bottom`
              position: "right", // `left`, `center` or `right`
              stopOnFocus: true, // Prevents dismissing of toast on hover
              style: {
                background:
                  "linear-gradient(to right,rgb(255, 0, 0),rgb(255, 0, 0))",
              },
            }).showToast();

            contenedorspinner.style.display = "none";
          } else if (response == "Error al insertar la unidad") {
            Toastify({
              text: "Error al insertar la poliza",
              duration: 3000,
              gravity: "top", // `top` or `bottom`
              position: "right", // `left`, `center` or `right`
              stopOnFocus: true, // Prevents dismissing of toast on hover
              style: {
                background:
                  "linear-gradient(to right,rgb(255, 0, 0),rgb(231, 0, 0))",
              },
            }).showToast();
            contenedorspinner.style.display = "none";
          }
          contenedorspinner.style.display = "none";
        },
      });
    }
  }
});
