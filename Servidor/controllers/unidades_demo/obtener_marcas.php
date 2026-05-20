<?php

header('Content-Type: application/json');

require("../../conexion.php");

$sql = "SELECT * FROM marcas ORDER BY nombre_marca";

$resultado = $conexion->query($sql);

$marcas = [];

while ($fila = $resultado->fetch_assoc()) {
    $marcas[] = $fila;
}

echo json_encode($marcas);