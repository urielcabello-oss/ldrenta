<?php
// Mostrar errores para depuración (quítalo en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a tu base de datos local
include("../../Servidor/conexion.php");

// Conexión a la base de datos RH
include("../../Servidor/conexionbdrh.php");

// Obtener todos los usuarios de tu sistema
$sql_local = "SELECT id_usuario, correo FROM usuarios";
$resultado_local = mysqli_query($conexion, $sql_local);

$actualizados = 0;

while ($usuario = mysqli_fetch_assoc($resultado_local)) {
    $id_usuario = $usuario['id_usuario'];
    $correo = mysqli_real_escape_string($conexion_rh, $usuario['correo']);

    // Buscar avatar en la base de datos RH
    $sql_rh = "SELECT avatar FROM usuarios WHERE correo = '$correo' AND avatar IS NOT NULL AND avatar != '' LIMIT 1";
    $resultado_rh = mysqli_query($conexion_rh, $sql_rh);

    if ($fila_rh = mysqli_fetch_assoc($resultado_rh)) {
        $avatar = mysqli_real_escape_string($conexion, $fila_rh['avatar']);

        // Actualizar el campo avatar en tu base de datos local
        $update = "UPDATE usuarios SET avatar = '$avatar' WHERE id_usuario = $id_usuario";
        mysqli_query($conexion, $update);

        $actualizados++;
    }
}

echo "Avatares actualizados: $actualizados";

// Cerrar conexiones
mysqli_close($conexion);
mysqli_close($conexion_rh);
?>
<?php
$url_avatar = "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $avatar;
echo "<img src='$url_avatar' alt='Avatar' width='80' height='80' style='border-radius: 50%;'>";
?>
