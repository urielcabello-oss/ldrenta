<?php
// Conexión a la base de datos
include("../../Servidor/conexion.php");

// Conexión a la base de datos de RH
include("../../Servidor/conexionbdrh.php");

// Obtener todas las empresas del sistema RH
$resultado = $conexion_rh->query("SELECT id_empresa, nombre_empresa, dominio_correo FROM empresas");

if ($resultado) {
    while ($emp = $resultado->fetch_assoc()) {
        // Escapar campos
        foreach ($emp as $key => $value) {
            $emp[$key] = $conexion->real_escape_string($value);
        }

        $id = $emp['id_empresa'];

        // Verificar si ya existe en la base local
        $existe = $conexion->query("SELECT id_empresa FROM empresas WHERE id_empresa = '$id'");

        if ($existe && $existe->num_rows > 0) {
            // UPDATE
            $sql = "UPDATE empresas SET 
                        nombre_empresa = '{$emp['nombre_empresa']}', 
                        dominio_correo = '{$emp['dominio_correo']}'
                    WHERE id_empresa = '$id'";
        } else {
            // INSERT
            $sql = "INSERT INTO empresas (id_empresa, nombre_empresa, dominio_correo) VALUES (
                        '{$emp['id_empresa']}', 
                        '{$emp['nombre_empresa']}', 
                        '{$emp['dominio_correo']}'
                    )";
        }

        if (!$conexion->query($sql)) {
            echo "Error al sincronizar empresa $id: " . $conexion->error . "\n";
        }
    }

    echo "Sincronización de empresas completada.";
} else {
    echo "Error al obtener datos de empresas desde RH.";
}

$conexion->close();
$conexion_rh->close();
?>
