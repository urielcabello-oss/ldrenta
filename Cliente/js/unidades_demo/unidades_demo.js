let dataTable = null;

async function obtenerUnidades() {
  try {
    const response = await fetch(
      "../../Servidor/controllers/unidades_demo/obtener_unidades_demo.php",
    );

    const data = await response.json();

    if (data.status !== "success") {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: data.message,
      });

      return;
    }

    flotillaBody.innerHTML = "";

    data.data.forEach((unidad) => {
      flotillaBody.innerHTML += `

                    <tr>

                        <td>

                            <button
                                class="btn btn-sm btnEditarUnidad"
                                data-id="${unidad.id_unidad}">

                                <i class="fa-solid fa-pen"></i>

                            </button>

                        </td>

                        <td>${unidad.id_unidad}</td>

                        <td>${unidad.nombre_marca}</td>

                        <td>${unidad.nombre_modelo}</td>

                        <td>${unidad.placa}</td>

                        <td>${unidad.vin}</td>

                        <td>
                            ${unidad.paso_diferencial ?? "N/A"}
                        </td>

                        <td>${unidad.estatus}</td>

                        <td>${unidad.tipo_unidad}</td>

                        <td>${unidad.ubicacion}</td>

                        <td>
                            ${unidad.ultimo_kilometraje ?? 0}
                        </td>

                        <td>
                            <button class="btn btn-sm">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </button>
                        </td>

                        <td>
                            <button class="btn btn-sm">
                                <i class="fa-solid fa-shield"></i>
                            </button>
                        </td>

                        <td>
                            <button class="btn btn-sm">
                                <i class="fa-solid fa-file"></i>
                            </button>
                        </td>

                        <td>
                            <button class="btn btn-sm">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </button>
                        </td>

                    </tr>

                `;
    });

    // =====================================
    // DATATABLE
    // =====================================

    if (dataTable) {
      dataTable.destroy();
    }

    dataTable = $("#flotillaTable").DataTable({
      pageLength: 10,

      order: [[1, "desc"]],

      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
      },
    });
  } catch (error) {
    console.error(error);

    Swal.fire({
      icon: "error",
      title: "Error",
      text: "No fue posible cargar las unidades",
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const flotillaBody = document.getElementById("flotillaBody");

  obtenerUnidades();

  async function cargarMarcas(idMarcaSeleccionada = null) {

    const response = await fetch(
        "../../Servidor/controllers/unidades_demo/obtener_marcas.php"
    );

    const marcas = await response.json();

    $("#edit_marca").html(`
        <option value="">
            Selecciona marca
        </option>
    `);

    marcas.forEach(marca => {

        $("#edit_marca").append(`

            <option value="${marca.id_marca}">

                ${marca.nombre_marca}

            </option>

        `);

    });

    if (idMarcaSeleccionada) {
        $("#edit_marca").val(idMarcaSeleccionada);
    }

}

async function cargarModelos(idMarca, idModeloSeleccionado = null) {

    const response = await $.ajax({

        url: "../../Servidor/controllers/unidades_demo/obtener_modelos.php",
        method: "POST",

        data: {
            id_marca: idMarca
        }

    });

    $("#edit_modelo").html(`
        <option value="">
            Selecciona modelo
        </option>
    `);

    response.forEach(modelo => {

        $("#edit_modelo").append(`

            <option value="${modelo.id_modelo}">

                ${modelo.nombre_modelo}

            </option>

        `);

    });

    if (idModeloSeleccionado) {
        $("#edit_modelo").val(idModeloSeleccionado);
    }

}

$("#edit_marca").on("change", function () {

    const idMarca = $(this).val();

    cargarModelos(idMarca);

});

  // ==========================================
  // EDITAR UNIDAD
  // ==========================================

  $(document).on("click", ".btnEditarUnidad", function () {
    const idUnidad = $(this).data("id");

    $.ajax({
      url: "../../Servidor/controllers/unidades_demo/obtener_unidad.php",
      method: "POST",
      data: {
        id_unidad: idUnidad,
      },

      success: function (data) {


    await cargarMarcas(data.id_marca);

    await cargarModelos(
        data.id_marca,
        data.id_modelo
    );

        $("#edit_marca").val(data.nombre_marca);
        $("#edit_modelo").val(data.nombre_modelo);
        $("#edit_id_unidad").val(data.id_unidad);
        $("#edit_placa").val(data.placa);
        $("#edit_vin").val(data.vin);
        $("#edit_motor").val(data.numero_motor);
        $("#edit_costo").val(data.costo_neto);
        $("#edit_anio").val(data.año_unidad);
        $("#edit_paso").val(data.paso_diferencial);
        $("#edit_factura").val(data.folio_factura);
        $("#edit_fecha").val(data.fecha_adquisicion);

        $("#edit_estatus").val(data.id_estatus_unidad);
        $("#edit_tipo").val(data.id_tipo_unidad);
        $("#edit_sede").val(data.id_sede);

        $("#modalEditarUnidad").modal("show");
      },
    });
  });

  // ==========================================
  // GUARDAR EDICIÓN
  // ==========================================

  $("#btnGuardarEdicionUnidad").on("click", function () {
    const formData = $("#formEditarUnidad").serialize();

    $.ajax({
      url: "../../Servidor/controllers/unidades_demo/editar_unidad.php",
      method: "POST",
      data: formData,

      success: function (data) {

        if (data.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Unidad actualizada",
            text: data.message,
          });

          $("#modalEditarUnidad").modal("hide");

          obtenerUnidades();
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message,
          });
        }
      },
    });
  });
});
