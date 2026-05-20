<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔥 DEBUG (solo cuando lo necesites)
# var_dump($_SESSION);
// exit;

// 🔐 Asegurar tipo usuario
if (!isset($_SESSION['id_tipo_usuario']) || $_SESSION['id_tipo_usuario'] == '' || $_SESSION['id_tipo_usuario'] == null) {
    $_SESSION['id_tipo_usuario'] = 3;
}

// Solo flotilla
$tipoUsuario = intval($_SESSION['id_tipo_usuario']);

if (!in_array($tipoUsuario, [1, 2, 3, 15])) {
    echo "<h3 style='text-align:center;margin-top:50px;'>No tienes permiso para acceder a Flotilla</h3>";
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>



<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="../img/LDR_LOGO.png" href="../img/LDR_LOGO.png">
    <title>Flotilla</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css?v=<?php echo time(); ?>">
    <!-- CDN para poder utilizar los toastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


</head>

<body >
    <!-- Video de fondo -->
    <video autoplay muted loop playsinline poster="../videos/Video_fotograma.png" id="background-video">
        <source src="../videos/videoLogo.mp4" type="video/mp4">
    </video>
<?php
    include("../include/menu.php");
    ?>
    <div class="cuadroblancocontenidoinicio">

    
    
    <!-- INICIO BLOQUE PARA EL CUERPO -->
        <?php include("../modulos/modulo_inicio.php"); ?>
        

    </div>
    
    <!--jquery-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <!-- Incluir el script de Toastify después de sus CSS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>
    <!-- CDN para poder utilizar las Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- CDN para poder utilizar las Sweet Alert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--MENU-->
    <script src="../js/menu.js"></script>
    <!--alertas de js-->
    <script src="../js/alertas/alertas.js"></script>
    <!--inactividad y cerrar la sesion-->
    <script src="../js/inactividad.js"></script>
</body>

</html>