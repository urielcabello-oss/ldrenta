<?php
//session_start();
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="../img/LDR_LOGO.png" href="../img/LDR_LOGO.png">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Toastify -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Estilos propios -->
  <link rel="stylesheet" href="../css/estilos_v2.css?v=1">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

  <title>Vida Útil Unidades Demos</title>
</head>

<body>

  <?php include("../include/menu.php"); ?>

  <div class="cuadroblancocontenido">
    <!-- AQUÍ se carga el dashboard -->
    <?php include("../modulos/modulo_vida_util_unidades_demo.php"); ?>
  </div>

  <div class="contenedorspinner" id="contenedorspinner">
    <span class="loader"></span>
  </div>

  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Toastify -->
  <script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>

  <!-- SweetAlert -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Scripts propios -->
  <script src="../js/menu.js"></script>
  <script src="../js/alertas/alertas.js"></script>
  <script src="../js/inactividad.js"></script>
</body>
</html>
