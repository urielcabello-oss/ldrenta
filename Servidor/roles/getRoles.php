<?php

require_once('../conexion.php');

$sql = "
    SELECT *
    FROM roles
    ORDER BY idrol DESC
";

$query = $conexion->query($sql);

$data = [];

while($row = $query->fetch_assoc()){

    $estatus = $row['status'] == 1
        ? '<span class="badge bg-success">Activo</span>'
        : '<span class="badge bg-danger">Inactivo</span>';

    $acciones = '
        <button class="btn btn-sm btn-info btnPermisos"
                data-id="'.$row['idrol'].'">

            <i class="fas fa-key"></i>

        </button>

        <button class="btn btn-sm btn-warning btnEditar"
                data-id="'.$row['idrol'].'"
                data-rol="'.$row['nombrerol'].'"
                data-descripcion="'.$row['descripcion'].'">

            <i class="fas fa-edit"></i>

        </button>
    ';

    $data[] = [

        'idrol' => $row['idrol'],
        'nombrerol' => $row['nombrerol'],
        'descripcion' => $row['descripcion'],
        'estatus' => $estatus,
        'acciones' => $acciones
    ];
}

echo json_encode([
    "data" => $data
]);