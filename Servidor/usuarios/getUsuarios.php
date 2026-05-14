<?php

require_once('../conexion.php');

header('Content-Type: application/json');

$sql = "
    SELECT

        u.id_usuario,
        u.status,

        CONCAT(
            c.numero_colaborador,
            ' - ',
            c.nombre_1,
            ' ',
            c.apellido_paterno,
            ' ',
            c.apellido_materno
        ) AS colaborador,

        r.idrol,
        r.nombrerol

    FROM usuarios u

    INNER JOIN colaboradores c
        ON c.id_colaborador = u.id_colaborador

    LEFT JOIN usuario_rol ur
        ON ur.id_usuario = u.id_usuario

    LEFT JOIN roles r
        ON r.idrol = ur.idrol

    ORDER BY u.id_usuario DESC
";

$query = $conexion->query($sql);

if (!$query) {

    echo json_encode([
        "data" => [],
        "error" => $conexion->error
    ]);

    exit;
}

$data = [];

while ($row = $query->fetch_assoc()) {

    $estatus = $row['status'] == 1
        ? '<span class="badge bg-success">Activo</span>'
        : '<span class="badge bg-danger">Inactivo</span>';

    $btnStatus = $row['status'] == 1
        ? '
            <button class="btn btn-sm btn-danger btnStatus"
                    data-id="'.$row['id_usuario'].'"
                    data-status="0">

                <i class="fas fa-ban"></i>

            </button>
        '
        : '
            <button class="btn btn-sm btn-success btnStatus"
                    data-id="'.$row['id_usuario'].'"
                    data-status="1">

                <i class="fas fa-check"></i>

            </button>
        ';

    $acciones = '

        <button class="btn btn-sm btn-warning btnEditar"
                data-id="'.$row['id_usuario'].'"
                data-colaborador="'.$row['colaborador'].'"
                data-idrol="'.$row['idrol'].'">

            <i class="fas fa-edit"></i>

        </button>

        '.$btnStatus.'
    ';

    $data[] = [

        "colaborador" => $row['colaborador'],
        "rol" => $row['nombrerol'],
        "estatus" => $estatus,
        "acciones" => $acciones
    ];
}

echo json_encode([
    "data" => $data
]);