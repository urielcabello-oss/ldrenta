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
  const vin = document.getElementById("vin");
  const placaunidad = document.getElementById("placaunidad");
  const pasodiferencial = document.getElementById("pasodiferencial");
  const motorunidad = document.getElementById("motorunidad");
  const anounidad = document.getElementById("anounidad");
  const colorunidad = document.getElementById("colorunidad");
  const costoneto = document.getElementById("costoneto");
  const estadounidad = document.getElementById("estadounidad");
  const estatusunidad = document.getElementById("estatusunidad");
  const tipounidad = document.getElementById("tipounidad");
  const sedeunidad = document.getElementById("sedeunidad");
  const tipoadquisicion = document.getElementById("tipoadquisicion");
  const fechaadquisicion = document.getElementById("fechaadquisicion");
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
  let valoranounidad;
  let valorcolorunidad;
  let valorcostoneto;
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
    btnregistrarunidad.disabled = true;
    contenedorspinner.style.display = "flex";

    try {
      obtenervalores();

      if (!validarllenado()) {
        return; // 🔥 si falla, no sigue
      }

      await insertardatos();
    } catch (error) {
      console.error("Ocurrió un error:", error);
    } finally {
      btnregistrarunidad.disabled = false;
      contenedorspinner.style.display = "none";
    }
  });

  function obtenervalores() {
    //obtenemos todos los valores de los inputs
    valormarcaunidad = marcaunidad.value;
    valormodelounidad = modelounidad.value;
    valorVIN = vin.value;
    valorplacaunidad = placaunidad.value;
    valorpaso_diferencial = pasodiferencial.value;
    valormotorunidad = motorunidad.value;
    valoranounidad = anounidad.value;
    valorcolorunidad = colorunidad.value;
    valorcostoneto = costoneto.value;
    valorestadounidad = estadounidad.value;
    valorestatusunidad = estatusunidad.value;
    if (tipounidad) {
      valortipounidad = tipounidad.value;
    }
    valorsedeunidad = sedeunidad.value;
    valortipoadquisicionunidad = tipoadquisicion.value;
    valorfechaadquisicionunidad = fechaadquisicion.value;
    valorfoliofactura = foliofactura.value;
    valorarrendadora = arrendadora.value;
    valorimagen_unidad = imagen_unidad.value;

    console.log(valormarcaunidad);
    console.log(valormodelounidad);
    console.log(valorVIN);
    console.log(valorplacaunidad);
    console.log(valormotorunidad);
    console.log(valoranounidad);
    console.log(valorcolorunidad);
    console.log(valorcostoneto);
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
    let valido = true;

    const camposObligatorios = [
      { campo: valormarcaunidad, nombre: "Marca" },
      { campo: valormodelounidad, nombre: "Modelo" },
      { campo: valorcostoneto, nombre: "Costo neto" },
      { campo: valorcolorunidad, nombre: "Color" },
      { campo: valorplacaunidad, nombre: "Placa" },
      { campo: valorVIN, nombre: "VIN" },
      { campo: valormotorunidad, nombre: "Número de motor" },
      { campo: valoranounidad, nombre: "Año" },
      { campo: valorfoliofactura, nombre: "Folio de factura" },
      { campo: valorestadounidad, nombre: "Estado" },
      { campo: valorestatusunidad, nombre: "Estatus" },
      { campo: valortipounidad, nombre: "Tipo de unidad" },
      { campo: valorsedeunidad, nombre: "Sede" },
      { campo: valortipoadquisicionunidad, nombre: "Tipo de adquisición" },
      { campo: valorarrendadora, nombre: "Arrendadora" },
    ];

    camposObligatorios.forEach((c) => {
      if (!c.campo) {
        valido = false;
        Toastify({
          text: "Falta " + c.nombre,
          duration: 3000,
          gravity: "top",
          position: "right",
          style: {
            background: "linear-gradient(to right, red, red)",
          },
        }).showToast();
      }
    });

    return valido;
  }

  function insertardatos() {
    console.log("entro a insertardatos");
    //meter en un formdata en este se puede meter informacion de todo tipo fyle, varchar etc etc
    const caja = new FormData();

    //metemos todo a la caja
    caja.append("marcaunidad", valormarcaunidad);
    caja.append("modelounidad", valormodelounidad);
    caja.append("VIN", valorVIN);
    caja.append("placaunidad", valorplacaunidad);
    caja.append("paso_diferencial", valorpaso_diferencial);
    caja.append("motorunidad", valormotorunidad);
    caja.append("anounidad", valoranounidad);
    caja.append("colorunidad", valorcolorunidad);
    caja.append("costoneto", valorcostoneto);
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
      url: "../../Servidor/solicitudes/unidades/insertar_unidades_demo.php",
      data: caja,
      processData: false, //permite mandar imagenes
      contentType: false, //permite mandar imagenes
      success: function (response) {
        response = response.trim();

        if (response === "Unidad insertada correctamente") {
          window.location.href =
            "./agrega_nuevas_unidades.php?resultado=Unidadinsertada";

          return;
        }

        if (response.includes("Duplicate")) {
          Toastify({
            text: "Unidad ya registrada",
            duration: 3000,
            gravity: "top",
            position: "right",
            style: {
              background: "red",
            },
          }).showToast();

          return;
        }

        Toastify({
          text: response,
          duration: 4000,
          gravity: "top",
          position: "right",
          style: {
            background: "red",
          },
        }).showToast();
      },
    });
  }
});
