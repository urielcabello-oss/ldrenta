<?php

function obtenerUnidadesDemo($conexion)
{

    $sql = "SELECT 

                u.id_unidad,
                ma.nombre_marca,
                mo.nombre_modelo,
                u.placa,
                u.vin,
                u.paso_diferencial,
                eu.estatus,
                tu.tipo_unidad,
                s.ubicacion,
                u.ultimo_kilometraje

            FROM unidades u

            INNER JOIN modelos mo
                ON u.id_modelo = mo.id_modelo

            INNER JOIN marcas ma
                ON mo.id_marca = ma.id_marca

            INNER JOIN estatus_unidades eu
                ON u.id_estatus_unidad = eu.id_estatus_unidad

            INNER JOIN tipo_unidad tu
                ON u.id_tipo_unidad = tu.id_tipo_unidad

            INNER JOIN sedes s
                ON u.id_sede = s.id_sede

            ORDER BY u.id_unidad DESC";

    $resultado = $conexion->query($sql);

    $unidades = [];

    while ($fila = $resultado->fetch_assoc()) {

        $unidades[] = $fila;

    }

    return $unidades;

}