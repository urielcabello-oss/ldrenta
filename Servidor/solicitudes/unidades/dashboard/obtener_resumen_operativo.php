<?php

header('Content-Type: application/json');

include '../../../conexion.php';

$response = [
    "success" => false
];

try {

    function obtenerTotal($conexion, $sql)
    {
        $res = $conexion->query($sql);

        if ($res && $row = $res->fetch_assoc()) {
            return intval($row['total']);
        }

        return 0;
    }

    $response["success"] = true;

    $totalUnidades = obtenerTotal(
        $conexion,
        "SELECT COUNT(*) total FROM unidades"
    );

    $disponibles = obtenerTotal(
        $conexion,
        "SELECT COUNT(*) total
     FROM unidades
     WHERE id_estado_unidad = 1"
    );

    $enUso = $totalUnidades - $disponibles;

    $response["data"] = [

        "total_unidades" => $totalUnidades,

        "disponibles" => $disponibles,

        "en_uso" => $enUso,

        "rentadas" => obtenerTotal(
            $conexion,
            "SELECT COUNT(*) total
         FROM unidades
         WHERE id_estado_unidad = 3"
        ),

        "mantenimiento" => obtenerTotal(
            $conexion,
            "SELECT COUNT(DISTINCT mf.id_unidad) total
         FROM mantenimientos_flotilla mf
         INNER JOIN estatus_mantenimiento em
            ON mf.id_estatus_mantenimiento = em.id_estatus_mantenimiento
         WHERE em.estatus <> 'Finalizado'"
        ),

        "corralon" => obtenerTotal(
            $conexion,
            "SELECT COUNT(*) total
             FROM unidades
             WHERE id_estado_unidad = 8"
        ),

        "siniestradas" => obtenerTotal(
            $conexion,
            "SELECT COUNT(*) total
             FROM unidades
             WHERE id_estado_unidad = 5"
        ),

        "contratos" => obtenerTotal(
            $conexion,
            "SELECT COUNT(*) total
             FROM asignacion_unidad_demo
             WHERE archivo_comodato_firmado IS NOT NULL
             AND archivo_comodato_firmado <> ''"
        ),

        "asignaciones" => obtenerTotal(
            $conexion,
            "SELECT COUNT(*) total
             FROM asignacion_unidad_demo
             WHERE estado = 1"
        ),

        "mantenimientos" => obtenerTotal(
            $conexion,
            "SELECT COUNT(*) total
             FROM mantenimientos_flotilla"
        )

    ];
} catch (Exception $e) {

    $response["message"] = $e->getMessage();
}

echo json_encode($response);
