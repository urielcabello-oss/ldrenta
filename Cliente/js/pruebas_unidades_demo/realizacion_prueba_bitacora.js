document.addEventListener("DOMContentLoaded", function () {

      //----------------------------------------------------------esto hace que todas las entradas de texto sean mayusculas
  document.addEventListener("input", function (e) {
    const target = e.target;
    if (target.tagName === "INPUT" && target.type === "text") {
      target.value = target.value.toUpperCase();
    }
  });

  //abrimos modal para registrar la bitacora diaria

  let btn_realizar_bitacora = 0;
  document.body.addEventListener("click", function (event) {
    if (event.target.classList.contains("btn_realizar_bitacora")) {
      btn_realizar_bitacora = event.target.getAttribute("data-idprueba");
      window.location.href = `../../Cliente/interfaces/formulario_registro_bitacora.php?id_prueba=${btn_realizar_bitacora}`;
    }
  });

});