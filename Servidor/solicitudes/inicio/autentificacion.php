<?php
include("../../conexion.php");
session_start();

if (isset($_POST['correo']) || isset($_POST['contra'])) {
    $correo = $_POST['correo'];
    $contra = $_POST['contra'];

    $sql = "SELECT u.id_usuario, 
                    u.correo, 
                    u.contraseña,
                    colab.id_colaborador
            FROM usuarios AS u
            INNER JOIN colaboradores AS colab
            ON u.id_colaborador = colab.id_colaborador
            WHERE correo = '$correo' 
            AND contraseña = '$contra'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();

        echo"correcto el inicio de sesion";
        $_SESSION['id_usuario'] = $fila['id_usuario'];
        $_SESSION['id_colaborador'] = $fila['id_colaborador'];    
    }
} else {
    echo "No se recibieron datos";
}

