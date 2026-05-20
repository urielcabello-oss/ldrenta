<?php

header('Content-Type: application/json');

require("../../conexion.php");

$id_unidad = intval($_POST['id_unidad']);

$sql = "SELECT 

            u.*,
            mo.id_modelo,
            mo.nombre_modelo,
            ma.id_marca,
            ma.nombre_marca

        FROM unidades u

        INNER JOIN modelos mo
            ON u.id_modelo = mo.id_modelo

        INNER JOIN marcas ma
            ON mo.id_marca = ma.id_marca

        WHERE u.id_unidad = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $id_unidad);

$stmt->execute();

$resultado = $stmt->get_result();

$fila = $resultado->fetch_assoc();

echo json_encode($fila);