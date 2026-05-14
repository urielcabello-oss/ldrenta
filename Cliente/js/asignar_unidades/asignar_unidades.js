//---------------------------------------------------------------aqui abrimos la modal de filtracion de unidades-------------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
  //obtenemos modal
  const modalfiltrounidades = new bootstrap.Modal(document.getElementById("modalfiltrounidades"));
  const modalfiltrounidadesbody = document.getElementById("modalfiltrounidadesbody");
  //informacion del select tipodirectivo
  const tipodirectivo = document.getElementById("tipodirectivo");

  //se obtener el cuerpo del modal para imprimir despues en el formulario de asignar unidades

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnasignarunidades")) {
      //mando la solicitud al servidor
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/asignacion_unidades/formularioasignarunidades.php",
        success: function (response) {
          modalfiltrounidadesbody.innerHTML = response;
          modalfiltrounidades.show();
        },
      });
    }
  });

  //---------------------------------------------------------------aqui obtenemos la información del predictivo con el id del colaborador-------------------------------------------------------------------------------

  document.body.addEventListener("change", function (event) {
    if (event.target.id === "tipodirectivo") {
      const valortipodirectivo = event.target.value;

      // Obtener el datalist y buscar el option que coincide
      const datalist = document.getElementById("datalisttipodirectivo").options;
      let idColaboradorSeleccionado = null;

      for (let i = 0; i < datalist.length; i++) {
        if (datalist[i].value === valortipodirectivo) {
          idColaboradorSeleccionado = datalist[i].getAttribute("data-id");
          break;
        }
      }

      // Guardar el ID como atributo en el input
      if (idColaboradorSeleccionado) {
        event.target.setAttribute("data-id", idColaboradorSeleccionado);
        console.log(
          "ID del colaborador seleccionado:",
          idColaboradorSeleccionado
        );
      } else {
        event.target.removeAttribute("data-id");
        console.log("Colaborador no encontrado.");
      }

      // Continúa con tu lógica del modelo
      const selectmodelosasignacion = document.getElementById(
        "selectmodelosasignacion"
      );

      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/asignacion_unidades/obtenerselectmodelo.php",
        data: { tipodirectivo: idColaboradorSeleccionado },
        success: function (response) {
          console.log(response);
          selectmodelosasignacion.innerHTML = response;
        },
      });
    }
  });

  //-------------------------aqui obtenemos el select para filtrar unidades disponibles dependiendo del modelo y mostrarlo en la tabla-------------------------------------------------

  let valorselectmodelosasignacion;

  document.body.addEventListener("change", function (event) {
    if (event.target.id === "selectmodelosasignacion") {
      valorselectmodelosasignacion = event.target.value;
      console.log("catalogo del modelo: " + valorselectmodelosasignacion);
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/asignacion_unidades/obtener_unidades_disponibles_asignacion.php",
        data: { selectmodelosasignacion: valorselectmodelosasignacion },
        success: function (response) {
          console.log(response);
          tablasignacionunidades.innerHTML = response;
        },
      });
    }
  });

  //-------------------------aqui abrimos la modal para vizualisar la informacion de la unidad y asignarla-------------------------------------------------------------------

  const modalasignarunidadexclusiva = new bootstrap.Modal(
    document.getElementById("modalasignarunidadexclusiva")
  );
  const modalasignarunidadexclusivabody = document.getElementById(
    "modalasignarunidadexclusivabody"
  );

  let id_unidad_asignar = 0;

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btninfounidadasignacion")) {
      id_unidad_asignar = event.target.getAttribute("data-id");

      const tipodirectivo = document.getElementById("tipodirectivo");
      const usuarioexternoasignacion = document.getElementById("usuarioexternoasignacion");

      let idColaboradorSeleccionado = null;
      let id_externo = null;

      if (tipodirectivo && tipodirectivo.value !== "") {
        idColaboradorSeleccionado = tipodirectivo.getAttribute("data-id");
      }

      if (usuarioexternoasignacion && usuarioexternoasignacion.value !== "") {
        id_externo = usuarioexternoasignacion.getAttribute("data-idusuexterno");
      }

      console.log("ID externo:", id_externo);
      console.log("ID unidad a asignar:", id_unidad_asignar);
      console.log(
        "ID del colaborador seleccionado:",
        idColaboradorSeleccionado
      );

      $.ajax({
        type: "POST",
        data: {
          idunidadasignar: id_unidad_asignar,
          colaboradorasignacion: idColaboradorSeleccionado,
          idexterno: id_externo,
        },
        url: "../../Servidor/solicitudes/unidades/asignacion_unidades/formularioinfounidadasignacionexclusiva.php",
        success: function (response) {
          modalasignarunidadexclusivabody.innerHTML = response;
          modalasignarunidadexclusiva.show();
        },
      });
    }
  });

  //--------------------------------------------------aqui mandamos a llamar al campo fecha de entrega de la unidad exlcuiva--------------------------------------------------------

  document.body.addEventListener("change", function (event) {
    if (event.target.id === "tipoasignacionunidad") {
      const valorSeleccionado = event.target.value;
      console.log("Valor seleccionado:", valorSeleccionado);

      const asignacionfechadevolucion = document.getElementById(
        "asignacionfechadevolucion"
      );

      if (valorSeleccionado === "1") {
        asignacionfechadevolucion.style.display = "block";
      } else {
        asignacionfechadevolucion.style.display = "none";
      }
    }
  });

  //--------------------------------------------------mandar los datos a la solicitud para insertar---------------------------------------------------------

  const btnasignarunidadexclusiva = document.getElementById("btnasignarunidadexclusiva");

  btnasignarunidadexclusiva.addEventListener("click", function () {
    btnasignarunidadexclusiva.disabled = true;
    const idunidadasignar = document.getElementById("idunidadasignar");

    const tipoasignacionunidad = document.getElementById("tipoasignacionunidad");
    const fechasignacion = document.getElementById("fechasignacion");
    const fechadevolucion = document.getElementById("fechadevolucion");
    const colaboradorasignacion = document.getElementById("tipodirectivo");
    const usuarioexternoasig = document.getElementById("idexterno");

    console.log("ID externo:", usuarioexternoasig.value);
    let valoridunidadasignar;
    let valortipoasignacionunidad;
    let valorfechasignacion;
    let valorfechadevolucion;
    let valorcolaboradorasignacion;
    let valorusuarioexternoasignacion;

    contenedorspinner.style.display = "flex";

    obtenervalores();
    if (validarllenado()) {
      insertardatos();
    } else {
      contenedorspinner.style.display = "none";
    }

    function obtenervalores() {
      const datalist = document.getElementById("datalisttipodirectivo");
      if (colaboradorasignacion) {
        const inputValue = colaboradorasignacion.value;
        valorcolaboradorasignacion = "";

        for (let option of datalist.options) {
          if (option.value === inputValue) {
            valorcolaboradorasignacion = option.getAttribute("data-id");
            break;
          }
        }
      }

      valoridunidadasignar = idunidadasignar.value;
      valortipoasignacionunidad = tipoasignacionunidad.value;
      valorfechasignacion = fechasignacion.value;
      valorfechadevolucion = fechadevolucion.value;
      if (usuarioexternoasig) {
       valorusuarioexternoasignacion  = usuarioexternoasig.value;
      }

      console.log(valoridunidadasignar);
      console.log(valortipoasignacionunidad);
      console.log(valorfechasignacion);
      console.log(valorfechadevolucion);
      console.log(valorcolaboradorasignacion);
      console.log(valorusuarioexternoasignacion);
    }

    function validarllenado() {
      const campos = [
        { campo: valoridunidadasignar, nombre: "idunidadasignar" },
        { campo: valortipoasignacionunidad, nombre: "tipoasignacionunidad" },
        { campo: valorfechasignacion, nombre: "fechasignacion" },
      ];

      for (let i = 0; i < campos.length; i++) {
        if (!campos[i].campo) {
          Toastify({
            text: "No obtuve " + campos[i].nombre,
            duration: 3000,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
              background:
                "linear-gradient(to right,rgb(0, 183, 255),rgb(0, 183, 255))",
            },
          }).showToast();
          contenedorspinner.style.display = "none";
          return false;
        }
      }
      return true;
    }

    function insertardatos() {
      console.log("entro a insertardatos");
      //meter en un formdata en este se puede meter informacion de todo tipo fyle, varchar etc etc
      const caja = new FormData();

      //metemos todo a la caja
      caja.append("idunidad", valoridunidadasignar);
      caja.append("tipoasignacionunidad", valortipoasignacionunidad);
      caja.append("fechasignacion", valorfechasignacion);
      caja.append("fechadevolucion", valorfechadevolucion);
      caja.append("colaboradorasignacion", valorcolaboradorasignacion);
      caja.append("usuarioexternoasignacion", valorusuarioexternoasignacion);

      console.log(caja);

      if (valorcolaboradorasignacion) {
        $.ajax({
          type: "POST",
          data: caja,
          url: "../../Servidor/solicitudes/unidades/asignacion_unidades/insertar_asignacion_unidad.php",
          contentType: false,
          processData: false,
          success: function (response) {
            contenedorspinner.style.display = "none";
            console.log("Respuesta del servidor:", response.trim());
            if (response.trim() === "error_licencia") {
              modalasignarunidadexclusiva.hide();
              window.location.href = "./unidades.php?resultado=SinLicencia";
              btnasignarunidadexclusiva.disabled = false;
              return;
            }
            window.location.href = "./unidades.php?resultado=Responsivaenviada";
            btnasignarunidadexclusiva.disabled = false;
            modalasignarunidadexclusiva.hide();
          },
        });
      } else if (valorusuarioexternoasignacion) {
        $.ajax({
          type: "POST",
          data: caja,
          url: "../../Servidor/solicitudes/unidades/asignacion_unidades/insertar_asignacion_unidad_externo.php",
          contentType: false,
          processData: false,
          success: function (response) {
            contenedorspinner.style.display = "none";
            console.log("Respuesta del servidor: ", response.trim());
            window.location.href = "./unidades.php?resultado=Responsivaenviada";
            btnasignarunidadexclusiva.disabled = false;
            modalasignarunidadexclusiva.hide();
          },
        });
      }
    }
  });
});
