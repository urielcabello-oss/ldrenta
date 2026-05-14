<?php
include("../../../conexion.php");

// Obtener parámetros
$id_unidad = isset($_GET['id_unidad']) ? intval($_GET['id_unidad']) : 0;
$id_mantenimiento = isset($_GET['id_mantenimiento']) ? intval($_GET['id_mantenimiento']) : 0;

$sql = "SELECT 
            m.id_mantenimiento,
            m.id_unidad,
            m.id_estatus_mantenimiento,
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
            m.taller,
            m.costo_estimado,
            m.descripcion_trabajo,
            m.factura,
            m.proximo_km,
            m.proximo_fecha
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
        WHERE u.id_tipo_unidad IN (1, 2, 4)";

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
?>