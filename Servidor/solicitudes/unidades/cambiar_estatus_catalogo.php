<?php

include("../../conexion.php");

header('Content-Type: application/json');

$tipo = $_POST['tipo'] ?? '';
$id = intval($_POST['id'] ?? 0);
$estatus = intval($_POST['estatus'] ?? 0);

switch($tipo){

    case 'marca':

        $stmt = $conexion->prepare("
            UPDATE marcas
            SET activo = ?
            WHERE id_marca = ?
        ");

    break;

    case 'modelo':

        $stmt = $conexion->prepare("
            UPDATE modelos
            SET activo = ?
            WHERE id_modelo = ?
        ");

    break;

    case 'sede':

        $stmt = $conexion->prepare("
            UPDATE sedes
            SET activo = ?
            WHERE id_sede = ?
        ");

    break;

    case 'ubicacion':

        $stmt = $conexion->prepare("
            UPDATE ubicaciones
            SET activo = ?
            WHERE id_ubicacion = ?
        ");

    break;

    default:

        echo json_encode([
            'success' => false,
            'message' => 'Tipo inválido'
        ]);
        exit;
}

$stmt->bind_param("ii", $estatus, $id);

echo json_encode([
    'success' => $stmt->execute()
]);