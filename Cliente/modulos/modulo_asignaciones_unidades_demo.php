 <!-------------------------------------------aqui comienza el contenedor mis unidades cliente----------------------------------------------------------->
 <div class="container-fluid px-3 px-md-4 mt-4">

     <!-- HEADER -->
     <section class="ldr-page-header">

         <div>
             <span class="ldr-page-badge">
                 GESTIÓN DE UNIDAD
             </span>

             <h1 class="ldr-page-title">
                 Administra los documentos
             </h1>

             <p class="ldr-page-subtitle">
                 Administración de las documentos.
             </p>
         </div>

     </section>

     <!-- CONTENIDO -->
     <section class="ldr-table-card">

         <div class="ldr-table-header">

             <div>
                 <h2>
                     Listado de asignaciones
                 </h2>

                 <p>
                     Consulta y administra todas las asignaciones.
                 </p>
             </div>

         </div>
         <?php include("../../Servidor/componentes/obtener_unidades_utorizadas_demos.php"); ?>
     </section>

 </div>





 <!--js solicitar prorroga de la unidad-->
 <script src="../js/unidades_demo_autorizadas/asignaciones_unidades_demo.js"></script>
 <!--js para subir el comodato firmado para la institucion o persona fisica-->
 <script src="../js/unidades_demo_autorizadas/subir_comodato_demo.js"></script>
 <!--js para verificar los comentarios del area juridica-->
 <script src="../js/unidades_demo_autorizadas/comentarios_juridico_documentos.js"></script>
 <!--js para vizualisar el reporte final de la prueba demo-->
 <script src="../js/reporte_final_prueba_demo/reportes_finales_demos.js"></script>