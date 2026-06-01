<?php

header('Content-Type: application/json');

include("../../conexion.php");

$response = [
    "success" => false
];

try {

    $sede = trim($_POST['sede']);

    if (empty($sede)) {
        throw new Exception("La sede es obligatoria");
    }

    // VALIDAR DUPLICADO
    $sqlValidar = "SELECT id_sede
                   FROM sedes
                   WHERE ubicacion = ?";

    $stmt = $conexion->prepare($sqlValidar);
    $stmt->bind_param("s", $sede);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        throw new Exception("La sede ya existe");
    }

    // INSERTAR
    $sql = "INSERT INTO sedes(ubicacion)
            VALUES(?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $sede);

    if (!$stmt->execute()) {
        throw new Exception("Error al registrar sede");
    }

    $response["success"] = true;

} catch (Exception $e) {

    $response["message"] = $e->getMessage();

}

echo json_encode($response);