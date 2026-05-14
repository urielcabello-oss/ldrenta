<?php
include("../../Servidor/conexion.php");
if (!isset($_SESSION)) { session_start(); }

$colaborador_jefe = $_SESSION['id_colaborador']; // ID del colaborador que es jefe directo

// Consultar solicitudes pendientes para este jefe directo
$sql_asignaciones_jefe = "
SELECT 
    aud.id_asignacion_unidad_demo,
    aud.id_unidad,
    aud.id_colaborador_que_asigna,
    aud.id_persona_fisica,
    aud.id_persona_moral,
    aud.autorizacion AS autorizacion_general,
    aud.id_autorizacion_jefe_directo,
    aud.fecha_prestamo,
    aud.fecha_devolucion,
    unid.img_unidad,
    unid.placa,
    model.nombre_modelo,
    pf.nombre_1 AS nombre1_pf,
    pf.nombre_2 AS nombre2_pf,
    pf.apellido_paterno AS apaterno_pf,
    pf.apellido_materno AS amaterno_pf,
    pm.organizacion_institucion AS nombre_moral,
    ca.nombre_1 AS nombre1_colaborador,
    ca.nombre_2 AS nombre2_colaborador,
    ca.apellido_paterno AS apellidop_colaborador,
    ca.apellido_materno AS apellidom_colaborador,
    usr.avatar AS avatar_colaborador
FROM asignacion_unidad_demo AS aud
INNER JOIN jefes_directos AS jd ON aud.id_autorizacion_jefe_directo = jd.id_jefe_directo
INNER JOIN colaboradores AS ca ON aud.id_colaborador_que_asigna = ca.id_colaborador
LEFT JOIN unidades AS unid ON aud.id_unidad = unid.id_unidad
LEFT JOIN modelos AS model ON unid.id_modelo = model.id_modelo
LEFT JOIN personas_fisicas AS pf ON aud.id_persona_fisica = pf.id_persona_fisica
LEFT JOIN personas_morales AS pm ON aud.id_persona_moral = pm.id_persona_moral
INNER JOIN usuarios AS usr ON ca.id_colaborador = usr.id_colaborador
WHERE jd.id_colaborador = '$colaborador_jefe'  -- Solo solicitudes de sus subordinados
  AND aud.autorizacion = 'PENDIENTE'           -- Pendientes de autorización del jefe directo
ORDER BY aud.id_asignacion_unidad_demo DESC
";

$resultado = $conexion->query($sql_asignaciones_jefe);

echo '<div class="table-responsive">
        <table class="table table-hover tablaunidades" id="tablaUnidades">
            <thead class="table-light">
                <tr>
                    <th class="letratablajefedirecto"><i class="fas fa-user"></i> Usuario / Institución</th>
                    <th class="letratablajefedirecto"><i class="fas fa-car-side"></i> Modelo</th>
                    <th class="letratablajefedirecto"><i class="fas fa-car"></i> Placa</th>
                    <th class="letratablajefedirecto"><i class="fas fa-calendar"></i> Asignación</th>
                    <th class="letratablajefedirecto"><i class="fas fa-undo-alt me-2""></i>Devolución</th>
                    <th class="letratablajefedirecto"><i class="fas fa-user-tie me-2""></i>Solicitante</th>
                    <th class="letratablajefedirecto"><i class="fas fa-ellipsis-h"></i>Acción</th>
                </tr>
            </thead>
            <tbody>';

while ($fila = $resultado->fetch_assoc()) {
    $usuario = !empty($fila['id_persona_fisica'])
                ? $fila['nombre1_pf'] . ' ' . $fila['nombre2_pf'] . ' ' . $fila['apaterno_pf'] . ' ' . $fila['amaterno_pf']
                : $fila['nombre_moral'];

    $solicitante = $fila['nombre1_colaborador'] . ' ' . $fila['nombre2_colaborador'] . ' ' . $fila['apellidop_colaborador'] . ' ' . $fila['apellidom_colaborador'];

    $avatar = empty($fila["avatar_colaborador"])
                ? "../../Cliente/img/iconos/default_avatar.png"
                : "https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/" . $fila["avatar_colaborador"] . ".png";

    echo '<tr>
            <td class="letratablajefedirecto">' . $usuario . '</td>
            <td class="letratablajefedirecto">' . $fila['nombre_modelo'] . '</td>
            <td class="letratablajefedirecto">' . $fila['placa'] . '</td>
            <td class="letratablajefedirecto">' . $fila['fecha_prestamo'] . '</td>
            <td class="letratablajefedirecto">' . ($fila['fecha_devolucion'] != '0000-00-00' ? $fila['fecha_devolucion'] : '') . '</td>
            <td class="letratablajefedirecto" style="text-align: center;">
                <img src="' . $avatar . '" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;" alt="avatar">
                ' . $solicitante . '
            </td>
            <td class="letratablajefedirecto">
                <button type="button" class="btn btn-sm btn-verunidad_autorizar btnMosrarModalUnidad" 
                    data-idunidad="' . $fila['id_unidad'] . '" 
                    data-id_asignacion_demo="' . $fila['id_asignacion_unidad_demo'] . '" 
                    data-id_persona_fisica="' . $fila['id_persona_fisica'] . '" 
                    data-id_persona_moral="' . $fila['id_persona_moral'] . '">
                    Verificar
                </button>
            </td>
          </tr>';
}

echo '</tbody>
      </table>
      </div>';
?>
