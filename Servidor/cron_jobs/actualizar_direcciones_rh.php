<?php
// Conexión a la base de datos
include("../../Servidor/conexion.php");

// Conexión a la base de datos de RH
include("../../Servidor/conexionbdrh.php");

// Obtener todas las direcciones del sistema RH
$resultado = $conexion_rh->query("SELECT id_direccion, id_empresa, id_colaborador, nombre_direccion FROM direcciones");

if ($resultado) {
    while ($dir = $resultado->fetch_assoc()) {
        // Escapar los campos
        foreach ($dir as $key => $value) {
            $dir[$key] = $conexion->real_escape_string($value);
        }

        $id = $dir['id_direccion'];

        // Validar existencia de empresa
        $check_empresa = $conexion->query("SELECT 1 FROM empresas WHERE id_empresa = '{$dir['id_empresa']}'");
        if ($check_empresa->num_rows == 0) {
            echo "Omitido: Empresa {$dir['id_empresa']} no existe para dirección $id\n";
            continue;
        }

        // (Opcional) Validar existencia de colaborador si no es nulo
        if (!empty($dir['id_colaborador'])) {
            $check_colab = $conexion->query("SELECT 1 FROM colaboradores WHERE id_colaborador = '{$dir['id_colaborador']}'");
            if ($check_colab->num_rows == 0) {
                echo "Omitido: Colaborador {$dir['id_colaborador']} no existe para dirección $id\n";
                continue;
            }
        }

        // Verificar si ya existe
        $existe = $conexion->query("SELECT id_direccion FROM direcciones WHERE id_direccion = '$id'");

        if ($existe && $existe->num_rows > 0) {
            // UPDATE
            $sql = "UPDATE direcciones SET 
                        id_empresa = '{$dir['id_empresa']}', 
                        id_colaborador = '{$dir['id_colaborador']}', 
                        nombre_direccion = '{$dir['nombre_direccion']}'
                    WHERE id_direccion = '$id'";
        } else {
            // INSERT
            $sql = "INSERT INTO direcciones (
                        id_direccion, id_empresa, id_colaborador, nombre_direccion
                    ) VALUES (
                        '{$dir['id_direccion']}', 
                        '{$dir['id_empresa']}', 
                        '{$dir['id_colaborador']}', 
                        '{$dir['nombre_direccion']}'
                    )";
        }

        if (!$conexion->query($sql)) {
            echo "Error al sincronizar dirección $id: " . $conexion->error . "\n";
        }
    }

    echo "Sincronización de direcciones completada.";
} else {
    echo "Error al obtener datos de direcciones desde RH.";
}

$conexion->close();
$conexion_rh->close();
?>
