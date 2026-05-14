<?php
// Conexión a la base de datos
include("../../Servidor/conexion.php");

// Conexión a la base de datos de RH
include("../../Servidor/conexionbdrh.php");

// Obtener todos los puestos
$resultado = $conexion_rh->query("SELECT id_puesto, id_area, nombre_puesto FROM puestos");

if ($resultado) {
    while ($puesto = $resultado->fetch_assoc()) {
        // Escapar campos
        foreach ($puesto as $key => $value) {
            $puesto[$key] = $conexion->real_escape_string($value);
        }

        $id = $puesto['id_puesto'];

        // Validar existencia del área
        $check_area = $conexion->query("SELECT 1 FROM areas WHERE id_area = '{$puesto['id_area']}'");
        if ($check_area->num_rows == 0) {
            echo "Omitido: id_area {$puesto['id_area']} no existe para puesto $id\n";
            continue;
        }

        // Verificar si el puesto ya existe
        $existe = $conexion->query("SELECT id_puesto FROM puestos WHERE id_puesto = '$id'");

        if ($existe && $existe->num_rows > 0) {
            // UPDATE
            $sql = "UPDATE puestos SET 
                        id_area = '{$puesto['id_area']}',
                        nombre_puesto = '{$puesto['nombre_puesto']}'
                    WHERE id_puesto = '$id'";
        } else {
            // INSERT
            $sql = "INSERT INTO puestos (
                        id_puesto, id_area, nombre_puesto
                    ) VALUES (
                        '{$puesto['id_puesto']}',
                        '{$puesto['id_area']}',
                        '{$puesto['nombre_puesto']}'
                    )";
        }

        if (!$conexion->query($sql)) {
            echo "Error al sincronizar puesto $id: " . $conexion->error . "\n";
        }
    }

    echo "Sincronización de puestos completada.";
} else {
    echo "Error al obtener puestos desde RH.";
}

$conexion->close();
$conexion_rh->close();
?>
