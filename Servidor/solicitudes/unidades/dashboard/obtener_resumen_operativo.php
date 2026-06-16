<?php

header('Content-Type: application/json');
include '../../../conexion.php';

$response = ["success" => false];

try {

    function obtenerTotal($conexion, $sql) {
        $res = $conexion->query($sql);
        if ($res && $row = $res->fetch_assoc()) {
            return intval($row['total']);
        }
        return 0;
    }

    $totalUnidades = obtenerTotal($conexion, "SELECT COUNT(*) total FROM unidades");

    $disponibles = obtenerTotal($conexion,
        "SELECT COUNT(*) total FROM unidades WHERE id_estado_unidad = 1"
    );

    $response["success"] = true;

    $response["data"] = [

        "total_unidades" => $totalUnidades,
        "disponibles" => $disponibles,
        "en_uso" => $totalUnidades - $disponibles,

        "rentadas" => obtenerTotal($conexion,
            "SELECT COUNT(*) total FROM unidades WHERE id_estado_unidad = 3"
        ),

        "corralon" => obtenerTotal($conexion,
            "SELECT COUNT(*) total FROM unidades WHERE id_estado_unidad = 8"
        ),

        "siniestradas" => obtenerTotal($conexion,
            "SELECT COUNT(*) total FROM unidades WHERE id_estado_unidad = 5"
        ),

        /*
        =========================================================
        🔥 FLUJO REAL DE CONTRATOS (SIN DOBLE CONTEO)
        =========================================================
        */

        // 1. Pendientes (no existe nada)
        "contratos_pendientes" => obtenerTotal($conexion,
            "SELECT COUNT(*) total
             FROM asignacion_unidad_demo
             WHERE estado = 1
             AND (archivo_comodato_sin_firmar IS NULL OR archivo_comodato_sin_firmar = '')
             AND (archivo_comodato_firmado IS NULL OR archivo_comodato_firmado = '')"
        ),

        // 2. Jurídico (subido pero no firmado)
        "contratos_juridico" => obtenerTotal($conexion,
            "SELECT COUNT(*) total
             FROM asignacion_unidad_demo
             WHERE estado = 1
             AND archivo_comodato_sin_firmar IS NOT NULL
             AND archivo_comodato_sin_firmar <> ''
             AND (archivo_comodato_firmado IS NULL OR archivo_comodato_firmado = '')"
        ),

        // 3. Firmados (finalizado)
        "contratos_firmados" => obtenerTotal($conexion,
            "SELECT COUNT(*) total
             FROM asignacion_unidad_demo
             WHERE estado = 1
             AND archivo_comodato_firmado IS NOT NULL
             AND archivo_comodato_firmado <> ''"
        )

    ];

} catch (Exception $e) {
    $response["message"] = $e->getMessage();
}

echo json_encode($response);