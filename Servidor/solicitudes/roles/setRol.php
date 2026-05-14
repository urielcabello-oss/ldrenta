<?php

include("../../conexion.php");
session_start();

require_once('../helpers/permisos.php');

if (!tienePermiso('roles', 'w')) {

    die(json_encode([
        'status' => false,
        'msg' => 'Sin permisos'
    ]));
}

$nombre = $_POST['nombrerol'];
$descripcion = $_POST['descripcion'];

$sql = "INSERT INTO roles (
            nombrerol,
            descripcion,
            status
        ) VALUES (
            '$nombre',
            '$descripcion',
            1
        )";

$query = $conexion->query($sql);

if ($query) {

    echo json_encode([
        'status' => true,
        'msg' => 'Rol registrado'
    ]);
} else {

    echo json_encode([
        'status' => false,
        'msg' => 'Error al registrar'
    ]);
}
