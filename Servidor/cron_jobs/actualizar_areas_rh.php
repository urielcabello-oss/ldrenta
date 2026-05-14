<?php
// Conexión a la base de datos
include("../../Servidor/conexion.php");

// Conexión a la base de datos de RH
include("../../Servidor/conexionbdrh.php");
// Obtener todas las áreas
$resultado = $conexion_rh->query("SELECT id_area, id_direccion, nombre_area FROM areas");

if ($resultado) {
    while ($area = $resultado->fetch_assoc()) {
        // Escapar campos
        foreach ($area as $key => $value) {
            $area[$key] = $conexion->real_escape_string($value);
        }

        $id = $area['id_area'];

        // Validar existencia de la dirección
        $check_direccion = $conexion->query("SELECT 1 FROM direcciones WHERE id_direccion = '{$area['id_direccion']}'");
        if ($check_direccion->num_rows == 0) {
            echo "Omitido: id_direccion {$area['id_direccion']} no existe para área $id\n";
            continue;
        }

        // Verificar si el área ya existe
        $existe = $conexion->query("SELECT id_area FROM areas WHERE id_area = '$id'");

        if ($existe && $existe->num_rows > 0) {
            // UPDATE
            $sql = "UPDATE areas SET 
                        id_direccion = '{$area['id_direccion']}',
                        nombre_area = '{$area['nombre_area']}'
                    WHERE id_area = '$id'";
        } else {
            // INSERT
            $sql = "INSERT INTO areas (
                        id_area, id_direccion, nombre_area
                    ) VALUES (
                        '{$area['id_area']}',
                        '{$area['id_direccion']}',
                        '{$area['nombre_area']}'
                    )";
        }

        if (!$conexion->query($sql)) {
            echo "Error al sincronizar área $id: " . $conexion->error . "\n";
        }
    }

    echo "Sincronización de áreas completada.";
} else {
    echo "Error al obtener áreas desde RH.";
}

$conexion->close();
$conexion_rh->close();
?>
