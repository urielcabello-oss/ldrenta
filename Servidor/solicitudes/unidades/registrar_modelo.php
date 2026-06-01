<?php

header('Content-Type: application/json');

include("../../conexion.php");

$response = [
    "success" => false
];

try {

    $marca = $_POST['marca'];
    $modelo = trim($_POST['modelo']);
    $km = $_POST['km'];

    if (empty($marca) || empty($modelo)) {
        throw new Exception("Todos los campos son obligatorios");
    }

    // VALIDAR DUPLICADO
    $sqlValidar = "SELECT id_modelo
                   FROM modelos
                   WHERE id_marca = ?
                   AND nombre_modelo = ?";

    $stmt = $conexion->prepare($sqlValidar);
    $stmt->bind_param("is", $marca, $modelo);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        throw new Exception("El modelo ya existe para esta marca");
    }

    // INSERTAR
    $sql = "INSERT INTO modelos(
                id_marca,
                nombre_modelo,
                km_mantenimiento
            )
            VALUES(?,?,?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "isd",
        $marca,
        $modelo,
        $km
    );

    if (!$stmt->execute()) {
        throw new Exception("Error al registrar modelo");
    }

    $response["success"] = true;

} catch (Exception $e) {

    $response["message"] = $e->getMessage();

}

echo json_encode($response);