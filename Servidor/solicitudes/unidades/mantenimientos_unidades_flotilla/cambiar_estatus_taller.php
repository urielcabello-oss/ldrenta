<?php

header('Content-Type: application/json');

include("../../../conexion.php");

$response = [
    "success" => false
];

$id_taller =
    $_POST['id_taller'];

$sql = "
    UPDATE talleres
    SET estatus =
        IF(estatus = 1, 0, 1)
    WHERE id_taller = ?
";

$stmt =
    $conexion->prepare($sql);

$stmt->bind_param("i", $id_taller);

if($stmt->execute()){

    $response["success"] = true;

}

echo json_encode($response);