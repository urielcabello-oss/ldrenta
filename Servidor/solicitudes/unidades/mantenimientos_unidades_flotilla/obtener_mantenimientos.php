<?php
include("../../../conexion.php");

// Obtener parámetros
$id_unidad = isset($_GET['id_unidad']) ? intval($_GET['id_unidad']) : 0;
$id_mantenimiento = isset($_GET['id_mantenimiento']) ? intval($_GET['id_mantenimiento']) : 0;

$sql = "SELECT
            m.id_mantenimiento,
            m.id_unidad,
            m.id_estatus_mantenimiento,
            m.id_taller,

            u.vin,
            u.ultimo_kilometraje,

            m.km_actual,
            m.km_manual,

            mo.nombre_modelo AS modelo,
            ma.nombre_marca AS marca,

            tm.id_tipo_mantenimiento,
            tm.nombre_tipo_mantenimiento AS tipo,

            em.estatus,

            m.fecha_ingreso,
            m.fecha_salida,

            m.costo_estimado,
            m.descripcion_trabajo,
            m.factura,

            m.proximo_km,
            m.proximo_fecha,

            t.nombre_taller,

            m.foto_tarjeta_circulacion,
            m.foto_odometro,
            m.foto_llanta,
            m.foto_desgaste,

            /* SUPERVISOR */
            CONCAT(
                col.nombre_1, ' ',
                IFNULL(col.nombre_2, ''), ' ',
                col.apellido_paterno, ' ',
                IFNULL(col.apellido_materno, '')
            ) AS supervisor,

            /* CLIENTE */
            CASE
                WHEN pf.id_persona_fisica IS NOT NULL THEN
                    CONCAT(
                        pf.nombre_1, ' ',
                        IFNULL(pf.nombre_2, ''), ' ',
                        pf.apellido_paterno, ' ',
                        IFNULL(pf.apellido_materno, '')
                    )

                WHEN pm.id_persona_moral IS NOT NULL THEN
                    pm.organizacion_institucion

                ELSE 'Sin asignar'
            END AS cliente

        FROM mantenimientos_flotilla m

        INNER JOIN tipo_mantenimiento tm
            ON m.id_tipo_mantenimiento = tm.id_tipo_mantenimiento

        INNER JOIN estatus_mantenimiento em
            ON m.id_estatus_mantenimiento = em.id_estatus_mantenimiento

        INNER JOIN unidades u
            ON m.id_unidad = u.id_unidad

        INNER JOIN modelos mo
            ON u.id_modelo = mo.id_modelo

        INNER JOIN marcas ma
            ON mo.id_marca = ma.id_marca

        LEFT JOIN talleres t
            ON m.id_taller = t.id_taller

        /* SUPERVISOR DE LA UNIDAD */
        LEFT JOIN supervisores s
            ON u.id_supervisor = s.id_supervisor

        LEFT JOIN usuarios usu
            ON s.id_usuario = usu.id_usuario

        LEFT JOIN colaboradores col
            ON usu.id_colaborador = col.id_colaborador

        /* CLIENTE ASIGNADO */
        LEFT JOIN asignacion_unidad_demo aud
            ON u.id_unidad = aud.id_unidad
            AND aud.estado = 1

        LEFT JOIN personas_fisicas pf
            ON aud.id_persona_fisica = pf.id_persona_fisica

        LEFT JOIN personas_morales pm
            ON aud.id_persona_moral = pm.id_persona_moral

        WHERE 1 = 1";

// Filtrar por unidad si se pasa
if ($id_unidad) {
    $sql .= " AND m.id_unidad = $id_unidad";
}

// Filtrar por mantenimiento si se pasa
if ($id_mantenimiento) {
    $sql .= " AND m.id_mantenimiento = $id_mantenimiento";
}

$sql .= " ORDER BY m.fecha_ingreso DESC";

$result = $conexion->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
