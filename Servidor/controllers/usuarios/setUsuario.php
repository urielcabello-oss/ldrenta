<?php

require_once('../conexion.php');
require_once('../helpers/permisos.php');
require_once('../models/UsuariosModel.php');

header('Content-Type: application/json');

if (!tienePermiso('USUARIOS', 'w')) {

    echo json_encode([
        'status' => false,
        'msg' => 'Sin permisos'
    ]);

    exit;
}

$model = new UsuariosModel($conexion);

// ==========================================
// VARIABLES
// ==========================================

$idusuario = $_POST['idusuario'] ?? '';
$id_colaborador = $_POST['id_colaborador'] ?? '';
$idrol = $_POST['idrol'] ?? '';

// ==========================================
// INSERTAR
// ==========================================

if (empty($idusuario)) {

    $response = $model->insertarUsuario(
        $id_colaborador,
        $idrol
    );

    echo json_encode($response);
    exit;
}

// ==========================================
// ACTUALIZAR
// ==========================================

$response = $model->actualizarUsuario(
    $idusuario,
    $idrol
);

echo json_encode($response);