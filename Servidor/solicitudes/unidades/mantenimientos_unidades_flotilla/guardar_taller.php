<?php

header('Content-Type: application/json');

include("../../../conexion.php");

$response = [
    "success" => false
];

try{

    $id_taller =
        $_POST['id_taller'] ?? '';

    $nombre_taller =
        trim($_POST['nombre_taller']);

    $direccion =
        trim($_POST['direccion']);

    $telefono =
        trim($_POST['telefono']);

    $contacto =
        trim($_POST['contacto']);

    if($id_taller == ""){

        $sql = "
            INSERT INTO talleres
            (
                nombre_taller,
                direccion,
                telefono,
                contacto
            )
            VALUES
            (?,?,?,?)
        ";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param(
            "ssss",
            $nombre_taller,
            $direccion,
            $telefono,
            $contacto
        );

    }else{

        $sql = "
            UPDATE talleres
            SET
                nombre_taller = ?,
                direccion = ?,
                telefono = ?,
                contacto = ?
            WHERE id_taller = ?
        ";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param(
            "ssssi",
            $nombre_taller,
            $direccion,
            $telefono,
            $contacto,
            $id_taller
        );

    }

    $stmt->execute();

    $response["success"] = true;

}catch(Exception $e){

    $response["message"] =
        $e->getMessage();

}

echo json_encode($response);