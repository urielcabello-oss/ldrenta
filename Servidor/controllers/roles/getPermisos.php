<?php

require_once('../conexion.php');

$idrol = $_POST['idrol'];

$sql = "
    SELECT

        m.idmodulo,
        m.titulo,

        IFNULL(p.r,0) AS r,
        IFNULL(p.w,0) AS w,
        IFNULL(p.u,0) AS u,
        IFNULL(p.d,0) AS d

    FROM modulo m

    LEFT JOIN permisos p
        ON p.moduloid = m.idmodulo
        AND p.rolid = '$idrol'

    WHERE m.status = 1
";

$query = $conexion->query($sql);

$data = [];

while($row = $query->fetch_assoc()){

    $data[] = $row;
}

echo json_encode($data);