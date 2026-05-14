let tableUsuarios;

$("#buscarColaborador").keyup(function () {
  let term = $(this).val();

  if (term.length < 3) {
    $("#resultadoColaborador").hide();

    return;
  }

  $.ajax({
    url: "../../Servidor/usuarios/buscar_colaborador.php",
    type: "POST",
    data: { term },
    dataType: "json",

    success: function (data) {
      let html = "";

      data.forEach((col) => {
        html += `
                    <div class="item-colaborador"
                        data-id="${col.id_colaborador}"
                        data-nombre="${col.nombre}">

                        ${col.nombre}

                    </div>
                `;
      });

      $("#resultadoColaborador").html(html).show();
    },
  });
});

// ========================================
// SELECCIONAR COLABORADOR
// ========================================

$(document).on("click", ".item-colaborador", function () {
  let id = $(this).data("id");
  let nombre = $(this).data("nombre");

  $("#id_colaborador").val(id);

  $("#buscarColaborador").val(nombre);

  $("#resultadoColaborador").hide();
});

$("#formUsuario").submit(function (e) {
  e.preventDefault();

  $.ajax({
    url: "../../Servidor/usuarios/setusuario.php",
    type: "POST",
    data: $(this).serialize(),
    dataType: "json",

    beforeSend: function () {
      $("#contenedorspinner").show();
    },

    success: function (data) {

    $("#contenedorspinner").hide();

    console.log(data);

    if (data.status) {

        Swal.fire({
            icon: "success",
            title: "Correcto",
            text: data.msg,
        });

        $("#modalUsuario").modal("hide");

    } else {

        Swal.fire({
            icon: "error",
            title: "Error",
            text: data.msg,
        });
    }
},

    error: function () {
      $("#contenedorspinner").hide();

      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Ocurrió un error en el servidor",
      });
    },
  });
});

// ========================================
// TABLA USUARIOS
// ========================================

$(document).ready(function(){

    tableUsuarios = $("#tableUsuarios").DataTable({

    ajax: {
        url: "../../Servidor/usuarios/getUsuarios.php",
        dataSrc: "data"
    },

    columns: [
        { data: "colaborador" },
        { data: "rol" },
        { data: "estatus" },
        { data: "acciones" }
    ],

    columnDefs: [
        {
            targets: [2,3],
            orderable: false
        }
    ],

    responsive: true,
    destroy: true
});

});

// ========================================
// EDITAR
// ========================================

$(document).on("click", ".btnEditar", function () {
  let idusuario = $(this).data("id");
  let colaborador = $(this).data("colaborador");
  let idrol = $(this).data("idrol");

  $("#idusuario").val(idusuario);

  $("#buscarColaborador").val(colaborador);

  $("#idrol").val(idrol);

  $(".titulo-modal-usuario").text("Editar usuario");

  $(".btnGuardarUsuario").html(`
        <i class="fas fa-save"></i>
        Actualizar usuario
    `);

  $("#modalUsuario").modal("show");
});

$("#modalUsuario").on("hidden.bs.modal", function () {
  $("#formUsuario")[0].reset();

  $("#idusuario").val("");
  $("#id_colaborador").val("");

  $(".titulo-modal-usuario").text("Alta de usuario");

  $(".btnGuardarUsuario").html(`
        <i class="fas fa-save"></i>
        Guardar usuario
    `);
});


// ========================================
// CAMBIAR ESTATUS
// ========================================

$(document).on("click", ".btnStatus", function(){

    let idusuario = $(this).data("id");
    let status = $(this).data("status");

    $.ajax({

        url: "../../Servidor/usuarios/statusUsuario.php",
        type: "POST",
        dataType: "json",

        data: {
            idusuario,
            status
        },

        success: function(data){

            if(data.status){

                Swal.fire({
                    icon: 'success',
                    title: 'Correcto',
                    text: data.msg
                });

                tableUsuarios.ajax.reload();

            }else{

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.msg
                });
            }
        }
    });
});