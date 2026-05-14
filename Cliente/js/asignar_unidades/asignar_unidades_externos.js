document.addEventListener("DOMContentLoaded", function () {
  //-----------------------------------------------------------------------abrimos la modal para la asignacion de un ususario externo
  const modalasignarunidadexterno = new bootstrap.Modal(document.getElementById("modalasignarunidadexterno"));
  const modalasignarunidadexternobody = document.getElementById("modalasignarunidadexternobody");

  const modal = new bootstrap.Modal(document.getElementById("modalasignarunidadexclusiva")); //mostramos la modal para asignar la unidad
  const modalasignarunidadexclusivabody = document.getElementById("modalasignarunidadexclusivabody");
  

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnasignarunidadesexternos")) {
      $.ajax({
        type: "POST",
        url: "../../Servidor/solicitudes/unidades/asignacion_unidades_externos/formularioasignarunidadexterno.php",
        success: function (response) {
          modalasignarunidadexternobody.innerHTML = response;
          modalasignarunidadexterno.show();

          // REACTIVAR LÓGICA DEL SELECT DINÁMICO
          const selectTipo = document.getElementById("tipousuarioexterno");
          const camposNacional = document.getElementById("campos_nacional");
          const camposExtranjero = document.getElementById("campos_extranjero");

          if (selectTipo) {
            selectTipo.addEventListener("change", function () {
              const valor = selectTipo.value;
              if (valor === "1") {
                camposNacional.style.display = "block";
                camposExtranjero.style.display = "none";
              } else if (valor === "2") {
                camposNacional.style.display = "none";
                camposExtranjero.style.display = "block";
              } else {
                camposNacional.style.display = "none";
                camposExtranjero.style.display = "none";
              }
            });
          }
        },
      });
    }
  });

  // Delegación para detectar cambio en select cargado dinámicamente
  document.body.addEventListener("change", function (e) {
    if (e.target && e.target.id === "tipousuarioexterno") {
      console.log(e.target.value);
      const valor = e.target.value;
      const camposNacional = document.getElementById("campos_nacional");
      const camposExtranjero = document.getElementById("campos_extranjero");

      if (!camposNacional || !camposExtranjero) return;

      if (valor === "1") {
        camposNacional.style.display = "block";
        camposExtranjero.style.display = "none";
      } else if (valor === "2") {
        camposNacional.style.display = "none";
        camposExtranjero.style.display = "block";
      } else {
        camposNacional.style.display = "none";
        camposExtranjero.style.display = "none";
      }
    }
  });
  //---------------------------------------insertamos los valores en la base de datos

  //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");

  let valortipousuarioexterno;
  let valornombre1;
  let valornombre2;
  let valorapaterno;
  let valoramaterno;
  let valorgenero;
  let valorlicenciaconducir;
  let valorfechaemision;
  let valorfechavencimiento;
  let valorlicenciaPermanente;
  let valorestadolicenciaconducir;
  let valorarchivolicenciaconducir;
  let valordomicilio;
  let valorarchivodomicilio;
  let valorarchivoINE;
  let valorarchivoconsfiscal;
  let valortiporesidencia;
  let valorarchivocredencialresidencia;
  let valorpasaporte;
  let valorarchivopasaporte;
  let valorformamigratoria;

  document.body.addEventListener("click", function (event) {
    if (event.target.id === "btnasignarunidadexterno") {
      
      console.log("click en el boton");
      //mandamos a llamar los datos del formulario para registrar al colaborador externo
      const btnasignarunidadexterno = document.getElementById(
        "btnasignarunidadexterno"
      );

      contenedorspinner.style.display = "flex";

      obtenervalores();
      if (validarllenado()) {
        insertardatos();
      } else {
        contenedorspinner.style.display = "none";
      }
    }
  });
  function obtenervalores() {
    const tipousuarioexterno = document.getElementById("tipousuarioexterno");
    const nombre1 = document.getElementById("nombre1");
    const nombre2 = document.getElementById("nombre2");
    const apaterno = document.getElementById("apaterno");
    const amaterno = document.getElementById("amaterno");
    const genero = document.getElementById("genero");
    const licenciaconducir = document.getElementById("licenciaconducir");
    const fechaemision = document.getElementById("fechaemision");
    const fechavenci = document.getElementById("fechavenci");
    const estadolicenciaconducir = document.getElementById(
      "estadolicenciaconducir"
    );
    const archivolicenciaconducir = document.getElementById(
      "archivolicenciaconducir"
    );
    const domicilio = document.getElementById("domicilio");
    const archivodomicilio = document.getElementById("archivodomicilio");
    const archivoINE = document.getElementById("archivoINE");
    const archivoconsfiscal = document.getElementById("archivoconsfiscal");
    const tiporesidencia = document.getElementById("tiporesidencia");
    const archivocredencialresidencia = document.getElementById(
      "archivocredencialresidencia"
    );
    const pasaporte = document.getElementById("pasaporte");
    const archivopasaporte = document.getElementById("archivopasaporte");
    const formamigratoria = document.getElementById("formamigratoria");

    valortipousuarioexterno = tipousuarioexterno?.value || "";
    valornombre1 = nombre1?.value || "";
    valornombre2 = nombre2?.value || "";
    valorapaterno = apaterno?.value || "";
    valoramaterno = amaterno?.value || "";
    valorgenero = genero?.value || "";
    valorlicenciaconducir = licenciaconducir?.value || "";
    valorfechaemision = fechaemision?.value || "";
    valorfechavencimiento = fechavenci?.value || "";
    valorestadolicenciaconducir = estadolicenciaconducir?.value || "";
    valorarchivolicenciaconducir = archivolicenciaconducir?.files[0] || null;
    valordomicilio = domicilio?.value || "";
    valorarchivodomicilio = archivodomicilio?.files[0] || null;
    valorarchivoINE = archivoINE?.files[0] || null;
    valorarchivoconsfiscal = archivoconsfiscal?.files[0] || null;
    valortiporesidencia = tiporesidencia?.value || "";
    valorarchivocredencialresidencia =
      archivocredencialresidencia?.files[0] || null;
    valorpasaporte = pasaporte?.value || "";
    valorarchivopasaporte = archivopasaporte?.files[0] || null;
    valorformamigratoria = formamigratoria?.value || "";

    console.log(valortipousuarioexterno);
    console.log(valornombre1);
    console.log(valornombre2);
    console.log(valorapaterno);
    console.log(valoramaterno);
    console.log(valorgenero);
    console.log(valorlicenciaconducir);
    console.log(valorfechaemision);
    console.log(valorfechavencimiento);
    console.log(valorestadolicenciaconducir);
    console.log(valorarchivolicenciaconducir);
    console.log(valordomicilio);
    console.log(valorarchivodomicilio);
    console.log(valorarchivoINE);
    console.log(valorarchivoconsfiscal);
    console.log(valortiporesidencia);
    console.log(valorarchivocredencialresidencia);
    console.log(valorpasaporte);
    console.log(valorarchivopasaporte);
    console.log(valorformamigratoria);
  }

  function validarllenado() {
    const campos = [
      // Agrega más campos según necesidad
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
        return false;
      }
    }
    return true;
  }

  function insertardatos() {
    console.log("entro a insertardatos");

    const formdata = new FormData();
    formdata.append("tipousuarioexterno", valortipousuarioexterno);
    formdata.append("nombre1", valornombre1);
    formdata.append("nombre2", valornombre2);
    formdata.append("apaterno", valorapaterno);
    formdata.append("amaterno", valoramaterno);
    formdata.append("genero", valorgenero);
    formdata.append("licenciaconducir", valorlicenciaconducir);
    formdata.append("fechaemision", valorfechaemision);
    formdata.append("fechavenci", valorfechavencimiento);
    formdata.append("estadolicenciaconducir", valorestadolicenciaconducir);

    if (valorarchivolicenciaconducir)
      formdata.append("archivolicenciaconducir", valorarchivolicenciaconducir);
    if (valorarchivodomicilio)
      formdata.append("archivodomicilio", valorarchivodomicilio);
    if (valorarchivoINE) formdata.append("archivoINE", valorarchivoINE);
    if (valorarchivoconsfiscal)
      formdata.append("archivoconsfiscal", valorarchivoconsfiscal);

    formdata.append("domicilio", valordomicilio);

    if (valortipousuarioexterno === "2") {
      // Solo si es extranjero
      formdata.append("tiporesidencia", valortiporesidencia);
      if (valorarchivocredencialresidencia)
        formdata.append(
          "archivocredencialresidencia",
          valorarchivocredencialresidencia
        );
      formdata.append("pasaporte", valorpasaporte);
      if (valorarchivopasaporte)
        formdata.append("archivopasaporte", valorarchivopasaporte);
      formdata.append("formamigratoria", valorformamigratoria);
    }

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/unidades/asignacion_unidades_externos/insertar_usuario_externo.php",
      data: formdata,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log("entro a success");
        console.log(response);
        if (response.includes("correctamente")) {
          contenedorspinner.style.display = "none";
          
          modal.show();
          console.log("entro a ajax"),
          $.ajax({
            type: "POST",
            url: "../../Servidor/solicitudes/unidades/asignacion_unidades_externos/formularioseleccionarunidadexterno.php",
            success: function (response) {
              modalasignarunidadexterno.hide();
              modalasignarunidadexclusivabody.innerHTML = response;
              modalasignarunidadexclusiva.show();
            },
          })
        }
      },
    });
    //-------------------------aqui obtenemos el select para filtrar unidades disponibles dependiendo del modelo y mostrarlo en la tabla-------------------------------------------------
  }


});
