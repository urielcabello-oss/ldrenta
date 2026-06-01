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
          Swal.fire({
            icon: "success",
            title: "Unidad registrada",
            timer: 1500,
            showConfirmButton: false,
          });

          document.getElementById("formRegistrarUnidadDemo").reset();

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

// =========================================
// REGISTRAR MARCA
// =========================================

document
  .getElementById("btnRegistrarMarca")
  .addEventListener("click", (event) => {
    event.preventDefault();

    const marca = document.getElementById("nuevaMarca").value;

    if (marca === "") {
      Swal.fire({
        icon: "warning",
        title: "Campo vacío",
        text: "Ingresa una marca",
      });

      return;
    }

    fetch("../../Servidor/solicitudes/unidades/registrar_marca.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: "marca=" + encodeURIComponent(marca),
    })
      .then((response) => response.json())

      .then((data) => {
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Marca registrada",
            timer: 1500,
            showConfirmButton: false,
          }).then(() => {
            document.getElementById("nuevaMarca").value = "";

            recargarMarcas();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: data.message,
          });
        }
      });
  });

// =========================================
// REGISTRAR MODELO
// =========================================
document
  .getElementById("btnRegistrarModelo")
  .addEventListener("click", (event) => {
    event.preventDefault();

    const marca = document.getElementById("marcaModelo").value;
    const modelo = document.getElementById("nuevoModelo").value;

    const kmInput = document.getElementById("kmMantenimiento");

    const km = kmInput ? kmInput.value : 10000;

    if (marca === "" || modelo === "") {
      Swal.fire({
        icon: "warning",
        title: "Completa todos los campos",
      });

      return;
    }

    fetch("../../Servidor/solicitudes/unidades/registrar_modelo.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body:
        "marca=" +
        encodeURIComponent(marca) +
        "&modelo=" +
        encodeURIComponent(modelo) +
        "&km=" +
        encodeURIComponent(km),
    })
      .then((response) => response.json())

      .then((data) => {
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Modelo registrado",
            timer: 1500,
            showConfirmButton: false,
          }).then(() => {
            document.getElementById("nuevoModelo").value = "";

            recargarModelos();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: data.message,
          });
        }
      });
  });

// =========================================
// REGISTRAR SEDE
// =========================================

document
  .getElementById("btnRegistrarSede")
  .addEventListener("click", (event) => {
    event.preventDefault();

    const sede = document.getElementById("nuevaSede").value;

    if (sede === "") {
      Swal.fire({
        icon: "warning",
        title: "Ingresa una sede",
      });

      return;
    }

    fetch("../../Servidor/solicitudes/unidades/registrar_sede.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: "sede=" + encodeURIComponent(sede),
    })
      .then((response) => response.json())

      .then((data) => {
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Sede registrada",
            timer: 1500,
            showConfirmButton: false,
          }).then(() => {
            document.getElementById("nuevaSede").value = "";

            recargarSedes();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: data.message || "Error al registrar sede",
          });
        }
      })

      .catch((error) => {
        console.error(error);

        Swal.fire({
          icon: "error",
          title: "Error inesperado",
        });
      });
  });

// =========================================
// MOSTRAR / OCULTAR CATALOGOS
// =========================================

document.addEventListener("DOMContentLoaded", () => {
  const btnToggleCatalogos = document.getElementById("btnToggleCatalogos");

  const panelCatalogos = document.getElementById("panelCatalogos");

  const panelAltaUnidad = document.getElementById("panelAltaUnidad");

  if (btnToggleCatalogos && panelCatalogos && panelAltaUnidad) {
    btnToggleCatalogos.addEventListener("click", () => {
      const catalogosVisibles = !panelCatalogos.classList.contains("d-none");

      // =====================================
      // OCULTAR CATALOGOS
      // =====================================

      if (catalogosVisibles) {
        panelCatalogos.classList.add("d-none");

        panelAltaUnidad.classList.remove("d-none");

        btnToggleCatalogos.innerHTML = `
                    <i class="fa-solid fa-sliders me-2"></i>
                    Administrar catálogos
                `;
      }

      // =====================================
      // MOSTRAR CATALOGOS
      // =====================================
      else {
        panelCatalogos.classList.remove("d-none");

        panelAltaUnidad.classList.add("d-none");

        btnToggleCatalogos.innerHTML = `
                    <i class="fa-solid fa-xmark me-2"></i>
                    Ocultar catálogos
                `;
      }
    });
  }
});

async function recargarMarcas() {
  const response = await fetch(
    "../../Servidor/solicitudes/unidades/obtener_marcas.php",
  );

  const data = await response.json();

  const selects = [
    document.getElementById("marcaunidad"),
    document.getElementById("marcaModelo"),
  ];

  selects.forEach((select) => {
    if (!select) return;

    select.innerHTML = '<option value="">Seleccionar</option>';

    data.forEach((marca) => {
      select.innerHTML += `
                <option value="${marca.id_marca}">
                    ${marca.nombre_marca}
                </option>
            `;
    });
  });
}

async function recargarSedes() {
  const response = await fetch(
    "../../Servidor/solicitudes/unidades/obtener_sedes.php",
  );

  const data = await response.json();

  const select = document.getElementById("sedeunidad");

  select.innerHTML = '<option value="">Seleccionar</option>';

  data.forEach((sede) => {
    select.innerHTML += `
            <option value="${sede.id_sede}">
                ${sede.ubicacion}
            </option>
        `;
  });
}

async function recargarModelos() {
  const marcaId = document.getElementById("marcaunidad").value;

  if (!marcaId) return;

  const response = await fetch(
    "../../Servidor/solicitudes/unidades/obtener_modelos.php?marca_id=" +
      marcaId,
  );

  const data = await response.json();

  const select = document.getElementById("modelounidad");

  select.innerHTML = '<option value="">Seleccionar</option>';

  data.forEach((modelo) => {
    select.innerHTML += `
            <option value="${modelo.id_modelo}">
                ${modelo.nombre_modelo}
            </option>
        `;
  });
}
