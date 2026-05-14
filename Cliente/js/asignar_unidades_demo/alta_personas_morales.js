document.addEventListener("DOMContentLoaded", function () {

    //----------------------------------------------------------esto hace que todas las entradas de texto sean mayusculas
  document.addEventListener("input", function (e) {
  const target = e.target;
  if (target.tagName === "INPUT" && target.type === "text") {
    target.value = target.value.toUpperCase();
  }
});


//obtenemos la modal para dar de alta personas morales
const modalregistrarpersonasmorales = new bootstrap.Modal(document.getElementById("modalregistrarpersonasmorales"));
const modalregistrarpersonasmoralesbody = document.getElementById("modalregistrarpersonasmoralesbody");

document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnagregarpersonamoral")) {
        //mando la solicitud al servidor
        $.ajax({
            type: "POST",
            url: "../../Servidor/solicitudes/solicitud_ver_personas_morales/formularioaltapersonasmorales.php",
            success: function (response) {
                modalregistrarpersonasmoralesbody.innerHTML = response;
                modalregistrarpersonasmorales.show();
            }
        });
    }
});
    //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");

  let valorinstitucionorganizacion;
  let valoridentificacionlegal;
  let valorviegnciarepresentantelegal;
  let valorarchivoidentificacionrepresentantelegal;
  let valorarchivopoderepresentantelegal;
  let valorrfcpersonamoral;
  let valorarchivoRFCpersonamoral;
  let valordomiciliodomiciliopersonamoral;
  let valorarchivodomiciliopersonamoral;
  let valordomicilioresguardounidad;
  let valorarchivodomicilioresguardounidad;
  let valorarchivoescrituraconstitutiva;
  let valorarchivoestatusociales;
  let valorcontactopersonamoral;

  document.body.addEventListener("click", function (event) {
    if (event.target.id === "btnguardarpersonamoral") {
      console.log("click en el boton");

      //mandamos a llamar los datos del formulario de las personas fisicas
      const btnguardarpersonamoral = document.getElementById("btnguardarpersonamoral");

      const institucionorganizacion = document.getElementById("institucionorganizacion");
      const identificacionlegal = document.getElementById("identificacionlegal");
      const viegnciarepresentantelegal = document.getElementById("viegnciarepresentantelegal");
      const archivoidentificacionrepresentantelegal = document.getElementById("archivoidentificacionrepresentantelegal");
      const archivopoderepresentantelegal = document.getElementById("archivopoderepresentantelegal");
      const rfcpersonamoral = document.getElementById("rfcpersonamoral");
      const archivoRFCpersonamoral = document.getElementById("archivoRFCpersonamoral");
      const domiciliodomiciliopersonamoral = document.getElementById("domiciliodomiciliopersonamoral");
      const archivodomiciliopersonamoral = document.getElementById("archivodomiciliopersonamoral");
      const domicilioresguardounidad = document.getElementById("domicilioresguardounidad");
      const archivodomicilioresguardounidad = document.getElementById("archivodomicilioresguardounidad");
      const archivoescrituraconstitutiva = document.getElementById("archivoescrituraconstitutiva");
      const archivoestatusociales = document.getElementById("archivoestatusociales");
      const contactopersonamoral = document.getElementById("contactopersonamoral");

      contenedorspinner.style.display = "flex";
      obtenervalores();
      if(validarllenado()){
        insertardatos();
      } else {
        contenedorspinner.style.display = "none";
      }
    }
  });

  function obtenervalores(){
    valorinstitucionorganizacion = institucionorganizacion.value;
    valoridentificacionlegal = identificacionlegal.value; 
    valorviegnciarepresentantelegal = viegnciarepresentantelegal.value;
    valorarchivoidentificacionrepresentantelegal = archivoidentificacionrepresentantelegal.files[0];;
    valorarchivopoderepresentantelegal = archivopoderepresentantelegal.files[0];
    valorrfcpersonamoral = rfcpersonamoral.value.toUpperCase();
    valorarchivoRFCpersonamoral = archivoRFCpersonamoral.files[0];
    valordomiciliodomiciliopersonamoral = domiciliodomiciliopersonamoral.value.toUpperCase();
    valorarchivodomiciliopersonamoral = archivodomiciliopersonamoral.files[0];
    valordomicilioresguardounidad = domicilioresguardounidad.value.toUpperCase();
    valorarchivodomicilioresguardounidad = archivodomicilioresguardounidad.files[0];
    valorcontactopersonamoral = contactopersonamoral.value;


    // 👇 Cambiado: obtener todos los archivos de escritura constitutiva
  valorarchivoescrituraconstitutiva = [];
  document.querySelectorAll('input[name="archivoescrituraconstitutiva[]"]').forEach(input => {
    if (input.files.length > 0) {
      valorarchivoescrituraconstitutiva.push(input.files[0]);
    }
  });

    // 👇 Cambiado: obtener todos los archivos de escritura constitutiva
  valorarchivoestatusociales = [];
  document.querySelectorAll('input[name="archivoestatusociales[]"]').forEach(input => {
    if (input.files.length > 0) {
      valorarchivoestatusociales.push(input.files[0]);
    }
  });

    console.log(valorinstitucionorganizacion);
    console.log(valoridentificacionlegal);
    console.log(valorviegnciarepresentantelegal);
    console.log(valorarchivoidentificacionrepresentantelegal);
    console.log(valorarchivopoderepresentantelegal);
    console.log(valorrfcpersonamoral);
    console.log(valorarchivoRFCpersonamoral);
    console.log(valordomiciliodomiciliopersonamoral);
    console.log(valorarchivodomiciliopersonamoral);
    console.log(valordomicilioresguardounidad);
    console.log(valorarchivodomicilioresguardounidad);
    console.log(valorarchivoescrituraconstitutiva);
    console.log(valorarchivoestatusociales);
    console.log(valorcontactopersonamoral);
  }

  function validarllenado(){
    const campos = [
      {
        campo: valorinstitucionorganizacion,
        nombre: "Nombre de la persona moral",
      },
      {
        campo: valoridentificacionlegal,
        nombre: "Identificación del Representante Legal",
      },
      {
        campo: valorviegnciarepresentantelegal,
        nombre: "Vigencia de la Identificación del Representante Legal",
      },
      {
        campo: valorarchivoidentificacionrepresentantelegal,
        nombre: "Archivo de identificación del Representante Legal",
      },
      {
        campo: valorarchivopoderepresentantelegal,
        nombre: "Archivo de poder del Representante Legal",
      },
      {
        campo: valorrfcpersonamoral,
        nombre: "RFC",
      },
      {
        campo: valorarchivoRFCpersonamoral,
        nombre: "Archivo Constancia de Situación Fiscal",
      },
      {
        campo: valordomiciliodomiciliopersonamoral,
        nombre: "Domicilio moral",
      },
      {
        campo: valorarchivodomiciliopersonamoral,
        nombre: "Archivo comprobante de domicilio moral",
      },
      {
        campo: valordomicilioresguardounidad,
        nombre: "Resguardo de la unidad",
      },
      {
        campo: valorarchivodomicilioresguardounidad,
        nombre: "Archivo domicilio de resguardo de la unidad",
      },
      {
        campo: valorcontactopersonamoral,
        nombre: "Contacto de la persona",
      },
      {
        campo: valorarchivoescrituraconstitutiva,
        nombre: "Archivo de la escritura constitutiva",
      },
      {
        campo: valorarchivoestatusociales,
        nombre: "Archivo de las modificaciones a sus Estatutos Sociales",
      },
    ];
    for (let i = 0; i < campos.length; i++) {
      if (!campos[i].campo) {
        Toastify({
          text: "No obtuve: " + campos[i].nombre,
          duration: 3000,
          gravity: "center",
          position: "center",
          stopOnFocus: true,
          style: {
            background:
              "linear-gradient(to right,rgba(255, 0, 0, 1),rgba(231, 0, 0, 1))",
          },
        }).showToast();
        return false;
      }
    }
    return true;
  }

  function insertardatos() {
    const formData = new FormData();

    formData.append("institucionorganizacion", valorinstitucionorganizacion);
    formData.append("identificacionlegal", valoridentificacionlegal);
    formData.append("viegnciarepresentantelegal", valorviegnciarepresentantelegal);
    formData.append("archivoidentificacionrepresentantelegal", valorarchivoidentificacionrepresentantelegal);
    formData.append("archivopoderepresentantelegal", valorarchivopoderepresentantelegal);
    formData.append("rfcpersonamoral", valorrfcpersonamoral);
    formData.append("archivoRFCpersonamoral", valorarchivoRFCpersonamoral);
    formData.append("domiciliodomiciliopersonamoral", valordomiciliodomiciliopersonamoral);
    formData.append("archivodomiciliopersonamoral", valorarchivodomiciliopersonamoral);
    formData.append("domicilioresguardounidad", valordomicilioresguardounidad);
    formData.append("archivodomicilioresguardounidad", valorarchivodomicilioresguardounidad);
    formData.append("contactopersonamoral", valorcontactopersonamoral);
    // Agregar los archivos de escritura constitutiva (pueden ser varios)
    valorarchivoescrituraconstitutiva.forEach((file, index) => {
      formData.append("archivoescrituraconstitutiva[]", file);
    });
    // Agregar los archivos de escritura estatus sociales (pueden ser varios)
    valorarchivoestatusociales.forEach((file, index) => {
      formData.append("archivoestatusociales[]", file);
    });

    $.ajax({
      type: "POST",
      url: "../../Servidor/solicitudes/solicitud_ver_personas_morales/insertar_alta_persona_moral.php",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log("entro a success");
        console.log(response);
        contenedorspinner.style.display = "none";
        window.location.href = "./personas_morales.php?resultado=AltaPersonamoralExitosa";
      },
    });
  }

  
  //---------------------------------------------------------------------modales para ver documentos------------------------------------------------------

  //modal para ver el id del representante legal
  const modalveridrepresentantelegal = new bootstrap.Modal(document.getElementById("modalveridrepresentantelegal"));
  const modalveridrepresentantelegalbody = document.getElementById("modalveridrepresentantelegalbody");

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btnveridrepresentantelegal")) {
      persona_idrepresentantelegal = event.target.getAttribute("data-id");
      $.ajax({
        type: "POST",
        data: { id_persona_idrepresentantelegal: persona_idrepresentantelegal },
        url: "../../Servidor/solicitudes/solicitud_ver_personas_morales/veridrepresentantelegal.php",
        success: function (response) {
          modalveridrepresentantelegalbody.innerHTML = response;
          modalveridrepresentantelegal.show();
        },
      });
    }
  });

   //modal para ver el poder del representante legal
   const modalverpoderrepresentantelegal = new bootstrap.Modal(document.getElementById("modalverpoderrepresentantelegal"));
   const modalverpoderrepresentantelegalbody = document.getElementById("modalverpoderrepresentantelegalbody");  

   document.body.addEventListener("click", function (event) {
     if (event.target.classList.contains("btnverpoderrepresentantelegal")) {
       persona_poderrepresentantelegal = event.target.getAttribute("data-id");
       $.ajax({
         type: "POST",
         data: { id_persona_poderrepresentantelegal: persona_poderrepresentantelegal },
         url: "../../Servidor/solicitudes/solicitud_ver_personas_morales/verpoderrepresentantelegal.php",
         success: function (response) {
           modalverpoderrepresentantelegalbody.innerHTML = response;
           modalverpoderrepresentantelegal.show();
         },
       });
     }
   })

   //modal para ver el rfc
   const modalverrfc = new bootstrap.Modal(document.getElementById("modalverrfc"));
   const modalverrfcbody = document.getElementById("modalverrfcbody");

   document.body.addEventListener("click", function (event) {
     if (event.target.classList.contains("btnverrfc")) {
       persona_rfc = event.target.getAttribute("data-id");
       $.ajax({
         type: "POST",
         data: { id_persona_rfc: persona_rfc },
         url: "../../Servidor/solicitudes/solicitud_ver_personas_morales/verrfc.php",
         success: function (response) {
           modalverrfcbody.innerHTML = response;
           modalverrfc.show();
         },
       });
     }
   })

   //modal para ver el domicilio
   const modalverdomicilio = new bootstrap.Modal(document.getElementById("modalverdomicilio"));
   const modalverdomiciliobody = document.getElementById("modalverdomiciliobody");

   document.body.addEventListener("click", function (event) {
     if (event.target.classList.contains("btnverdomicilio")) {
       persona_domicilio = event.target.getAttribute("data-id");
       $.ajax({
         type: "POST",
         data: { id_persona_domicilio: persona_domicilio },
         url: "../../Servidor/solicitudes/solicitud_ver_personas_morales/verdomicilio.php",
         success: function (response) {
           modalverdomiciliobody.innerHTML = response;
           modalverdomicilio.show();
         },
       });
     }
   })

   //modal para ver la escritura constitutiva
   const modalverescrituraconstitutiva = new bootstrap.Modal(document.getElementById("modalverescrituraconstitutiva"));
   const modalverescrituraconstitutivabody = document.getElementById("modalverescrituraconstitutivabody");

   document.body.addEventListener("click", function (event) {
     if (event.target.classList.contains("btnverescrituraconstitutiva")) {
       persona_escrituraconstitutiva = event.target.getAttribute("data-id");
       $.ajax({
         type: "POST",
         data: { id_persona_escrituraconstitutiva: persona_escrituraconstitutiva },
         url: "../../Servidor/solicitudes/solicitud_ver_personas_morales/verescrituraconstitutiva.php",
         success: function (response) {
           modalverescrituraconstitutivabody.innerHTML = response;
           modalverescrituraconstitutiva.show();
         },
       });
     }
   })

   //modal para ver el estatus sociales
   const modalverestatusosciales = new bootstrap.Modal(document.getElementById("modalverestatusosciales"));
   const modalverestatusoscialesbody = document.getElementById("modalverestatusoscialesbody");

   document.body.addEventListener("click", function (event) {
     if (event.target.classList.contains("btnverestatusociales")) {
       persona_estatusociales = event.target.getAttribute("data-id");
       $.ajax({
         type: "POST",
         data: { id_persona_estatusociales: persona_estatusociales },
         url: "../../Servidor/solicitudes/solicitud_ver_personas_morales/verestatusociales.php",
         success: function (response) {
           modalverestatusoscialesbody.innerHTML = response;
           modalverestatusosciales.show();
         },
       });
     }
   })

   //modal para ver domicilio de resguardo
  const modalverdomicilioresguardo = new bootstrap.Modal(document.getElementById("modalverdomicilioresguardo"));
  const modalverdomicilioresguardobody = document.getElementById("modalverdomicilioresguardobody");

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btndomicilioresguardo")) {
      persona_domicilio_resguardo = event.target.getAttribute("data-id");
      $.ajax({
        type: "POST",
        data: { id_persona_domicilio_resguardo: persona_domicilio_resguardo },
        url: "../../Servidor/solicitudes/solicitud_ver_personas_morales/verdomicilioresguardomoral.php",
        success: function (response) {
          console.log("entro a success");
          console.log(response);
          modalverdomicilioresguardobody.innerHTML = response;
          modalverdomicilioresguardo.show();
        },
      });
    }
  });

   // Manejo de agregar/quitar archivos de Escritura Constitutiva
