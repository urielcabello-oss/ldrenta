<?php
include("../../Servidor/conexion.php");

//obtenemos el id del colaborador para saber quien es el que esta logeado
if (!isset($_SESSION)) {
    session_start();
}

// Verificar que la sesión tenga los datos necesarios
if (!isset($_SESSION['id_colaborador']) || !isset($_SESSION['id_tipo_usuario'])) {
    echo "Sesión inválida";
    exit;
}

$colaborador = $_SESSION['id_colaborador'];
$id_tipo_usuario = $_SESSION['id_tipo_usuario'];

?>

<!-------------------------------------------aqui comienza el contenedor Autorizacion de unidades demos por parte del usuario tipo 7 ----------------------------------------------------------->

<!--iframe del tablero de smart conect-->
<div class="contenedortablerosmartconect">
    <div class="iframe-container">
    <iframe 
        src="https://dashboards.telematicsadvance.com.mx/foton-demos/"
        frameborder="0"
        allowfullscreen
    ></iframe>
</div>

</div>


