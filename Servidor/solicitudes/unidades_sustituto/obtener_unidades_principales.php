<?php

include("../../conexion.php");

$sql = "
SELECT
    u.id_unidad,
    u.placa,
    u.vin,
    ma.nombre_marca,
    mo.nombre_modelo
FROM unidades u
INNER JOIN modelos mo
    ON u.id_modelo = mo.id_modelo
INNER JOIN marcas ma
    ON mo.id_marca = ma.id_marca
WHERE u.id_estatus_unidad = 1
ORDER BY ma.nombre_marca, mo.nombre_modelo
";

$resultado = mysqli_query($conexion, $sql);

$html = '<option value="">Seleccionar</option>';

while($row = mysqli_fetch_assoc($resultado))
{
    $html .= '
        <option value="'.$row['id_unidad'].'">
         '.$row['nombre_marca'].' '.$row['nombre_modelo'].' |   '.$row['placa'].' | '.$row['vin'].' 
        </option>
    ';
}

echo $html;