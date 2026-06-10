<?php

header('Content-Type: application/json');

include("../../conexion.php");

$response = [
    "success" => false
];

try {

    $ubicacion = trim($_POST['ubicacion']);

    if (empty($ubicacion)) {
        throw new Exception("La ubicación es obligatoria");
    }

    // VALIDAR DUPLICADO
    $sqlValidar = "SELECT id_sede
                   FROM sedes
                   WHERE ubicacion = ?";

    $stmt = $conexion->prepare($sqlValidar);
    $stmt->bind_param("s", $ubicacion);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        throw new Exception("La ubicación ya existe");
    }

    // INSERTAR
    $sql = "INSERT INTO ubicaciones(ubicacion_unidad)
            VALUES(?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $ubicacion);

    if (!$stmt->execute()) {
        throw new Exception("Error al registrar ubicación");
    }

    $response["success"] = true;

} catch (Exception $e) {

    $response["message"] = $e->getMessage();

}

echo json_encode($response);