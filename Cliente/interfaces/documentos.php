<?php
//session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="../img/LDR_LOGO.png" href="../img/LDR_LOGO.png">
    <!--estilos de boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CDN para poder utilizar los toastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!--estilos de FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--estIlos de interfaz-->
    <link rel="stylesheet" href="../css/estilos.css?v=1">
    <!--cdn para icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"
        integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Documentos</title>

</head>

<body>
    <?php
    include("../include/menu.php");
    ?>

    <div class="cuadroblancocontenido">
        <div class="contenedoropcionesunidades">
            <h2 class="titulosletrasunidades text-nowrap">Registro de documentos para asignaciones de unidades</h2>
            <div class="contenedoropciones">
                <div class="cuadrocontenedoropcionesinicio rowcrg">
                    <a href="../interfaces/licencias_conducir.php" class="contenedoropcioninicio rowcrg text-decoration-no" id="iniciocontenedorrh">
                        <img class="contenedoropcioninicioimagen" src="../img/iconos/licencia_conducir.png" alt="" id="iniciocontenedorrh">
                        <h5 class="titulocontenedoropcioninicio w-100">Licencias de conducir</h5>
                    </a>
                    <a href="../interfaces/comprobante_domicilio.php" class="contenedoropcioninicio rowcrg text-decoration-no" id="iniciocontenedorrh">
                        <img class="contenedoropcioninicioimagen" src="../img/iconos/documento.png" alt="" id="iniciocontenedorrh">
                        <h5 class="titulocontenedoropcioninicio w-100">Comprobante de domicilio</h5>
                    </a>
                    <a href="../interfaces/ine.php" class="contenedoropcioninicio rowcrg text-decoration-no" id="iniciocontenedorrh">
                        <img class="contenedoropcioninicioimagen" src="../img/iconos/ine.png" alt="" id="iniciocontenedorrh">
                        <h5 class="titulocontenedoropcioninicio w-100">INE</h5>
                    </a>
                    <a href="../interfaces/constancia_situacion_fiscal.php" class="contenedoropcioninicio rowcrg text-decoration-no" id="iniciocontenedorrh">
                        <img class="contenedoropcioninicioimagen" src="../img/iconos/constancia.png" alt="" id="iniciocontenedorrh">
                        <h5 class="titulocontenedoropcioninicio w-100">Constancia de situación fiscal</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="contenedorspinner" id="contenedorspinner">
        <span class="loader"></span>
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