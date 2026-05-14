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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="../img/Logo_LDRenta_OG.png" href="../img/Logo_LDRenta_OG.png">
    <title>LDRenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css?v=<?php echo time(); ?>">
    <!-- CDN para poder utilizar los toastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


</head>

<body>

    <?php include("../include/menu.php"); ?>

    <div class="cuadroblancocontenido ldr-dashboard">

        <!-- HEADER BIENVENIDA -->
        <section class="ldr-welcome-box">
            <div class="ldr-welcome-text">
                <span class="ldr-badge">MÓDULO ADMINISTRACIÓN DE UNIDADES</span>
                <h1>Bienvenido<?php include("../include/bienvenida.php"); ?></h1>
                <p>
                    Administra las asignaciones de unidades a colaboradores internos
                </p>
            </div>

            <div class="ldr-welcome-logo">
                <img src="../img/Logo_LDRenta_OG.png" alt="LDRenta">
            </div>
        </section>

        <!-- ACCESOS RÁPIDOS -->
        <section class="ldr-access-grid">
            <a href="unidades.php" class="ldr-access-card">
                <div class="ldr-access-title">Unidades</div>
                <div class="ldr-access-text">Administracion y altas de unidades</div>
            </a>

            <a href="validacion_unidades_comodato.php" class="ldr-access-card">
                <div class="ldr-access-title">Validación de unidades</div>
                <div class="ldr-access-text">Seguimiento de asignación de unidad al colaborador y verificación de comodatos</div>
            </a>

            <a href="unidades_asignadas.php" class="ldr-access-card">
                <div class="ldr-access-title">Unidades asignadas</div>
                <div class="ldr-access-text">Visualiza unidades asignadas a colaboradores</div>
            </a>

            <a href="unidades_mantenimiento_flotilla.php" class="ldr-access-card">
                <div class="ldr-access-title">Mantenimientos</div>
                <div class="ldr-access-text">Seguimientos a los mantenimientos de las unidades</div>
            </a>
        </section>

        <!-- RESUMEN OPERATIVO -->
        <section class="ldr-content-card">
            <div class="ldr-section-header">
                <h2>Resumen operativo</h2>
                <p>Consulta rápidamente el estado general de unidades.</p>
            </div>

            <div class="ldr-stats-grid">
                <div class="ldr-stat-box">
                    <span class="ldr-stat-number">111</span>
                    <span class="ldr-stat-label">Unidades disponibles</span>
                </div>

                <div class="ldr-stat-box">
                    <span class="ldr-stat-number">3</span>
                    <span class="ldr-stat-label">Comodato</span>
                </div>

                <div class="ldr-stat-box">
                    <span class="ldr-stat-number">35</span>
                    <span class="ldr-stat-label">Asignaciones activas</span>
                </div>

                <div class="ldr-stat-box">
                    <span class="ldr-stat-number">49</span>
                    <span class="ldr-stat-label">Mantenimientos</span>
                </div>
            </div>

            <div class="ldr-info-panel">
                <div class="ldr-info-block">
                    <h4>Flujo del módulo</h4>
                    <p>
                        Gestiona asignaciones y da seguimiento al ciclo completo
                        de préstamo de unidades internas a colaboradores.
                    </p>
                </div>

                <div class="ldr-info-block">
                    <h4>Seguimiento centralizado</h4>
                    <p>
                        Consulta disponibilidad, asignaciones activas y mantenimientos
                        desde la plataforma.
                    </p>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="ldr-footer-minimal">
            <p class="mb-0">© 2026 LDRenta | Plataforma de gestión de unidades</p>
        </footer>

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

    <!-- cieera el body -->
</body>

</html>