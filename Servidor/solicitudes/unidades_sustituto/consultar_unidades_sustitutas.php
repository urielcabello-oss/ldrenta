<?php

include("../../conexion.php");

$id_unidad = $_POST['id_unidad'];

$sql = "
SELECT
    u.id_unidad,
    u.placa,
    u.vin,
    ma.nombre_marca,
    mo.nombre_modelo,
    s.ubicacion,

    us_actual.id_unidad_sustituto,

    us_otra.id_unidad AS asignada_a

FROM unidades u

INNER JOIN modelos mo
    ON u.id_modelo = mo.id_modelo

INNER JOIN marcas ma
    ON mo.id_marca = ma.id_marca

INNER JOIN sedes s
    ON u.id_sede = s.id_sede

LEFT JOIN unidades_sustituto us_actual
    ON us_actual.id_unidad_sustituta = u.id_unidad
    AND us_actual.id_unidad = '$id_unidad'
    AND us_actual.estado = 1

LEFT JOIN unidades_sustituto us_otra
    ON us_otra.id_unidad_sustituta = u.id_unidad
    AND us_otra.id_unidad <> '$id_unidad'
    AND us_otra.estado = 1

WHERE u.id_unidad <> '$id_unidad'
AND u.id_estatus_unidad = 1

ORDER BY ma.nombre_marca, mo.nombre_modelo
";

$resultado = mysqli_query($conexion, $sql);

$html = "";

while ($row = mysqli_fetch_assoc($resultado)) {
    $checked = "";
    $disabled = "";

    if (!empty($row['id_unidad_sustituto'])) {
        $checked = "checked";
    }

    if (!empty($row['asignada_a'])) {
        $disabled = "disabled";
    }

    $html .= '
        <tr>

            <td>

                <input
    type="checkbox"
    class="unidad-sustituta"
    value="' . $row['id_unidad'] . '"
    ' . $checked . '
    ' . $disabled . '>

            </td>

            <td>
                ' . $row['nombre_marca'] . ' ' . $row['nombre_modelo'] . '
            </td>

            <td>
                ' . $row['placa'] . '
            </td>

            <td>
                ' . $row['vin'] . '
            </td>

            <td>
                ' . $row['ubicacion'] . '
            </td>


        </tr>
    ';
}

echo $html;
