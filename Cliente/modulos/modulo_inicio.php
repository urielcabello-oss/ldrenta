<?php
include("../../Servidor/conexion.php");

//obtenemos el id del colaborador para saber quien es el que esta logeado
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['id_tipo_usuario']) || !isset($_SESSION['id_modulo'])) {
  echo "Sesión inválida";
  exit;
}

$id_tipo_usuario = $_SESSION['id_tipo_usuario'];
$id_modulo = $_SESSION['id_modulo'];
?>

<!--Aqui comienza el contenedor del inicio.php-->

<?php if ($id_modulo == 2) { // DEMOS 
?>

  <div class="hero-demos">
    <!-- Imagenes flotantes -->
    <img src="../img/unidades/Foton_GTL_EV.png" class="float-img img-top">
    <img src="../img/unidades/Foton_Hi_Van.png" class="float-img img-left">
    <img src="../img/unidades/Foton_Galaxy.png" class="float-img img-right">
    <img src="../img/unidades/Foton_GTL_EV.png" class="float-img img-bottom-left">
    <img src="../img/unidades/Foton_Hi_Van.png" class="float-img img-bottom-right">

    <div class="hero-center">
      <h1>Plataforma DEMOS</h1>
      <p>Gestión de préstamos, pruebas y monitoreo de unidades</p>

      <h2 class="text-center">Bienvenido<?php
                                        include("../include/bienvenida.php");
                                        ?></h2>
    </div>
  </div>

<?php } else { // FLOTILLA 
?>

  <div class="hero-flotilla">
    <div class="container">
      <div class="hero-flotilla-inner">

        <!-- CARD -->
        <div class="flotilla-card">
          <h2>FLOTILLA LDR</h2>
          <h3 class="text-center">Bienvenido <?php include("../include/bienvenida.php"); ?></h3>
        </div>

        <!-- AUTOS -->
        <div class="flotilla-autos">
          <img src="../img/unidades/JETOUR_360_x70_azul.png" class="flotilla_auto_1">
          <img src="../img/unidades/JETOUR_360_dashing_rojo.png" class="flotilla_auto_2">
        </div>

      </div>
    </div>
  </div>




<?php } ?>



<!--jquery-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!--toastify-->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<!-- Incluir el script de Toastify después de sus CSS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>
<!--bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!--javascript personal-->