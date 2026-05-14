<?php

if (!tienePermiso('roles', 'u')) {

    die(json_encode([
        'status' => false,
        'msg' => 'Sin permisos'
    ]));
}

$idrol = $_POST['idrol'];

$r = $_POST['r'] ?? [];
$w = $_POST['w'] ?? [];
$u = $_POST['u'] ?? [];
$d = $_POST['d'] ?? [];

$sqlDelete = "DELETE FROM permisos WHERE rolid = '$idrol'";

$conexion->query($sqlDelete);

$sqlModulos = "SELECT * FROM modulo WHERE status = 1";
$resultModulos = $conexion->query($sqlModulos);

while ($modulo = mysqli_fetch_assoc($resultModulos)) {

    $idmodulo = $modulo['idmodulo'];

    $read = isset($r[$idmodulo]) ? 1 : 0;
    $write = isset($w[$idmodulo]) ? 1 : 0;
    $update = isset($u[$idmodulo]) ? 1 : 0;
    $delete = isset($d[$idmodulo]) ? 1 : 0;

    $sqlInsert = "INSERT INTO permisos (
                        rolid,
                        moduloid,
                        r,
                        w,
                        u,
                        d
                    ) VALUES (
                        '$idrol',
                        '$idmodulo',
                        '$read',
                        '$write',
                        '$update',
                        '$delete'
                    )";

    $conexion->query($sqlInsert);
}


echo json_encode([
    'status' => true,
    'msg' => 'Permisos actualizados'
]);