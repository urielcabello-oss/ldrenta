<?php

header('Content-Type: application/json');

session_start();

require("../../conexion.php");
require("../../models/AgregarUnidadesNuevasModel.php");

try {

    if (!isset($_SESSION['id_colaborador'])) {

        echo json_encode([
            "status" => "error",
            "message" => "Sesión inválida"
        ]);

        exit;
    }

    $id_creador = $_SESSION['id_colaborador'];

    $respuesta = registrarUnidadDemo(
        $conexion,
        $_POST,
        $_FILES,
        $id_creador
    );

    echo json_encode($respuesta);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);

}