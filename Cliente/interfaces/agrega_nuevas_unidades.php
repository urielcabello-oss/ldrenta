<?php
include("../../Servidor/conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

// Validar que la sesión tenga la información necesaria
if (!isset($_SESSION['id_colaborador']) || !isset($_SESSION['id_tipo_usuario'])) {
    echo "Sesión inválida";
    exit;
}

$colaborador = $_SESSION['id_colaborador'];
$id_tipo_usuario = $_SESSION['id_tipo_usuario'];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="../img/LDR_LOGO.png" href="../img/LDR_LOGO.png">
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
        // Cargar módulo según tipo de usuario
        if ($id_tipo_usuario == 1) {
            include("../modulos/modulo_agregar_unidadesnuevas.php");
        } else if ($id_tipo_usuario == 4 || $id_tipo_usuario == 15) {
            include("../modulos/modulo_agregar_unidedesnuevas_demo.php");
        }
        ?>
    </main>
    

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
</body>
</html>
