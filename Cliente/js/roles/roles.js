let tableRoles;

// ========================================
// TABLA
// ========================================

$(document).ready(function () {

    tableRoles = $("#tableRoles").DataTable({

        ajax: {
            url: "../../Servidor/roles/getRoles.php",
            dataSrc: "data"
        },

        columns: [
            { data: "idrol" },
            { data: "nombrerol" },
            { data: "descripcion" },
            { data: "estatus" },
            { data: "acciones" }
        ]
    });

});

// ========================================
// GUARDAR ROL
// ========================================

$("#formRol").submit(function(e){

    e.preventDefault();

    $.ajax({

        url: "../../Servidor/roles/setRol.php",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",

        success: function(data){

            if(data.status){

                Swal.fire({
                    icon: 'success',
                    title: 'Correcto',
                    text: data.msg
                });

                $("#modalRol").modal("hide");

                $("#formRol")[0].reset();

                tableRoles.ajax.reload();

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

// ========================================
// EDITAR
// ========================================

$(document).on("click", ".btnEditar", function(){

    $("#idrol").val($(this).data("id"));

    $("#nombrerol").val($(this).data("rol"));

    $("#descripcion").val($(this).data("descripcion"));

    $(".titulo-modal-rol").text("Editar rol");

    $(".btnGuardarRol").html(`
        <i class="fas fa-save"></i>
        Actualizar rol
    `);

    $("#modalRol").modal("show");
});

// ========================================
// MODAL PERMISOS
// ========================================

$(document).on("click", ".btnPermisos", function(){

    let idrol = $(this).data("id");

    $("#idrolPermiso").val(idrol);

    $.ajax({

        url: "../../Servidor/roles/getPermisos.php",
        type: "POST",
        data: { idrol },
        dataType: "json",

        success: function(data){

            let html = "";

            data.forEach(modulo => {

                html += `
                    <tr>

                        <td>
                            ${modulo.titulo}
                        </td>

                        <td>
                            <input type="checkbox"
                                   class="permiso-r"
                                   data-id="${modulo.idmodulo}"
                                   ${modulo.r == 1 ? 'checked' : ''}>
                        </td>

                        <td>
                            <input type="checkbox"
                                   class="permiso-w"
                                   data-id="${modulo.idmodulo}"
                                   ${modulo.w == 1 ? 'checked' : ''}>
                        </td>

                        <td>
                            <input type="checkbox"
                                   class="permiso-u"
                                   data-id="${modulo.idmodulo}"
                                   ${modulo.u == 1 ? 'checked' : ''}>
                        </td>

                        <td>
                            <input type="checkbox"
                                   class="permiso-d"
                                   data-id="${modulo.idmodulo}"
                                   ${modulo.d == 1 ? 'checked' : ''}>
                        </td>

                    </tr>
                `;
            });

            $("#tbodyPermisos").html(html);

            $("#modalPermisos").modal("show");
        }
    });
});

// ========================================
// GUARDAR PERMISOS
// ========================================

$("#btnGuardarPermisos").click(function(){

    let permisos = [];

    $("#tbodyPermisos tr").each(function(){

        let idmodulo = $(this).find(".permiso-r").data("id");

        permisos.push({

            idmodulo,

            r: $(this).find(".permiso-r").is(":checked") ? 1 : 0,
            w: $(this).find(".permiso-w").is(":checked") ? 1 : 0,
            u: $(this).find(".permiso-u").is(":checked") ? 1 : 0,
            d: $(this).find(".permiso-d").is(":checked") ? 1 : 0
        });
    });

    $.ajax({

        url: "../../Servidor/roles/setPermisos.php",
        type: "POST",
        dataType: "json",

        data: {
            idrol: $("#idrolPermiso").val(),
            permisos
        },

        success: function(data){

            if(data.status){

                Swal.fire({
                    icon: 'success',
                    title: 'Correcto',
                    text: data.msg
                });

                $("#modalPermisos").modal("hide");
            }
        }
    });
});