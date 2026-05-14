document.addEventListener("DOMContentLoaded", function () {
//abrimos las modal para verificar la informacion de la persona fisica o moral
 const modalinfopruebaunidademo = new bootstrap.Modal(document.getElementById("modalinfopruebaunidademo"));
 const modalinfopruebaunidademobody = document.getElementById("modalinfopruebaunidademobody");

 let info_unidad_demo = 0;

   document.body.addEventListener("click", function (event) {
     if (event.target.classList.contains("btnmostrarinfodemo")) {
       info_unidad_demo = event.target.getAttribute("data-infodemo");
       $.ajax({
         type: "POST",
         data: { id_info_unidad_demo: info_unidad_demo },
         url: "../../Servidor/solicitudes/pruebas_unidades_demo/formulario_infodemo.php",
         success: function (response) {
           modalinfopruebaunidademobody.innerHTML = response;
           modalinfopruebaunidademo.show();
         }
       });
     }
   });









  //AQUI USAMOS ESTE CODIGO PARA FILTRAR POR TIPO DE SOLICITANTE
  document.querySelectorAll(".opcion-filtro-solicitante").forEach(opcion => {
    opcion.addEventListener("click", function (e) {
      e.preventDefault();
      const filtro = this.getAttribute("data-filtro");

      // Actualiza el texto del botón dropdown
      document.getElementById("dropdownFiltroSolicitante").innerText = "Filtrar: " + this.innerText;

      // Filtra las cards
      document.querySelectorAll(".card-solicitante").forEach(card => {
        if (filtro === "todos" || card.classList.contains("tipo-" + filtro)) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });

      // Filtra las filas de la tabla
      document.querySelectorAll(".fila-solicitante").forEach(row => {
        if (filtro === "todos" || row.classList.contains("tipo-" + filtro)) {
          row.style.display = "table-row";
        } else {
          row.style.display = "none";
        }
      });
    });
  });


});

