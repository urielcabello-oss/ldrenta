document.addEventListener("DOMContentLoaded", function () {

  //----------------------------------------------------------esto hace que todas las entradas de texto sean mayusculas
  document.addEventListener("input", function (e) {
  const target = e.target;
  if (target.tagName === "INPUT" && target.type === "text") {
    target.value = target.value.toUpperCase();
  }
});
    
  //-------------------------------------------------------------------------modal para editar la informacion de la persona fisica
  const modaleditarpersonafisica = new bootstrap.Modal(document.getElementById("modaleditarpersonafisica"));
  const modaleditarpersonafisicabody = document.getElementById("modaleditarpersonafisicabody");

  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btneditarpersonafisica")) {
      persona_editar = event.target.getAttribute("data-id");
      $.ajax({
        type: "POST",
        data: { id_persona_editar: persona_editar },
        url: "../../Servidor//solicitudes/solicitud_ver_personas_fisicas/formulario_editar_personafisica.php",
        success: function (response) {
          console.log("entro a success");
          console.log(response);
          modaleditarpersonafisicabody.innerHTML = response;
          modaleditarpersonafisica.show();
        },
      });
    }
  });

  const btnactualizarpersonafisica = document.getElementById("btnactualizarpersonafisica");

  let editarnombrepersonafisica1, editarnombrepersonafisica2, editarapaternopersonafisica, editaramaternopersonafisica, editargeneropersonafisica;
  let editarinepersonafisica, editarvigenciainepersonafisica, editarcurppersonafisica, editarrfcpersonafisica, editardomiciliopersonafisica;
  let editararchivodomicilio, editararchivoINEpersonafisica, editararchivoCURPpersonafisica, editararchivoRFCpersonafisica;

let valoreditarnombrepersonafisica1, valoreditarnombrepersonafisica2, valoreditarapaternopersonafisica, valoreditaramaternopersonafisica, valoreditargeneropersonafisica;
let valoreditarinepersonafisica, valoreditarvigenciainepersonafisica, valoreditarrfcpersonafisica, valoreditardomiciliopersonafisica;
let valoreditararchivodomicilio, valoreditararchivoINEpersonafisica, valoreditararchivoCURPpersonafisica, valoreditararchivoRFCpersonafisica;  

  btnactualizarpersonafisica.addEventListener("click", function () {
    editarnombrepersonafisica1 = document.getElementById("editarnombrepersonafisica1");
    editarnombrepersonafisica2 = document.getElementById("editarnombrepersonafisica2");
    editarapaternopersonafisica = document.getElementById("editarapaternopersonafisica");
    editaramaternopersonafisica = document.getElementById("editaramaternopersonafisica");
    editargeneropersonafisica = document.getElementById("editargeneropersonafisica");
    editarinepersonafisica = document.getElementById("editarinepersonafisica");
    editarvigenciainepersonafisica = document.getElementById("editarvigenciainepersonafisica");
    editarcurppersonafisica = document.getElementById("editarcurppersonafisica");
    editarrfcpersonafisica = document.getElementById("editarrfcpersonafisica");
    editardomiciliopersonafisica = document.getElementById("editardomiciliopersonafisica");
    editararchivodomicilio = document.getElementById("editararchivodomicilio");
    editararchivoINEpersonafisica = document.getElementById("editararchivoINEpersonafisica");
    editararchivoCURPpersonafisica = document.getElementById("editararchivoCURPpersonafisica");
    editararchivoRFCpersonafisica = document.getElementById("editararchivoRFCpersonafisica");

        contenedorspinner.style.display = "flex";
        obtenervalores();
        validarllenado();
        insertardatos();
  });

  function obtenervalores() {
    valoreditarnombrepersonafisica1 = editarnombrepersonafisica1.value.toUpperCase();
    valoreditarnombrepersonafisica2 = editarnombrepersonafisica2.value.toUpperCase();
    valoreditarapaternopersonafisica = editarapaternopersonafisica.value.toUpperCase();
    valoreditaramaternopersonafisica = editaramaternopersonafisica.value.toUpperCase();
    valoreditargeneropersonafisica = editargeneropersonafisica.value.toUpperCase();
    valoreditarinepersonafisica = editarinepersonafisica.value.toUpperCase();
    valoreditarvigenciainepersonafisica = editarvigenciainepersonafisica.value.toUpperCase();
    valoreditarrfcpersonafisica = editarrfcpersonafisica.value.toUpperCase();
    valoreditarcurppersonafisica = editarcurppersonafisica.value.toUpperCase();
    valoreditardomiciliopersonafisica = editardomiciliopersonafisica.value.toUpperCase();
    valoreditararchivodomicilio = editararchivodomicilio.files[0];
    valoreditararchivoINEpersonafisica = editararchivoINEpersonafisica.files[0];
    valoreditararchivoCURPpersonafisica = editararchivoCURPpersonafisica.files[0];
    valoreditararchivoRFCpersonafisica = editararchivoRFCpersonafisica.files[0];
  }

  function validarllenado() {
    const campos = [
    ];
  }
function insertardatos(){
  const formData = new FormData();
  formData.append("id_persona_fisica", persona_editar); 
  formData.append("editarnombrepersonafisica1", valoreditarnombrepersonafisica1);
  formData.append("editarnombrepersonafisica2", valoreditarnombrepersonafisica2);
  formData.append("editarapaternopersonafisica", valoreditarapaternopersonafisica);
  formData.append("editaramaternopersonafisica", valoreditaramaternopersonafisica);
  formData.append("editargeneropersonafisica", valoreditargeneropersonafisica);
  formData.append("editarinepersonafisica", valoreditarinepersonafisica);
  formData.append("editarvigenciainepersonafisica", valoreditarvigenciainepersonafisica);
  formData.append("editarcurppersonafisica", valoreditarcurppersonafisica);
  formData.append("editarrfcpersonafisica", valoreditarrfcpersonafisica);
  formData.append("editardomiciliopersonafisica", valoreditardomiciliopersonafisica);
  formData.append("editararchivodomicilio", valoreditararchivodomicilio);
  formData.append("editararchivoINEpersonafisica", valoreditararchivoINEpersonafisica);
  formData.append("editararchivoCURPpersonafisica", valoreditararchivoCURPpersonafisica);
  formData.append("editararchivoRFCpersonafisica", valoreditararchivoRFCpersonafisica);

  $.ajax({
    type: "POST",
    url: "../../Servidor/solicitudes/solicitud_ver_personas_fisicas/actualizar_personas_fisicas.php",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      console.log("entro a success");
      console.log(response);
      if (response.includes("correctamente")) {
        contenedorspinner.style.display = "none";
        window.location.href = "./personas_fisicas.php?resultado=personafisicaactualizada";
      }
    },
  });
}
  

});