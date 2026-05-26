<?php

require_once('../conexion.php');

$term = trim($_POST['term'] ?? '');

if ($term === '') {

    echo json_encode([]);
    exit;
}

$sql = "
    SELECT
        id_colaborador,

        CONCAT_WS(
            ' ',
            CONCAT(numero_colaborador, ' -'),
            nombre_1,
            NULLIF(nombre_2, ''),
            apellido_paterno,
            NULLIF(apellido_materno, '')
        ) AS nombre

    FROM colaboradores

    WHERE CONCAT_WS(
            ' ',
            numero_colaborador,
            nombre_1,
            NULLIF(nombre_2, ''),
            apellido_paterno,
            NULLIF(apellido_materno, '')
        ) LIKE ?

    LIMIT 10
";

$stmt = $conexion->prepare($sql);

$buscar = "%{$term}%";

$stmt->bind_param("s", $buscar);

$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){

    $data[] = $row;
}

echo json_encode($data);