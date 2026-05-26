<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// =====================================================
// CONEXIONES
// =====================================================

include("../../Servidor/conexion.php");
include("../../Servidor/conexionbdrh.php");

// =====================================================
// OBTENER USUARIOS LOCALES
// =====================================================

$sql_local = "
SELECT 
    id_usuario,
    id_colaborador,
    avatar
FROM usuarios
WHERE id_colaborador IS NOT NULL
AND id_colaborador != ''
";

$resultado_local = mysqli_query($conexion, $sql_local);

$actualizados = 0;

// =====================================================
// RECORRER USUARIOS
// =====================================================

while ($usuario = mysqli_fetch_assoc($resultado_local)) {

    $id_usuario = $usuario['id_usuario'];
    $id_colaborador = (int)$usuario['id_colaborador'];
    $avatar_actual = $usuario['avatar'];

    echo "Buscando colaborador: " . $id_colaborador . "<br>";

    // =====================================================
    // BUSCAR AVATAR EN RH
    // =====================================================

    $sql_rh = "
    SELECT avatar
    FROM usuarios
    WHERE id_colaborador = $id_colaborador
    AND avatar IS NOT NULL
    AND avatar != ''
    LIMIT 1
    ";

    $resultado_rh = mysqli_query($conexion_rh, $sql_rh);

    if ($fila_rh = mysqli_fetch_assoc($resultado_rh)) {

        $avatar_nuevo = trim($fila_rh['avatar']);

        echo "Avatar encontrado: " . $avatar_nuevo . "<br>";

        // =====================================================
        // SOLO ACTUALIZAR SI CAMBIÓ
        // =====================================================

        if ($avatar_actual != $avatar_nuevo) {

            $avatar_update = mysqli_real_escape_string(
                $conexion,
                $avatar_nuevo
            );

            $update = "
            UPDATE usuarios
            SET avatar = '$avatar_update'
            WHERE id_usuario = $id_usuario
            ";

            if (mysqli_query($conexion, $update)) {

                $actualizados++;

                echo "Actualizado correctamente<br><hr>";

            } else {

                echo "Error al actualizar: "
                    . mysqli_error($conexion)
                    . "<hr>";

            }

        } else {

            echo "El avatar ya está actualizado<br><hr>";

        }

    } else {

        echo "No se encontró avatar en RH<br><hr>";

    }

}

// =====================================================
// RESULTADO FINAL
// =====================================================

echo "<h3>Avatares actualizados: $actualizados</h3>";

// =====================================================
// CERRAR CONEXIONES
// =====================================================

mysqli_close($conexion);
mysqli_close($conexion_rh);

?>