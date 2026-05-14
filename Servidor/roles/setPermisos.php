<?php

require_once('../conexion.php');

$idrol = $_POST['idrol'];
$permisos = $_POST['permisos'];

foreach($permisos as $permiso){

    $idmodulo = $permiso['idmodulo'];

    $r = $permiso['r'];
    $w = $permiso['w'];
    $u = $permiso['u'];
    $d = $permiso['d'];

    $sqlExiste = "
        SELECT idpermiso
        FROM permisos
        WHERE rolid = '$idrol'
        AND moduloid = '$idmodulo'
        LIMIT 1
    ";

    $queryExiste = $conexion->query($sqlExiste);

    if($queryExiste->num_rows > 0){

        $sql = "
            UPDATE permisos
            SET
                r = '$r',
                w = '$w',
                u = '$u',
                d = '$d'
            WHERE rolid = '$idrol'
            AND moduloid = '$idmodulo'
        ";

    }else{

        $sql = "
            INSERT INTO permisos(
                rolid,
                moduloid,
                r,
                w,
                u,
                d
            ) VALUES (
                '$idrol',
                '$idmodulo',
                '$r',
                '$w',
                '$u',
                '$d'
            )
        ";
    }

    $conexion->query($sql);
}

echo json_encode([
    'status' => true,
    'msg' => 'Permisos actualizados'
]);