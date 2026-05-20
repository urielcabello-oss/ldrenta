<?php

header('Content-Type: application/json');

require("../../conexion.php");

$id_marca = intval($_POST['id_marca']);

$sql = "SELECT *
        FROM modelos
        WHERE id_marca = ?
        ORDER BY nombre_modelo";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $id_marca);

$stmt->execute();

$resultado = $stmt->get_result();

$modelos = [];

while ($fila = $resultado->fetch_assoc()) {
    $modelos[] = $fila;
}

echo json_encode($modelos);
