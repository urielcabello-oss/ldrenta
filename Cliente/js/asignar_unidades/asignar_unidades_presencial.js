document.addEventListener("DOMContentLoaded", function () {
    //modal de informacion de unidades asignadas
    const modalasignacionpresencial = new bootstrap.Modal(document.getElementById("modalasignacionpresencial"));
    const modalasignacionpresencialbody = document.getElementById("modalasignacionpresencialbody");

    let id_unidad_asignar = 0;
    let id_colaborador_asignar = 0;
    let id_usuario_externo = 0;
    let fechainspeccion = 0;
    let estatusinspeccion = 0;
    

    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("btnentregaunidad")) {
            id_unidad_asignar = event.target.getAttribute("data-id");
            id_colaborador_asignar = event.target.getAttribute("data-idcolaborador");
            id_usuario_externo = event.target.getAttribute("data-idusuarioexterno");
            console.log(id_unidad_asignar);
            console.log(id_colaborador_asignar);
            console.log(id_usuario_externo);
            $.ajax({
                type: "POST",
                data: {
                    idunidadasignar: id_unidad_asignar,
                    colaboradorasignacion: id_colaborador_asignar,
                    idusuarioexterno: id_usuario_externo
                },
                url: "../../Servidor/solicitudes/unidades/asignacion_unidades/formularioinfounidadasignacionpresencial.php",
                success: function (response) {
                    modalasignacionpresencialbody.innerHTML = response;
                    modalasignacionpresencial.show();
                }
            });
        }
    });

    //modal de cheklist de unidades
  const modalcheklistunidad = new bootstrap.Modal(document.getElementById("modalcheklistunidad"));
  const modalcheklistunidadbody = document.getElementById("modalcheklistunidadbody");

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btncheklistunidad")) {
        id_unidad_asignar = event.target.getAttribute("data-id");
        id_colaborador_asignar = event.target.getAttribute("data-idcolaborador");
        console.log(id_unidad_asignar);
        console.log(id_colaborador_asignar);
      $.ajax({
        type: "POST",
        data: {
            idunidadasignar: id_unidad_asignar,
            colaboradorasignacion: id_colaborador_asignar,
        },
        url: "../../Servidor/solicitudes/unidades/asignacion_unidades/formulariochecklistunidad.php",
        success: function (response) {
          modalcheklistunidadbody.innerHTML = response;
          modalcheklistunidad.show();
        }
      });
    }
  });

  //obtenemos la informacion de los checklist


});