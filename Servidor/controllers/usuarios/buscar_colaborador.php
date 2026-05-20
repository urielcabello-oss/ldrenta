<?php

require_once('../conexion.php');

$term = $_POST['term'] ?? '';

$sql = "
    SELECT

        id_colaborador,

        CONCAT(
            numero_colaborador,
            ' - ',
            nombre_1,
            ' ',
            apellido_paterno,
            ' ',
            apellido_materno
        ) AS nombre

    FROM colaboradores

    WHERE (
        nombre_1 LIKE '%$term%'
        OR apellido_paterno LIKE '%$term%'
        OR numero_colaborador LIKE '%$term%'
    )

    LIMIT 10
";

$query = $conexion->query($sql);

$data = [];

while($row = $query->fetch_assoc()){

    $data[] = $row;
}

echo json_encode($data);