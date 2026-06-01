<?php

header('Content-Type: application/json');

include("../../conexion.php");

$response = [
    "success" => false
];

try {

    $marca = trim($_POST['marca']);

    if (empty($marca)) {
        throw new Exception("La marca es obligatoria");
    }

    // VALIDAR DUPLICADO
    $sqlValidar = "SELECT id_marca
                   FROM marcas
                   WHERE nombre_marca = ?";

    $stmt = $conexion->prepare($sqlValidar);
    $stmt->bind_param("s", $marca);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        throw new Exception("La marca ya existe");
    }

    // INSERTAR
    $sql = "INSERT INTO marcas(nombre_marca)
            VALUES(?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $marca);

    if (!$stmt->execute()) {
        throw new Exception("Error al registrar marca");
    }

    $response["success"] = true;

} catch (Exception $e) {

    $response["message"] = $e->getMessage();

}

echo json_encode($response);