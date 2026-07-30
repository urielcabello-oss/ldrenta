<?php

include("../../conexion.php");

header('Content-Type: application/json');

$tipo = $_POST['tipo'];
$id = intval($_POST['id']);
$nombre = trim($_POST['nombre']);

switch($tipo){

    case 'marca':

        $stmt = $conexion->prepare("
            UPDATE marcas
            SET nombre_marca=?
            WHERE id_marca=?
        ");

        break;

    case 'modelo':

        $stmt = $conexion->prepare("
            UPDATE modelos
            SET nombre_modelo=?
            WHERE id_modelo=?
        ");

        break;

    case 'sede':

        $stmt = $conexion->prepare("
            UPDATE sedes
            SET ubicacion=?
            WHERE id_sede=?
        ");

        break;

    case 'ubicacion':

        $stmt = $conexion->prepare("
            UPDATE ubicaciones
            SET ubicacion_unidad=?
            WHERE id_ubicacion=?
        ");

        break;

    default:

        echo json_encode([
            'success'=>false,
            'message'=>'Tipo inválido'
        ]);

        exit;
}

$stmt->bind_param("si",$nombre,$id);

echo json_encode([
    'success'=>$stmt->execute()
]);