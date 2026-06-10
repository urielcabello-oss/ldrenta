$(document).ready(function () {
  cargarUnidadesPrincipales();
  cargarRelaciones();
});

function cargarUnidadesPrincipales() {
  $.ajax({
    url: "../../Servidor/solicitudes/unidades_sustituto/obtener_unidades_principales.php",
    type: "POST",

    success: function (response) {
      $("#unidadPrincipal").html(response);

      if ($("#unidadPrincipal").hasClass("select2-hidden-accessible")) {
        $("#unidadPrincipal").select2("destroy");
      }

      $("#unidadPrincipal").select2({
        placeholder: "Buscar por placa, VIN o modelo...",
        width: "100%",
      });
    },
  });
}

$(document).on("change", "#unidadPrincipal", function () {
  let idUnidad = $(this).val();

  if (idUnidad === "") {
    $("#tablaUnidadesSustitutas").html("");
    return;
  }

  cargarUnidadesSustitutas(idUnidad);
});

function cargarUnidadesSustitutas(idUnidad) {
  $.ajax({
    url: "../../Servidor/solicitudes/unidades_sustituto/consultar_unidades_sustitutas.php",

    type: "POST",

    data: {
      id_unidad: idUnidad,
    },

    success: function (response) {
      $("#tablaUnidadesSustitutas").html(response);
      if ($.fn.DataTable.isDataTable("#tablaSustitutas")) {
        $("#tablaSustitutas").DataTable().destroy();
      }

      $("#tablaSustitutas").DataTable({

    pageLength: 10,

    ordering: true,

    responsive: true,

    language: {

        search: "Buscar:",

        lengthMenu:
            "Mostrar _MENU_ registros",

        info:
            "Mostrando _START_ a _END_ de _TOTAL_ registros",

        paginate: {

            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"

        },

        emptyTable:
            "No hay unidades disponibles"

    }

}); 

      let total = $(".unidad-sustituta:checked").length;

      $("#contadorSeleccionadas").text(total);
    },
  });
}
$(document).on("change", ".unidad-sustituta", function () {
  let total = $(".unidad-sustituta:checked").length;

  $("#contadorSeleccionadas").text(total);
});

$("#btnGuardarSustitutos").click(function () {
  let idUnidad = $("#unidadPrincipal").val();

  if (idUnidad === "") {
    alert("Selecciona una unidad.");

    return;
  }

  let sustitutas = [];

  $(".unidad-sustituta:checked").each(function () {
    sustitutas.push($(this).val());
  });

  $.ajax({
    url: "../../Servidor/solicitudes/unidades_sustituto/registrar_unidades_sustituto.php",

    type: "POST",

    dataType: "json",

    data: {
      id_unidad: idUnidad,
      unidades_sustitutas: sustitutas,
    },

    success: function (response) {
      if (response.success) {
        cargarRelaciones();

        // Limpiar select
        $("#unidadPrincipal").val(null).trigger("change");

        // Limpiar tabla
        $("#tablaUnidadesSustitutas").html("");

        // Reiniciar contador
        $("#contadorSeleccionadas").text("0");

        // Limpiar buscador
        $("#buscarUnidad").val("");

        Swal.fire({
          icon: "success",
          title: "Correcto",
          text: response.mensaje,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: response.mensaje,
        });
      }
    },
  });
});

function cargarRelaciones() {
  $.ajax({
    url: "../../Servidor/solicitudes/unidades_sustituto/obtener_relaciones_sustituto.php",

    success: function (response) {
      $("#accordionRelaciones").html(response);
    },
  });
}

$(document).on("click", ".eliminarRelacion", function () {
  let idRelacion = $(this).data("id");

  Swal.fire({
    title: "¿Eliminar relación?",
    text: "La unidad dejará de estar asignada como sustituta.",
    icon: "warning",

    showCancelButton: true,

    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../Servidor/solicitudes/unidades_sustituto/eliminar_relacion.php",

        type: "POST",

        dataType: "json",

        data: {
          id_unidad_sustituto: idRelacion,
        },

        success: function (response) {
          if (response.success) {
            cargarRelaciones();

            let idUnidad = $("#unidadPrincipal").val();

            if (idUnidad !== "") {
              cargarUnidadesSustitutas(idUnidad);
            }

            Swal.fire({
              icon: "success",
              title: "Correcto",
              text: response.mensaje,
            });
          }
        },
      });
    }
  });
});

$("#buscarUnidad").on("keyup", function () {
  let valor = $(this).val().toLowerCase();

  $("#tablaUnidadesSustitutas tr").filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
  });
});
