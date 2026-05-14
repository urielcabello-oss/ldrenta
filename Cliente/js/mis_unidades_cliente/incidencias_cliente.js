document.addEventListener("DOMContentLoaded", function () {
//abrimos las modal para verificar la informacion de la persona fisica o moral
 const modalinfopruebaunidademo = new bootstrap.Modal(document.getElementById("modalinfopruebaunidademo"));
 const modalinfopruebaunidademobody = document.getElementById("modalinfopruebaunidademobody");

   document.body.addEventListener("click", function (event) {
     if (event.target.classList.contains("btn-incidencia")) {
       $.ajax({
         type: "POST",
         data: { id_info_unidad_demo: info_unidad_demo },
         url: "#",
         success: function (response) {
           modalinfopruebaunidademobody.innerHTML = response;
           modalinfopruebaunidademo.show();
         }
       });
     }
   });





});