document.body.addEventListener("click", function (event) {
  // Botón para agregar archivo
  if (event.target.id === "btnAgregarEscritura") {
    const contenedor = document.getElementById("contenedor-escrituras");
    const div = document.createElement("div");
    div.className = "form-floating mb-2 d-flex align-items-center";

    div.innerHTML = `
      <input type="file" class="form-control" name="archivoescrituraconstitutiva[]" accept=".pdf">
      <button type="button" class="btn btn-sm btn-danger ms-2 quitarArchivo">✖</button>
    `;

    contenedor.appendChild(div);
    updateRequired();
  }

  // Botón para quitar archivo
  if (event.target.classList.contains("quitarArchivo")) {
    const fila = event.target.closest(".form-floating");
    if (fila) fila.remove();
    updateRequired();
  }
});

   // Manejo de agregar/quitar archivos de Escritura Estatus Sociales
document.body.addEventListener("click", function (event) {
  // Botón para agregar archivo
  if (event.target.id === "btnAgregarEstatus") {
    const contenedor2 = document.getElementById("contenedor-estatus");
    const div = document.createElement("div");
    div.className = "form-floating mb-2 d-flex align-items-center";

    div.innerHTML = `
      <input type="file" class="form-control" name="archivoestatusociales[]" accept=".pdf">
      <button type="button" class="btn btn-sm btn-danger ms-2 quitarArchivo">✖</button>
    `;

    contenedor2.appendChild(div);
    updateRequired();
  }

  // Botón para quitar archivo
  if (event.target.classList.contains("quitarArchivo")) {
    const fila = event.target.closest(".form-floating");
    if (fila) fila.remove();
    updateRequired();
  }
});

function updateRequired() {
  const contenedor = document.getElementById("contenedor-escrituras");
  const contenedor2 = document.getElementById("contenedor-estatus");
  const inputs = contenedor.querySelectorAll('input[type="file"][name="archivoescrituraconstitutiva[]"]');
  const inputs2 = contenedor2.querySelectorAll('input[type="file"][name="archivoestatusociales[]"]');
  if (inputs.length === 0) {
    const div = document.createElement("div");
    div.className = "form-floating mb-2";
    div.innerHTML = `<input type="file" class="form-control" name="archivoescrituraconstitutiva[]" accept=".pdf" required>`;
    contenedor.appendChild(div);
    return;
  }
  if (inputs2.length === 0) {
    const div = document.createElement("div");
    div.className = "form-floating mb-2";
    div.innerHTML = `<input type="file" class="form-control" name="archivoestatusociales[]" accept=".pdf" required>`;
    contenedor2.appendChild(div);
    return;
  }
  inputs.forEach(inp => inp.removeAttribute("required"));
  inputs[0].setAttribute("required", "required");
  inputs2.forEach(inp => inp.removeAttribute("required"));
  inputs2[0].setAttribute("required", "required");
}

});