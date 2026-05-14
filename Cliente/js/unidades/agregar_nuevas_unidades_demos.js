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
  const paso_diferencial = document.getElementById("paso_diferencial");
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
  //constantes de formulario unidades demos
    const capacidad_carga = document.getElementById("capacidad_carga");
  const capacidad_pasajeros = document.getElementById("capacidad_pasajeros");
  const tipo_combustible = document.getElementById("tipo_combustible");
  const traccion = document.getElementById("traccion");
  const tipo_carroceria = document.getElementById("tipo_carroceria");
  const numero_puertas = document.getElementById("numero_puertas");
  const numero_asientos = document.getElementById("numero_asientos");
  const tipo_caja = document.getElementById("tipo_caja");
  const tipo_frenos = document.getElementById("tipo_frenos");
  const suspension = document.getElementById("suspension");
  const numero_ejes = document.getElementById("numero_ejes");
  const uso_permitido = document.getElementById("uso_permitido");

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
  //valores para los campos de unidades demo y filtración
  let valorcapacidad_carga;
  let valorcapacidad_pasajeros;
  let valortipo_combustible;
  let valortraccion;
  let valortipo_carroceria;
  let valornumero_puertas;
  let valornumero_asientos;
  let valortipo_caja;
  let valortipo_frenos;
  let valorsuspension;
  let valornumero_ejes;
  let valoruso_permitido;

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
    valorVIN = VIN.value;
    valorplacaunidad = placaunidad.value;
    valorpaso_diferencial = paso_diferencial.value;
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

    //obtener valores de unidades demo

    valorcapacidad_carga = capacidad_carga.value;
    valorcapacidad_pasajeros = capacidad_pasajeros.value;
    valortipo_combustible = tipo_combustible.value;
    valortraccion = traccion.value;
    valortipo_carroceria = tipo_carroceria.value;
    valornumero_puertas = numero_puertas.value;
    valornumero_asientos = numero_asientos.value;
    valortipo_caja = tipo_caja.value;
    valortipo_frenos = tipo_frenos.value;
    valorsuspension = suspension.value;
    valornumero_ejes = numero_ejes.value;
    valoruso_permitido = uso_permitido.value;

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

    console.log(valorcapacidad_carga);
    console.log(valorcapacidad_pasajeros);
    console.log(valortipo_combustible);
    console.log(valortraccion);
    console.log(valortipo_carroceria);
    console.log(valornumero_puertas);
    console.log(valornumero_asientos);
    console.log(valortipo_caja);
    console.log(valortipo_frenos);
    console.log(valorsuspension);
    console.log(valornumero_ejes);
    console.log(valoruso_permitido);
  }

  //validar que todos los campos esten llenos con toastify
  function validarllenado() {
  let valido = true;

  const camposObligatorios = [
    { campo: valormarcaunidad, nombre: "Marca" },
    { campo: valormodelounidad, nombre: "Modelo" },
    { campo: valormotorunidad, nombre: "Motor" },
    { campo: valorañounidad, nombre: "Año" },
    { campo: valorcolorunidad, nombre: "Color" },
    { campo: valortarjetacirculacionunidad, nombre: "Tarjeta de circulación" },
    { campo: valorestadounidad, nombre: "Estado" },
    { campo: valorestatusunidad, nombre: "Estatus" },
    { campo: valorsedeunidad, nombre: "Sede" },
    { campo: valortipoadquisicionunidad, nombre: "Tipo de adquisición" },
    { campo: valortipounidad, nombre: "Tipo de unidad" },
    { campo: valorfoliofactura, nombre: "Folio de factura" },
    { campo: valorplacaunidad, nombre: "Placa" },
    { campo: valorVIN, nombre: "VIN" }
  ];

  camposObligatorios.forEach(c => {
    if (!c.campo) {
      valido = false;
      Toastify({
        text: "Falta " + c.nombre,
        duration: 3000,
        gravity: "top",
        position: "right",
        style: {
          background: "linear-gradient(to right, red, red)"
        }
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

      caja.append("capacidad_carga", valorcapacidad_carga);
      caja.append("capacidad_pasajeros", valorcapacidad_pasajeros);
      caja.append("tipo_combustible", valortipo_combustible);
      caja.append("traccion", valortraccion);
      caja.append("tipo_carroceria", valortipo_carroceria);
      caja.append("numero_puertas", valornumero_puertas);
      caja.append("numero_asientos", valornumero_asientos);
      caja.append("tipo_caja", valortipo_caja);
      caja.append("tipo_frenos", valortipo_frenos);
      caja.append("suspension", valorsuspension);
      caja.append("numero_ejes", valornumero_ejes);
      caja.append("uso_permitido", valoruso_permitido);

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/insertar_unidades_demo.php",
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
});
