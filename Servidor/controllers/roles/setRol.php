<?php

require_once('../conexion.php');
require_once('../models/RolesModel.php');

header('Content-Type: application/json');

$model = new RolesModel($conexion);

$idrol = $_POST['idrol'] ?? '';
$nombrerol = $_POST['nombrerol'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';

if(empty($idrol)){

    echo json_encode(
        $model->insertarRol(
            $nombrerol,
            $descripcion
        )
    );

    exit;
}

echo json_encode(
    $model->actualizarRol(
        $idrol,
        $nombrerol,
        $descripcion
    )
);