<?php
include("../../Servidor/conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="../img/Logo_LDRenta_OG.png" href="../img/Logo_LDRenta_OG.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/estilos.css?v=1">
    <title>Agregar nuevas unidades</title>
</head>

<body>
    <?php include("../include/menu.php"); ?>
    
<main class="main-content">
        <?php
            include("../modulos/modulo_agregar_unidedesnuevas_demo.php");
        ?>
    </main>
    
    <?php
            include("../ui/modales_agregar_unidedesnuevas_demo.php");
        ?>

    <div class="contenedorspinner" id="contenedorspinner">
        <span class="loader"></span>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/alertas/alertas.js"></script>
    <script src="../js/inactividad.js"></script>
    <script src="../js/unidades/agregar_nuevas_unidades_demos.js"></script>
</body>
</html>
